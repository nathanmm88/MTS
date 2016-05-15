<?php

namespace App\Entity;

use App\Entity\AbstractSession;
use App\Entity\Order\ItemEntity;

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
     * Returns the order items
     * 
     * @return \App\Entity\Order\ItemEntity
     */
    public function getItems(){
        $items = $this->_get('items');
        return $items;
        
    }
    
    /**
     * Adds an item to the order
     * 
     * @param integer $id
     */
    public function addItem(ItemEntity $item){
        //get the current items
        $items = $this->_get('items');
        
        //if null default to an array
        if (is_null($items)){
            $items = [];
        }
    
        //if this item already exists, update it else add it
        if (array_key_exists($item->getId(), $items)){
            $items[$item->getId()] = $item->toArray();
        } else {
            $items[] = $item->toArray();
        }
        
        //set the items back to the entity
        $this->_set('items', $items);
        
        return $this;        
    }
    
    /**
     * Clear down the order
     */
    public function clear(){
       $this->_set('items', array());
    }
}