<?php

namespace App\Entity\Menu;

use App\Entity\AbstractEntity;

class MenuSectionEntity extends AbstractEntity
{
    /**
     * The prefix for the entity
     * 
     * Everything will be stored under menu => section in the session
     * 
     * @var string
     */
    public $prefix = 'menu';
    
    /**
     * The sub prefix for the entity
     * 
     * @var string 
     */
    public $sub_prefix = 'sections';
    
    /**
     * Unique menu section ID
     * 
     * @var integer
     */
    protected $id = null;
    
    /**
     * Menu ID
     */
    protected $menu_id = null;
        
    /**
     * Section name
     * 
     * @var string 
     */
    protected $name = null;
    
    /**
     * Section description
     * 
     * @var string 
     */
    protected $description = null;
    
    /**
     * Whether the section is active or not
     * 
     * @var boolean
     */
    protected $active = null;
    
    /**
     * Section position (the order in which it is displayed)
     * 
     * @var int 
     */
    protected $position = null;
 

    /**
     * Getters
     */

    /**
     * Returns the section ID
     * 
     * @return int
     */
    public function getId() {
        return $this->id;        
    }
              
    /**
     * Setters
     */
    
    /**
     * Sets the section ID
     * 
     * @param type $id
     * @return \App\Entity\Menu\MenuSectionEntity
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    /**
     * Set the menu ID
     * 
     * @return \App\Entity\Menu\MenuSectionEntity
     */
    public function setMenuId($menu_id){
        $this->menu_id = $menu_id;
        return $this;
    }
    
    /**
     * Set the section name
     * 
     * @return \App\Entity\Menu\MenuSectionEntity
     */
    public function setName($name){
        $this->name = $name;
        return $this;
    }
    
    /**
     * Set the section description
     * 
     * @return \App\Entity\Menu\MenuSectionEntity
     */
    public function setDescription($description){
        $this->description = $description;
        return $this;
    }
    
    /**
     * Set the section active
     * 
     * @return \App\Entity\Menu\MenuSectionEntity
     */
    public function setActive($active){
        $this->active = $active;
        return $this;
    }
         
    
    /**
     * Set the section position
     * 
     * @return \App\Entity\Menu\MenuSectionEntity
     */
    public function setPosition($position){
        $this->position = $position;
        return $this;
    }                   
}