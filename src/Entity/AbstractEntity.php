<?php

namespace App\Entity;

use App\Network\TakeawayRequest;
use App\Lib\Functions;

abstract class AbstractEntity {

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
    public function __construct(TakeawayRequest $request = null) {
        if(!is_null($request)){
            $this->request = $request;
        }
    }

    /**
     * Sets the data to the given index
     * 
     * @param string $name
     * @param mixed $value
     * @return \App\Entity\AbstractEntity
     */
    protected function _set($name, $value) {
        $this->request->session()->write($this->prefix . '.' . $name, $value);
        return $this;
    }

    /**
     * Gets the data for a given index
     * 
     * @param string $name
     * @return mixed
     */
    protected function _get($name) {
        return $this->request->session()->read($this->prefix . '.' . $name);
    }

    /**
     * Returns the object as an array
     * 
     * This will need to be extended for objects that contain objects
     * 
     * @return array
     */
    public function toArray() {
        $return = [];
        foreach ($this as $property => $value) {
            if($property != 'request'
                    && $property != 'prefix'){
                $return[$property] = $value;
            }
        }
        return $return;
    }

    /**
     * Returns the entity populated from array
     * 
     * @return \App\Entity\AbstractEntity
     */
    public static function fromArray($data, $request = null) {
        $obj = new static($request);
        //set the data before returning
        foreach($data as $property => $value){
            $function = 'set' . Functions::underscoreToCamelCase($property, true);
            $obj->$function($value);
        }
        return $obj;
    }
    
    /**
     * Appends the given entity to it's sub-prefix in the session
     */
    public function _saveArray() {     
        //get the current values in the sub prefix
        $values = $this->_get($this->sub_prefix);
        
        //append this entity to the current values
        $values[] = $this->toArray();
        
        //set this back to the session
        $this->_set($this->sub_prefix,$values);       
    }
    
    /**
     * Clears down the session for this prefix
     */
    public function _clear(){
        $this->request->session()->write($this->prefix, '');
    }     
    
    /**
     * Gets all data for a given prefix/sub-prefix
     * 
     * @return mixed
     */
    public function _getAll() {
        if (!is_null($this->sub_prefix)){
            return $this->request->session()->read($this->prefix . '.' . $this->sub_prefix);
        } else {
            return $this->request->session()->read($this->prefix);
        }
        
    }

}
