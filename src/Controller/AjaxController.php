<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\I18n\Number;
use App\Entity\Order\ItemEntity;
use App\Entity\Order\OrderItemCondimentEntity;
use App\Form\OrderForm;

/**
 * Order controller
 *
 * This controller will render views from Template/Order/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class AjaxController extends AppController
{

    public function initialize() {
        parent::initialize();
        $this->viewBuilder()->layout(false);
    }

    /**
     * Gets the delivery details for a given postcode
     */
    public function getDeliveryDetailsForPostcode() {

        $success = false;
        $error = 'Please enter a valid UK postcode';
        $details = array();
        $canDeliver = false;

        $postcode = $this->request->data['postcode'];

        if ($postcode != '') {
            $geoLocation = $this->geolocatePostcode($postcode);

            if ($geoLocation !== false) {
                $success = true;
                $error = '';

                $distance = $this->getDistanceBetweenLocations($this->takeaway->getAddress()->getLatitude(), $this->takeaway->getAddress()->getLongitude(), $geoLocation['latitude'], $geoLocation['longitude']);

                $deliveryCost = $this->takeaway->getDeliveryCost($distance);

                $details = array(
                    'postcode' => $geoLocation['postcode'],
                    'cost' => $deliveryCost,
                    'format_cost' => $deliveryCost == false ? false : Number::currency($deliveryCost, $this->takeaway->getCurrency()->getCode())
                );

                if ($deliveryCost != false) {
                    $canDeliver = true;
                }
            }
        }

        $this->set('data', array('data' => array(
            'success' => $success,
            'error' => $error,
            'can_deliver' => $canDeliver,
            'details' => $details
        )));

        $this->render('json');
    }

    /**
     * This function adds an item to the basket
     */
    public function addItem() {

        //set the default response
        $success = false;

        //get the item id from the post data
        $itemId = $this->request->data['item'];
        $variationId = $this->request->data['variation'];
        $section = $this->request->data['section'];
        $notes = $this->request->data['notes'];
        $condiments = $this->request->data['selected-condiment'];

        if ($this->menu->itemExists($itemId, $variationId, $section)) {
            //add this item to the order;
            $this->order->addItem(ItemEntity::fromArray(array('item_id' => $itemId, 'section_id' => $section, 'variation_id' => $variationId, 'notes' => $notes)), $this->request);

            //get the internal order item ID of this item
            $orderItemId = $this->order->getLastOrderItemId();

            //save each condiment to the session
            foreach ($condiments as $type_id => $condiment_id) {
                $this->order->addCondiment($orderItemId, OrderItemCondimentEntity::fromArray(['id' => $condiment_id, 'type_id' => $type_id, 'item_id' => $orderItemId]));
            }

            $success = true;
        }

        $orderForm = new OrderForm($this->request);
        $this->set('order', $orderForm);

        $this->set('data', array(
            'order_total' => Number::currency($this->order->getTotal(), $this->takeaway->getCurrency()->getCode()),
            'success' => $success
        ));
    }

    /**
     * This function removes an item to the basket
     */
    public function removeItem() {

        //set the default response
        $success = true;

        //get the item id from the post data
        $orderItemId = $this->request->data['item'];

        //remove the item
        $this->order->removeItem($orderItemId);

        //remove any condiments
        $this->order->removeCondiments($orderItemId);

        $orderForm = new OrderForm($this->request);
        $this->set('order', $orderForm);

        $this->set('data', array(
            'order_total' => Number::currency($this->order->getTotal(), $this->takeaway->getCurrency()->getCode()),
            'success' => $success
        ));
    }

    /**
     * When an item is selected we display a modal
     * containing the condiments and an input for notes
     */
    public function getItemOptions() {
        //get the posted data
        $item_id = $this->request->data['item'];
        $variation_id = $this->request->data['variation'];

        //get all condiment types along with the condiments
        $condimentTypes = $this->menu->getAllCondimentsForItem($item_id);

        //set what we need to the view
        $this->set('condimentTypes', $condimentTypes);
        $this->set('itemId', $item_id);
        $this->set('variationId', $variation_id);
        $this->set('data', [
            'success' => true
        ]);
    }

    /**
     * Changes the order to a collection order
     */
    public function changeToCollection() {

        //sets the order to a collection order
        if ($this->takeaway->getSettings()->getAcceptCollectionOrders()) {
            $this->order->setType(\App\Entity\TakeawayEntity::ORDER_TYPE_COLLECTION);
        }

        //get the order form for the sidebar
        $orderForm = new OrderForm($this->request);
        $this->set('order', $orderForm);

        //set the response
        $this->set('data', [
            'success' => true
        ]);
    }

    /**
     * Action to check if the session has expired
     */
    public function checkSession() {
        //if the session has timed out
        if ($this->step->hasTimedOut(true)) {
            $timeout = true;
        } else {
            $timeout = false;
        }
        $this->set('data', ['timeout' => $timeout]);
        $this->render('json');
    }

    /**
     * Postcode lookup
     */
    public function postcodeLookup(){
        //get the postcode entered by the user
        $postcode = $this->request->data('postcode');

        //make the api call to get the postcode
        $addressList = $this->Api->postcodeLookup($postcode);

        //set the address list to the view
        $this->set('addressList', $addressList);

        //return success if at least one address has been entered
        $this->set('data', [
            'success' => (count($addressList) > 0) ? true : false
        ]);
    }

}
