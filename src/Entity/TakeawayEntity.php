<?php

namespace App\Entity;

use App\Entity\AbstractSession;
use App\Entity\Takeaway\TakeawayAddressEntity;

class TakeawayEntity extends AbstractEntity
{
    /**
     * The prefix for the entity
     * 
     * Everything will be stored under takeaway in the session
     * 
     * @var string
     */
    public $prefix = 'takeaway';
    
    /**
     * Takeaway address
     * 
     * @var \App\Entity\Takeaway\TakeawayAddress 
     */
    public $address = null;
    
    /**
     * Getters
     */
    
    /**
     * Returns the takeaway name
     * 
     * @return string
     */
    public function getName(){
        return $this->_get('name');
    }
    
    /**
     * Returns the takeaway address
     * 
     * @return \App\Entity\Takeaway\TakeawayAddressEntity
     */
    public function getAddress(){
        return TakeawayAddressEntity::fromArray($this->_get('address'), $this->request);
    }
    
    /**
     * Setters
     */
    
    /**
     * Sets the takeaway name
     * 
     * @param string $name
     * @return App\Entity\TakeawayEntity
     */
    public function setName($name){
        return $this->_set('name', $name);
    }
    
    /**
     * Sets the takeaway address
     * 
     * @param \App\Entity\Takeaway\TakeawayAddressEntity $takeawayAddress
     * @return \App\Entity\TakeawayEntity
     */
    public function setAddress(Takeaway\TakeawayAddressEntity $takeawayAddress){
        $this->_set('address', $takeawayAddress->toArray());
        return $this;
    }
    
}