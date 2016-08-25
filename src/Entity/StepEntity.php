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
    
    /**
     * Returns the valid moves
     * 
     * @return array
     */
    public function getValidMoves(){
        $validMoves = $this->_get('valid_moves');
        return !is_array($validMoves) ? [] : $validMoves;
    }
    
    /**
     * Sets the valid moves
     * 
     * @param string $validMoves
     * @return App\Entity\StepEntity
     */
    public function setValidMoves($validMoves){
        $this->_set('valid_moves', $validMoves);
        return $this;
    }
    
    /**
     * Adds a valid move to the session
     * 
     * @param string $currentStep
     * @param string $newStep
     * @return App\Entity\StepEntity
     */
    public function addValidMove($currentStep, $newStep){
        $validMoves = $this->getValidMoves();
        if(!array_key_exists($currentStep, $validMoves)){
            $validMoves[$currentStep] = [];
        }
        $validMoves[$currentStep][$newStep] = $newStep;
        $this->setValidMoves($validMoves);
        return $this;
    }
    
    /**
     * Checks to make sure a move is a valid on
     * 
     * @param string $from
     * @param string $to
     * @return boolean
     */
    public function isValidMove($from, $to){
        $return = false;
        
        $validMoves = $this->getValidMoves();

        if(array_key_exists($from, $validMoves) && array_key_exists($to, $validMoves[$from])){
            $return = true;
        }
        
        return $return;
    }
    
    /**
     * Sets the last accessed time
     * 
     * @param int $time the time we want to set
     * @return \App\Entity\StepEntity
     */
    public function setLastAccessed($time = null){
        
        if(is_null($time)){
            $time = time();
        }
        
        $this->_set('last_accessed', $time);
        return $this;
    }
    
    /**
     * Returns the last accessed time
     * 
     * @return int
     */
    public function getLastAccessed(){
        return $this->_get('last_accessed');
    }
    
    /**
     * Checks if the session has timed out
     * 
     * @param boolean $updateTime if we want to update the time after checking
     * @return boolean
     */
    public function hasTimedOut($updateTime = false){
        $return = false;        
        
        if(($this->getLastAccessed()) && (($this->getLastAccessed() + (\Cake\Core\Configure::read('timeout') * 60)) < time())){
            $return = true;
        }
        
        if($updateTime === true && $return === false){
            $this->setLastAccessed();
        }
        
        return $return;
    }
}