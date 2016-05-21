<?php

namespace App\Entity\Order;

use App\Entity\Takeaway\TakeawayAddressEntity;

class OrderAddressEntity extends TakeawayAddressEntity
{
    /**
     * The prefix for the entity
     * 
     * Everything will be stored under order => address in the session
     * 
     * @var string
     */
    public $prefix = 'order.address';
    
    /**
     * The delivery cost
     * 
     * @var float 
     */
    public $delivery_cost = false;
    
    /**
     * If the address is out of range it will return false
     * 
     * @return boolean
     */
    public function canDeliver(){
        return $this->getDeliveryCost() === false ? false : true;
    }
    
    /**
     * Returns the delivery cost
     * 
     * @return float
     */
    public function getDeliveryCost() {
        return $this->delivery_cost;
    }

    /**
     * Sets the delivery cost
     * 
     * @param float $delivery_cost
     * @return \App\Entity\Order\OrderAddressEntity
     */
    public function setDeliveryCost($delivery_cost) {
        $this->delivery_cost = $delivery_cost;
        return $this;
    }


}