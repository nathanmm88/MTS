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

/**
 * Order controller
 *
 * This controller will render views from Template/Order/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class AjaxController extends AppController {



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


                $distance = $this->getDistanceBetweenLocations(Configure::read('takeaway.contact_details.lat'), Configure::read('takeaway.contact_details.long'), $geoLocation['latitude'], $geoLocation['longitude']);

                $deliveryCost = $this->getDeliveryCost($distance);

                $details = array(
                    'postcode' => $geoLocation['postcode'],
                    'cost' => $deliveryCost,
                    'format_cost' => $deliveryCost == false ? false : Number::currency($deliveryCost, Configure::read('takeaway.order_settings.currency'))
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
        /**
         * Add the item
         */
        
        $success = true;
        $this->set('data', array(
            'success' => $success
        ));
    }

}
