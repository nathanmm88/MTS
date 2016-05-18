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

/**
 * Order controller
 *
 * This controller will render views from Template/Order/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class OrderController extends AppController {

    /**
     * The steps we want to lock down for a diven controller
     * 
     * Default off
     * 
     * @var array 
     */
    public $steps = [
//        'order_index',
//        'order_menu',
//        'order_confirm',
//        'order_thanks'
    ];

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
                $this->request->session()->write('order.order_type', ORDER_TYPE_COLLECTION);
            } else if (array_key_exists(ORDER_TYPE_DELIVERY, $this->request->data)) {
                $this->request->session()->write('order.order_type', ORDER_TYPE_DELIVERY);
            } else {
                throw new Exception('Unable to detect order type from the post');
            }

            //set the delivery postcode anyway
            $this->request->session()->write('order.address.postcode', $this->request->data['delivery_postcode']);

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
        //get the latest menu and save to the session
        $this->Api->getMenu();     

        if ($this->request->is('post')) {

            $this->_redirectToStep('order_confirm');
        }
        $orderForm = new OrderForm($this->request);
        $this->set('order', $orderForm);
    }

    /**
     * The order confirm page
     */
    public function confirm() {
        $confirmationForm = new ConfirmationForm($this->request);
        if ($this->request->is('post')) {
            if ($confirmationForm->execute($this->request->data)) {
                die('success');
            } else {
                
            }
        }
        $this->set('confirmation', $confirmationForm);
    }

}
