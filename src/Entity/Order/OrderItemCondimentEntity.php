<?php

namespace App\Entity\Order;
use App\Entity\AbstractEntity;

class OrderItemCondimentEntity extends AbstractEntity
{
    /**
     * The prefix for the entity
     * 
     * Everything will be stored under order => condiments in the session
     * 
     * @var string
     */
    public $prefix = 'order.condiments';
    
    /**
     * The condiment id
     * 
     * @var float 
     */
    public $id = null;
    
    /**
     * The condiment type id
     * 
     * @var float 
     */
    public $type_id = null;
    
    /**
     * The item ID
     * 
     * @var id
     */
    public $item_id = null;
       
    
    /**
     * Returns the condiment id
     * 
     * @return int
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * Returns the condiment type id
     * 
     * @return int
     */
    public function getTypeId(){
        return $this->type_id;
    }
    
    /**
     * Returns the item ID
     * 
     * @return id
     */
    public function getItemId(){
        return $this->item_id;
    }

    /**
     * Sets the condiment ID
     * 
     * @param type $id
     * @return \App\Entity\Order\OrderItemCondimentEntity
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    /**
     * Set the condiment type ID
     * 
     * @param type $type_id
     * @return \App\Entity\Order\OrderItemCondimentEntity
     */
    public function setTypeId($type_id){
        $this->type_id = $type_id;
        return $this;
    }

    /**
     * Sets the item ID
     * 
     * @param type $item_id
     * @return \App\Entity\Order\OrderItemCondimentEntity
     */
    public function setItemId($item_id){
        $this->item_id = $item_id;
        return $this;
    }

}