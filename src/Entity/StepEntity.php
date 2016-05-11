<?php

namespace App\Entity;

use App\Entity\AbstractSession;

class StepEntity extends AbstractEntity
{
    /**
     * The prefix for the entity
     * 
     * Everything will be stored under step in the session
     * 
     * @var string
     */
    public $prefix = 'step';
    
    /**
     * Sets the current step
     * 
     * @param string $name
     * @return App\Entity\StepEntity
     */
    public function setCurrentStep($name){
        return $this->_set('current_step', $name);
    }
    
    /**
     * Returns the current step
     * 
     * @return string
     */
    public function getCurrentStep(){
        return $this->_get('current_step');
    }
}