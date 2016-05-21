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


/**
 * Step controller
 *
 * This controller will render views from Template/Order/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class StepController extends AppController {

    /**
     * Move to the supplied step
     * 
     * @param string $stepName
     * @throws Exception
     */
    public function move($stepName){

        if($this->step->isValidMove($this->step->getCurrentStep(), $stepName)){
            $this->_redirectToStep($stepName);
        } else {
            throw new Exception('Illegal move from ' . $this->current_step . ' to ' . $stepName);
        }
    }

}
