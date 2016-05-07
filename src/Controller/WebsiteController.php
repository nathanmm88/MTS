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
 * Website controller
 *
 * This controller will render views from Template/Website/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class WebsiteController extends AppController
{

    /**
     * Displays a view
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
    public function display()
    {
        /**
         * First check if the takeaway has a website
         * if they dont then send them onto the ordering system and the request
         * will be handles from there
         */
        if((bool)Configure::read('takeaway.website') !== true){
            $this->redirect(['controller' => 'order', 'action' => 'index']);
        } else {
            die('TODO:: add in the website builder');
        }

    }
}
