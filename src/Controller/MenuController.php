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
class MenuController extends AppController
{

    public $pdfConfig = [];
    
    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }


    /**
     * Displays a view
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
    public function display()
    {
        $this->viewBuilder()->layout('minimal');
        $this->Api->getMenu();
        $this->set('readOnly', true);
    }
    
    /**
     * Downloads the static menu as PDF
     */
    public function download()
    {

        $this->Api->getMenu();
        $this->set('readOnly', true);

        $this->viewBuilder()->options([
            'pdfConfig' => [
                'orientation' => 'portrait',
                'filename' => 'menu_' . date('Y_m_d_H_s') . '.pdf'
            ]
        ]);
        
        
    }
}
