<?php

namespace App\Entity\Menu;

use App\Entity\AbstractEntity;

class MenuItemEntity extends AbstractEntity
{
    /**
     * The prefix for the entity
     * 
     * Everything will be stored under menu.section => item in the session
     * 
     * @var string
     */
    public $prefix = 'menu';
    
    /**
     * The sub prefix for the entity
     * 
     * @var string 
     */
    public $sub_prefix = 'items';
    
    /**
     * Unique menu section ID
     * 
     * @var integer
     */
    protected $id = null;
    
    /**
     * Menu section ID
     */
    protected $section_id = null;
        
    /**
     * Item name
     * 
     * @var string 
     */
    protected $name = null;
    
    /**
     * Item description
     * 
     * @var string 
     */
    protected $description = null;
    
    /**
     * Whether the item is active or not
     * 
     * @var boolean
     */
    protected $active = null;
    
    /**
     * Item position (the order in which it is displayed)
     * 
     * @var int 
     */
    protected $position = null;
    
    /**
     * Item price
     * 
     * @var float 
     */
    protected $price = null;
      
    /**
     * Whether the item has been deleted
     * 
     * @var boolean 
     */
    protected $deleted = null;
    
    
    /**
     * The item heat rating
     * 
     * @var int
     */
    protected $heat = null;
    
    /**
     * Whether this item is suitable for vegetarians
     * 
     * @var boolean
     */
    protected $vegetarian = null;
    
    
    /**
     * Whether this item is gluten free
     * 
     * @var boolean 
     */
    protected $gluten_free = null;
    
    /**
     * Whether this item is dairy free
     * 
     * @var boolean
     */
    protected $dairy_free = null;
    
    /**
     * Whether this item may contain bones
     * 
     * @var boolean 
     */
    protected $may_contain_bones = null;
          
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
     * Set the section ID this item belongs to
     * 
     * @param type $section_id
     * @return \App\Entity\Menu\MenuItemEntity
     */
    public function setSectionId($section_id){
        $this->section_id = $section_id;
        return $this;
    }
    
    /**
     * Set the item name
     * 
     * @param type $name
     * @return \App\Entity\Menu\MenuItemEntity
     */
    public function setName($name){
        $this->name = $name;
        return $this;
    }
    
    /**
     * Set the item description
     * 
     * @param type $description
     * @return \App\Entity\Menu\MenuItemEntity
     */
    public function setDescription($description){
        $this->description = $description;
        return $this;
    }
    
    /**
     * Set the item active flag
     * 
     * @param type $active
     * @return \App\Entity\Menu\MenuItemEntity
     */
    public function setActive($active){
        $this->active = $active;
        return $this;
    }
         
    
    /**
     * Set the item position
     * 
     * @param type $position
     * @return \App\Entity\Menu\MenuItemEntity
     */
    public function setPosition($position){
        $this->position = $position;
        return $this;
    }
    
    /**
     * Set the item price
     * 
     * @param type $price
     * @return \App\Entity\Menu\MenuItemEntity
     */
    public function setPrice($price){
        $this->price = $price;
        return $this;
    }
    
    /**
     * Set the item deleted flag
     * 
     * @param type $deleted
     * @return \App\Entity\Menu\MenuItemEntity
     */
    public function setDeleted($deleted){
        $this->deleted = $deleted;
        return $this;
    }
    
    /**
     * Set the item heat rating
     * 
     * @param type $heat
     * @return \App\Entity\Menu\MenuItemEntity
     */
    public function setHeat($heat){
        $this->heat = $heat;
        return $this;
    }
    
    /**
     * Set whether the item is suitable for vegetarians
     * 
     * @param type $vegetarian
     * @return \App\Entity\Menu\MenuItemEntity
     */
    public function setVegetarian($vegetarian){
        $this->vegetarian = $vegetarian;
        return $this;
    }
    
    /**
     * Set whether the item is gluten free
     * 
     * @param type $gluten_free
     * @return \App\Entity\Menu\MenuItemEntity
     */
    public function setGlutenFree($gluten_free){
        $this->gluten_free = $gluten_free;
        return $this;
    }
    
    /**
     * Set whether the item is dairy free
     * 
     * @param type $dairy_free
     * @return \App\Entity\Menu\MenuItemEntity
     */
    public function setDairyFree($dairy_free){
        $this->dairy_free = $dairy_free;
        return $this;
    }
    
    /**
     * Set whether this item may contain bones
     * 
     * @param type $may_contain_bones
     * @return \App\Entity\Menu\MenuItemEntity
     */
    public function setMayContainBones($may_contain_bones){
        $this->may_contain_bones = $may_contain_bones;
        return $this;
    }               
}