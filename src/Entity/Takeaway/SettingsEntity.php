<?php

namespace App\Entity\Takeaway;

use App\Entity\AbstractEntity;

class SettingsEntity extends AbstractEntity
{
    /**
     * The prefix for the entity
     * 
     * Everything will be stored under takeaway => takeaway_address in the session
     * 
     * @var string
     */
    public $prefix = 'takeaway.settings';
    
    /**
     * If the takeaway accepts delivery orders
     * 
     * @var boolean 
     */
    protected $accept_delivery_orders = false;
    
    /**
     * The minimum delivery amount
     * 
     * @var float 
     */
    protected $delivery_min_order = null;
    
    /**
     * The current delivery time in minutes
     * 
     * @var int 
     */
    protected $current_delivery_time = null;
    
    /**
     * If the takeaway accepts collection orders
     * 
     * @var boolean 
     */
    protected $accept_collection_orders = null;
    
    /**
     * The minimum collection order amount
     * 
     * @var float 
     */
    protected $collection_min_order = null;
    
    /**
     * The current collection time in minutes
     * 
     * @var int 
     */
    protected $current_collection_time = null;
    
    /**
     * The payment methods
     * 
     * @var array
     */
    protected $payment_methods = [];
    
    /**
     * If the takeaway has a website
     * 
     * @var array
     */
    protected $has_website = 0;
    
    /**
     * If the takeaway has a website
     * 
     * @var array
     */
    protected $active = 0;
    
    /**
     * Constants
     */
    const PAYMENT_METHOD_CASH = 'cash',
            PAYMENT_METHOD_PAYPAL = 'paypal';
    
    /**
     * Getters
     */
    
    /**
     * Returns if the takeaway accepts delivery orders
     * 
     * @return boolean
     */
    public function getAcceptDeliveryOrders() {
        return $this->accept_delivery_orders;
    }

    /**
     * Returns if the min order amount
     * 
     * @return float
     */
    public function getDeliveryMinOrder() {
        return $this->delivery_min_order;
    }

    /**
     * Returns if the current delivery time in minutes
     * 
     * @return int
     */
    public function getCurrentDeliveryTime() {
        return $this->current_delivery_time;
    }

    /**
     * Returns if the takeaway accepts collection orders
     * 
     * @return boolean
     */
    public function getAcceptCollectionOrders() {
        return $this->accept_collection_orders;
    }

    /**
     * Returns if the min collection order
     * 
     * @return boolean
     */
    public function getCollectionMinOrder() {
        return $this->collection_min_order;
    }

    /**
     * Returns if the current collection time
     * 
     * @return boolean
     */
    public function getCurrentCollectionTime() {
        return $this->current_collection_time;
    }

    /**
     * Returns the payment methods
     * 
     * @return array
     */
    public function getPaymentMethods() {
        return $this->payment_methods;
    }
    
    /**
     * Returns if the takeaway has a website
     * 
     * @return int
     */
    public function getHasWebsite() {
        return $this->has_website;
    }
    
    /**
     * Returns if the takeaway has a website
     * 
     * @return boolean
     */
    public function hasWebsite(){
        return (bool) $this->getHasWebsite();
    }

    /**
     * Returns if the takeaway is active
     * 
     * @return int
     */
    public function getActive() {
        return $this->active;
    }
    
    /**
     * Returns if the takeaway is active
     * 
     * @return boolean
     */
    public function isActive(){
        return (bool) $this->getActive();
    }

    /**
     * Setters
     */
    
    /**
     * Sets if the takeaway accepts delivery orders
     * 
     * @param boolean $accept_delivery_orders
     * @return \App\Entity\Takeaway\SettingsEntity
     */
    public function setAcceptDeliveryOrders($accept_delivery_orders) {
        $this->accept_delivery_orders = $accept_delivery_orders;
        return $this;
    }

    /**
     * Sets if the min delivery order amount
     * 
     * @param boolean $delivery_min_order
     * @return \App\Entity\Takeaway\SettingsEntity
     */
    public function setDeliveryMinOrder($delivery_min_order) {
        $this->delivery_min_order = $delivery_min_order;
        return $this;
    }

    /**
     * Sets if the current delivery time in minutes
     * 
     * @param int $current_delivery_time
     * @return \App\Entity\Takeaway\SettingsEntity
     */
    public function setCurrentDeliveryTime($current_delivery_time) {
        $this->current_delivery_time = $current_delivery_time;
        return $this;
    }

    /**
     * Sets if the takeaway accepts collection orders
     * 
     * @param boolean $accept_collection_orders
     * @return \App\Entity\Takeaway\SettingsEntity
     */
    public function setAcceptCollectionOrders($accept_collection_orders) {
        $this->accept_collection_orders = $accept_collection_orders;
        return $this;
    }

    /**
     * Sets the collection min order amount
     * 
     * @param int $collection_min_order
     * @return \App\Entity\Takeaway\SettingsEntity
     */
    public function setCollectionMinOrder($collection_min_order) {
        $this->collection_min_order = $collection_min_order;
        return $this;
    }
    /**
     * Sets the current collection time
     * 
     * @param int $current_collection_time
     * @return \App\Entity\Takeaway\SettingsEntity
     */
    public function setCurrentCollectionTime($current_collection_time) {
        $this->current_collection_time = $current_collection_time;
        return $this;
    }

    /**
     * Sets the payment methods
     * 
     * @param array $payment_methods
     * @return \App\Entity\Takeaway\SettingsEntity
     */
    public function setPaymentMethods($payment_methods) {
        $this->payment_methods = $payment_methods;
        return $this;
    }

    /**
     * Sets if the takeaway has a website
     * 
     * @param int $has_website
     * @return \App\Entity\Takeaway\SettingsEntity
     */
    public function setHasWebsite($has_website) {
        $this->has_website = $has_website;
        return $this;
    }

    /**
     * Sets the takeaways active status
     * 
     * @param int $active
     * @return \App\Entity\Takeaway\SettingsEntity
     */
    public function setActive($active) {
        $this->active = $active;
        return $this;
    }



}