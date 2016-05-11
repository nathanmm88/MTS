<?php

namespace App\Entity;

use App\Entity\AbstractSession;

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
     * Sets the takeaway name
     * 
     * @param string $name
     * @return App\Entity\TakeawayEntity
     */
    public function setName($name){
        return $this->_set('name', $name);
    }
    
    /**
     * Returns the takeaway name
     * 
     * @return string
     */
    public function getName(){
        return $this->_get('name');
    }
}