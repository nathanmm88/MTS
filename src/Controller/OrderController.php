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
use App\Form\ConfirmationForm;
use App\Form\OrderForm;
use App\Entity\Order\ItemEntity;
use App\Entity\Order;
use App\Entity\Order\OrderAddressEntity;
use App\Email\ConfirmationEmail;
use Cake\Mailer\MailerAwareTrait;

/**
 * Order controller
 *
 * This controller will render views from Template/Order/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class OrderController extends AppController {

    use MailerAwareTrait;

    /**
     * The steps we want to lock down for a diven controller
     * 
     * Default off
     * 
     * @var array 
     */
    public $steps = [
        'order_index',
        'order_menu',
        'order_confirm',
        'order_thanks'
    ];

    /**
     * The default step that should be used if the user has no step yet
     * 
     * @var string
     */
    public $default_step = 'order_start';

    /**
     * Before filter
     * 
     * @param \Cake\Event\Event $event
     */
    public function beforeFilter(\Cake\Event\Event $event) {
        parent::beforeFilter($event);
        //we want to use the order layout
        $this->viewBuilder()->layout('order');

        $this->_checkStep();
        $this->step->setLastAccessed();
    }

    /**
     * The first step thats called - clears the session and redirects to the
     * order_index step
     */
    public function start() {
        //clear the session
        $this->request->session()->destroy();
        //$this->request->session()->clearDomain();
        //set the last accessed time
        $this->step->setLastAccessed();

        //redirect to the first step
        $this->_redirectToStep('order_index');
    }

    /**
     * Order index page
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
    public function index() {
        //we want to use the minimal layout
        $this->viewBuilder()->layout('minimal');

        if ($this->request->is('post')) {
            //TODO:: move to a form
            if (array_key_exists(ORDER_TYPE_COLLECTION, $this->request->data)) {
                $this->order->setType(ORDER_TYPE_COLLECTION);
            } else if (array_key_exists(ORDER_TYPE_DELIVERY, $this->request->data)) {
                $this->order->setType(ORDER_TYPE_DELIVERY);
                //get the lat long to store against the delivery
                $geoLocation = $this->geolocatePostcode($this->request->data['delivery_postcode']);

                //set the delivery postcode anyway
                $this->order->setAddress(OrderAddressEntity::fromArray(
                                [
                                    'postcode' => $this->request->data['delivery_postcode'],
                                    'latitude' => $geoLocation['latitude'],
                                    'longitude' => $geoLocation['longitude'],
                                    'delivery_cost' => $this->takeaway->getDeliveryCost($this->getDistanceBetweenLocations($this->takeaway->getAddress()->getLatitude(), $this->takeaway->getAddress()->getLongitude(), $geoLocation['latitude'], $geoLocation['longitude']))
                                ]
                ));
            } else {
                throw new Exception('Unable to detect order type from the post');
            }

            //redirect to the next step
            $this->_redirectToStep('order_menu');
        }
    }

    /**
     * Menu page
     * 
     * This will display the menu to the customer to order from
     */
    public function menu() {
//pr($_SESSION);
        //get the latest menu and save to the session
        $this->Api->getMenu();

        if ($this->request->is('post')) {

            $this->_redirectToStep('order_confirm');
        }
        $orderForm = new OrderForm($this->request);
        $this->set('order', $orderForm);
    }

    /**
     * The basket page
     */
    public function basket() {

        if ($this->request->is('post')) {

            $this->_redirectToStep('order_confirm');
        }
        $orderForm = new OrderForm($this->request);
        $this->set('order', $orderForm);

        //make sure we dont render the basket in the hidden sidebar
        $this->set('noSidebar', true);
    }

    /**
     * The order confirm page
     */
    public function confirm() {
        $confirmationForm = new ConfirmationForm($this->request);
        if ($this->request->is('post')) {
            if ($this->order->isValidOrder()) {
                if ($confirmationForm->execute($this->request->data)) {
                    //create the order
                    $this->Api->createOrder();

                    /*try {
                        $this->getMailer('Order')->send('confirmation', [$this->order, $this->menu]);
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }   */
                    
                    //all good so redirect to the thank you page
                    $this->_redirectToStep('order_thanks');
                } else {
                    
                }
            }
        }
        $this->set('confirmation', $confirmationForm);
    }
    
    /**
     * The thank you page
     * 
     */
    public function thanks(){
        //make sure we dont render the basket on this page
        $this->set('noSidebar', true);
    }

}
