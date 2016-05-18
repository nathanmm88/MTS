<?php

namespace App\Entity;

use App\Entity\AbstractSession;


class MenuEntity extends AbstractEntity
{
    /**
     * The prefix for the entity
     * 
     * Everything will be stored under order in the session
     * 
     * @var string
     */
    public $prefix = 'menu';
    
    /**
     * The menu ID
     * 
     * @var int 
     */
    protected $id = null;
    
    /**
     * The takeaway id
     * 
     * @var int 
     */
    protected $takeaway_id = null;
    
    /**
     * The menu description
     * 
     * @var string
     */
    protected $description = null;
    
    /**
     * An array of sections for this menu
     * 
     * @var type array
     */
    public $sections = array();

    /**
     * Set the menu ID 
     * 
     * @param type $id
     * @return \App\Entity\MenuEntity
     */
    public function setId($id){
        $this->_set('id', $id);
        return $this;
    }
    
    /**
     * Set the takeaway ID against the menu
     * 
     * @return \App\Entity\MenuEntity
     */
    public function setTakeawayId($takeaway_id){
        $this->_set('takeaway_id', $takeaway_id);
        return $this;
    }
    
    /**
     * Sets the menu description
     * 
     * @param type $description
     * @return \App\Entity\MenuEntity
     */
    public function setDescription($description){
        $this->_set('description', $description);
        return $this;
    }           
 }