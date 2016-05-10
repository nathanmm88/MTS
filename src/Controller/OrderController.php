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

/**
 * Order controller
 *
 * This controller will render views from Template/Order/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class OrderController extends AppController {

    /**
     * Before filter
     * 
     * @param \Cake\Event\Event $event
     */
    public function beforeFilter(\Cake\Event\Event $event) {
        parent::beforeFilter($event);
        //we want to use the order layout
        $this->viewBuilder()->layout('order');
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
            die(var_dump($this->request->data));
        }
    }

    /**
     * Menu page
     * 
     * This will display the menu to the customer to order from
     */
    public function menu() {
        /**
         * Temporarily set some example categories to be replaced with real data
         */
        $categories = array(
            'Starters' => array(
                'description' => 'Here is the list of starters',
                'items' => array(
                    'Prawn Crackers' => array(
                        'price' => 4.5,
                        'description' => '10 Prawn Crackers'
                    ),
                    'Garlic Bread' => array(
                        'price' => 2.25,
                        'description' => '2 Slices of Garlic Bread'
                    ),
                )
            ),
            'Kebabs' => array(
                'description' => 'Here is the list of kebabs',
                'items' => array(
                    'Donner Kebab' => array(
                        'price' => 6.9,
                        'description' => 'Chicken Donner Kebab with Chips'
                    ),
                    'Shish Kebab' => array(
                        'price' => 5.5,
                        'description' => 'Chicken Shish Kebab with Chips'
                    ),
                )
            ),
        );
        $this->set('categories', $categories);
    }

    /**
     * The order confirm page
     */
    public function confirm() {
        
    }

}
