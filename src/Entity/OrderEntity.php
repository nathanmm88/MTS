<?php

namespace App\Entity;

use App\Entity\AbstractSession;
use App\Entity\Order\ItemEntity;
use App\Entity\Order\OrderAddressEntity;
use App\Entity\MenuEntity;
use App\Entity\TakeawayEntity;

class OrderEntity extends AbstractEntity
{
    /**
     * The prefix for the entity
     * 
     * Everything will be stored under order in the session
     * 
     * @var string
     */
    public $prefix = 'order';
    
    /**
     * An array of items for this order
     * 
     * @var type array
     */
    public $items = array();
    
    /**
     * Order type
     * 
     * @var type string
     */
    public $type = '';
    
    /**
     * Order address
     * 
     * @var \App\Entity\Order\OrderAddressEntity
     */
    public $address = '';
    
    /**
     * First name
     * 
     * @var string
     */
    public $first_name = '';
    
    /**
     * Surname
     * 
     * @var string
     */
    public $surname = '';
    
    /**
     * Fhone
     * 
     * @var string
     */
    public $telephone = '';
    
    /**
     * Email address
     * 
     * @var string
     */
    public $email = '';
    
    /**
     * Returns the order items
     * 
     * @return \App\Entity\Order\ItemEntity
     */
    public function getItems(){
        $items = $this->_get('items');
        
        if(!is_array($items)){
            $items = [];
        }
        
        foreach($items as $key => $item){
            $items[$key] = ItemEntity::fromArray($item);
        }
        
        return $items;
        
    }
    
    /**
     * Returns the order type
     * 
     * @return string
     */
    public function getType() {
        return $this->_get('type');
    }
    
    /**
     * Checks if a supplied type is the current order type
     * 
     * @param string $type
     * @return boolean
     */
    public function isType($type){
        return $this->getType() == $type ? true : false;
    }
    
    /**
     * Checks if this is a delivery
     * 
     * @return boolean
     */
    public function isDelivery(){
        return $this->isType(TakeawayEntity::ORDER_TYPE_DELIVERY);
    }
    
    /**
     * Returns the order address
     * 
     * @return \App\Entity\Order\OrderAddressEntity
     */
    public function getAddress() {
        return OrderAddressEntity::fromArray($this->_get('address'), $this->request);
    } 
        
    /**
     * Adds an item to the order
     * 
     * @param ItemEntity $item
     * @return \App\Entity\OrderEntity
     */
    public function addItem(ItemEntity $item){
        //get the current items
        $items = $this->_get('items');
        
        //if null default to an array
        if (is_null($items)){
            $items = [];
        }
    
        $items[] = $item->toArray();
        
        //set the items back to the entity
        $this->_set('items', $items);
        
        return $this;        
    }
    
    /**
     * Removes an order item from a specific index
     * 
     * @param int $index 
     * @return \App\Entity\OrderEntity
     */
    public function removeItem($index){
        //get the current items
        $items = $this->_get('items');
        
        if(is_array($items) && array_key_exists($index, $items)){
            unset($items[$index]);
        }
        
        //set the items back to the entity
        $this->_set('items', $items);
        
        return $this;
    }
    
    /**
     * Returns the first name
     * 
     * @return string
     */
    public function getFirstName() {
        return $this->_get('first_name');
    }

    /**
     * Surname
     * 
     * @return string
     */
    public function getSurname() {
        return $this->_get('surname');
    }

    /**
     * Returns the telephone
     * 
     * @return string
     */
    public function getTelephone() {
        return $this->_get('telephone');
    }

    /**
     * Returns the email
     * 
     * @return string
     */
    public function getEmail() {
        return $this->_get('email');
    }

        
    /**
     * Sets the order type
     * 
     * @param string $type
     * @return \App\Entity\OrderEntity
     */
    public function setType($type) {
        $this->_set('type', $type);
        return $this;
    }
    
    /**
     * Returns the takeaway address
     * 
     * @param \App\Entity\Order\OrderAddressEntity $address
     * @return \App\Entity\OrderEntity
     */
    public function setAddress(OrderAddressEntity $address){
        $this->_set('address', $address->toArray());
        return $this;
    }
    
    /**
     * Sets the first name
     * 
     * @param string $first_name
     * @return \App\Entity\OrderEntity
     */
    public function setFirstName($first_name) {
        $this->_set('first_name', $first_name);
        return $this;
    }

