<?php

namespace App\Entity\Takeaway;

use App\Entity\AbstractEntity;

class CurrencyEntity extends AbstractEntity
{
    /**
     * The prefix for the entity
     * 
     * Everything will be stored under takeaway => takeaway_address in the session
     * 
     * @var string
     */
    public $prefix = 'takeaway.currency';
    
    /**
     * The currency id
     * 
     * @var int 
     */
    protected $id = '';
    
    /**
     * The currency code
     * 
     * @var string 
     */
    protected $code= '';
    
    /**
     * Getters
     */
    
    /**
     * Returns the currency id
     * 
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Returns the currency code
     * 
     * @return string
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * Setters
     */
    
    /**
     * Sets the currency ID
     * 
     * @param int $id
     * @return \App\Entity\Takeaway\CurrencyEntity
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Sets the currency code
     * 
     * @param string $code
     * @return \App\Entity\Takeaway\CurrencyEntity
     */
    public function setCode($code) {
        $this->code = $code;
        return $this;
    }

}