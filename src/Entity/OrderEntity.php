<?php

namespace App\Entity;

use App\Entity\AbstractSession;
use App\Entity\Order\ItemEntity;
use App\Entity\Order\OrderAddressEntity;
use App\Entity\MenuEntity;

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
}