    /**
     * Sets the surname
     * 
     * @param string $surname
     * @return \App\Entity\OrderEntity
     */
    public function setSurname($surname) {
        $this->_set('surname', $surname);
        return $this;
    }

    /**
     * Sets the telephone
     * @param type $telephone
     * @return \App\Entity\OrderEntity
     */
    public function setTelephone($telephone) {
        $this->_set('telephone', $telephone);
        return $this;
    }

    /**
     * Sets the email
     * 
     * @param string $email
     * @return \App\Entity\OrderEntity
     */
    public function setEmail($email) {
        $this->_set('email', $email);
        return $this;
    }

    /**
     * Returns the order total 
     * 
     * @param boolean $includeExtras
     * @return float
     */    
    public function getTotal($includeExtras = true){
        
        //default to zero
        $total = 0;
        //get all the items
        $items = $this->getItems();
        //get the entity for accessing the session
        $menuEntity = new MenuEntity($this->request);
        //as long as we have items
        if(count($items) > 0){
            foreach($items as $orderItem){
                $item = $menuEntity->getItem($orderItem->getItemId(), $orderItem->getVariationId());
                $total += $item->getPrice();
            }
        }
        
        //now add any extrad like delivery etc
        if($includeExtras === true){
            //if we are on delivery add the delivery cost
            if($this->isDelivery()){
                $total += $this->getAddress()->getDeliveryCost();
            }
        }
        
        //return the total
        return $total;
    }
    
    /**
     * Checks if the supplied total or session total meets the minimum amount
     * 
     * @param float $subTotal
     * @return boolean
     */
    public function meetsMinimumOrderAmount($subTotal = null){
        
        //default return value
        $return = false;
        
        //get the subtotal if one wasnt supplied
        if(is_null($subTotal)){
            $subTotal = $this->getTotal(false);
        }
        
        //get the takeaway entity
        $takeawayEntity = new TakeawayEntity($this->request);
        
        //check against the delivery
        if($this->isDelivery()){
            if($subTotal >= $takeawayEntity->getSettings()->getDeliveryMinOrder()){
                $return = true;
            }
        } else {
            if($subTotal >= $takeawayEntity->getSettings()->getCollectionMinOrder()){
                $return = true;
            }
        }
        
        //return the result
        return $return;
        
    }
    
    /**
     * Returns the estimated delivery time, if format is false the date time 
     * object is returned
     * 
     * @param string|false $format
     * @return string|DateTime
     */
    public function getEstimatedTime($format = 'Y-m-d H:i:s'){
        
        //get the takeaway entity
        $takeawayEntity = new TakeawayEntity($this->request);
        
        //the time we want to add to the current time
        $delay = false;
        
        //check if we are on delivery
        if($this->isDelivery()){
            $delay = $takeawayEntity->getSettings()->getCurrentDeliveryTime();
        } else {
            $delay = $takeawayEntity->getSettings()->getCurrentCollectionTime();
        }
        
        //if we have a delay then make the date time object
        if($delay !== false){
            $delay = $delay * 60; //convert from minutes to seconds
            $dateTime = new \DateTime();
            $delay = $dateTime->setTimestamp(time() + (int) $delay);
        }

        return $format === false ? $delay : $delay->format($format);
    }
    
    /**
     * Checks is an order can be processed
     * 
     * this can be used to add a disabled class 
     * 
     * @return boolean
     */
    public function isValidOrder(){
        
        //default return
        $return = true;
        
        //get the takeaway entity as we need to access the settings
        $takeawayEntity = new TakeawayEntity($this->request);
        
        //get the sub total before delivery
        $total = $this->getTotal(false);
        
        //add any delivery specific checks
        if($this->isType(TakeawayEntity::ORDER_TYPE_DELIVERY)){
            //check we are accepting delivery orders
            if(!$takeawayEntity->getSettings()->getAcceptDeliveryOrders()){
                $return = false;
            }
            //now lets check we meet the minimum order amount
            if($takeawayEntity->getSettings()->getDeliveryMinOrder() < $total){
                $return = false;
            }
        } else if($this->isType(TakeawayEntity::ORDER_TYPE_COLLECTION)){
            //add any collection specific checks
            //check we are accepting delivery orders
            if(!$takeawayEntity->getSettings()->getAcceptCollectionOrders()){
                $return = false;
            }
            //now lets check we meet the minimum order amount
            if($takeawayEntity->getSettings()->getCollectionMinOrder() < $total){
                $return = false;
            }
        }
        
        //return our result
        return $return;
    }
}