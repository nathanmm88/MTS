<?php

namespace App\Entity;

use App\Entity\AbstractSession;
use App\Entity\Takeaway\TakeawayAddressEntity;
use App\Entity\Takeaway\CurrencyEntity;

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
     * Takeaway ID
     * 
     * @var int
     */
    protected $id = null;
    
    /**
     * Takeaway address
     * 
     * @var \App\Entity\Takeaway\TakeawayAddress 
     */
    protected $address = null;
    
    /**
     * Takeaway telephone
     * 
     * @var string
     */
    protected $telephone = null;
    
    /**
     * Takeaway email
     * 
     * @var string
     */
    protected $email = null;
    
    /**
     * Takeaway currency
     * 
     * @var App\Entity\Takeaway\CurrencyEntity
     */
    protected $currency = null;
    
    /**
     * Getters
     */
    
    /**
     * Returns the takeaway ID
     * 
     * @return string
     */
    public function getId(){
        return $this->_get('id');
    }
    
    /**
     * Returns the takeaway name
     * 
     * @return string
     */
    public function getName(){
        return $this->_get('name');
    }
    
    /**
     * Returns the takeaway telephone number
     * 
     * @return string
     */
    public function getTelephone(){
        return $this->_get('telephone');
    }
    
    /**
     * Checks if the takeaway has a telephone number
     * 
     * @return boolean
     */
    public function hasTelephone(){
        return is_null($this->getTelephone()) ? false : true;
    }
    
    /**
     * Returns the takeaway email address
     * 
     * @return string
     */
    public function getEmail(){
        return $this->_get('email');
    }
    
    /**
     * Checks if the takeaway has an email address
     * 
     * @return boolean
     */
    public function hasEmail(){
        return is_null($this->getEmail()) ? false : true;
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
     * Returns the tcurrency
     * 
     * @return \App\Entity\Takeaway\CurrencyEntity
     */
    public function getCurrency(){
        return CurrencyEntity::fromArray($this->_get('currency'), $this->request);
    }
    
    /**
     * Setters
     */
    
    /**
     * Sets the takeaway ID
     * 
     * @param int $id
     * @return App\Entity\TakeawayEntity
     */
    public function setId($id){
        $this->_set('id', $id);
        return $this;
    }
    
    /**
     * Sets the takeaway name
     * 
     * @param string $name
     * @return App\Entity\TakeawayEntity
     */
    public function setName($name){
        $this->_set('name', $name);
        return $this;
    }
    
    /**
     * Sets the takeaway name
     * 
     * @param string $telephone
     * @return string
     */
    public function setTelephone($telephone){
        $this->_set('telephone', $telephone);
        return $this;
    }
    
    /**
     * Sets the takeaway email address
     * 
     * @param string $email
     * @return string
     */
    public function setEmail($email){
        $this->_set('email', $email);
        return $this;
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
    
    /**
     * Sets the currency
     * 
     * @param \App\Entity\Takeaway\CurrencyEntity $currency
     * @return \App\Entity\TakeawayEntity
     */
    public function setCurrency(CurrencyEntity $currency){
        $this->_set('currency', $currency->toArray());
        return $this;
    }
    
}