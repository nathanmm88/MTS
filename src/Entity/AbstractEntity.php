<?php

namespace App\Entity;

use App\Network\TakeawayRequest;

abstract class AbstractEntity
{
    
    /**
     * Takeaway Request
     * 
     * @var App\Network\TakeawayRequest
     */
    public $request = null;
    
    /**
     * The prefix for the entity
     * 
     * @var string
     */
    public $prefix = '';
    
    /**
     * Constructor
     * 
     * @param App\Network\TakeawayRequest $request
     */
    public function __construct(TakeawayRequest $request) {
        $this->request = $request;
    }
    
    /**
     * Sets the data to the given index
     * 
     * @param string $name
     * @param mixed $value
     * @return \App\Entity\AbstractEntity
     */
    protected function _set($name, $value){
        $this->request->session()->write($this->prefix . '.' . $name, $value);
        return $this;
    }
    
    /**
     * Gets the data for a given index
     * 
     * @param string $name
     * @return mixed
     */
    protected function _get($name){
        return $this->request->session()->read($this->prefix . '.' . $name);
    }
}