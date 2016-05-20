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
        
        if(!is_array($items)){
            $items = [];
        }
        
        foreach($items as $key => $item){
            $items[$key] = ItemEntity::fromArray($item);
        }
        
        return $items;
        
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
}