<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Core\Configure;

class StepHelper extends Helper {
    
    /**
     * Load the helpers we want
     * 
     * @var array 
     */
    public $helpers = ['Entity'];
   
    /**
     * Returns a link and also adds to the session to authenticate the move
     * 
     * @param string $stepName
     * @return string
     */
    public function getStepLink($stepName){
        
        $this->Entity->get('Step')->addValidMove(strtolower($this->request->controller . '_' . $this->request->action), $stepName);
        
        return $this->getBasePath() . '/step/move/' . $stepName;
    }
    
    /**
     * Returns the base path
     * 
     * @return string
     */
    public function getBasePath(){
        return 'http://' . $this->request->host();
    }
}
    