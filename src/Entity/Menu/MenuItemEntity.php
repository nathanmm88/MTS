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
     * Item reference
     * 
     * @var string 
     */
    protected $reference = null;
    
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
     * Whether this item has variations
     * 
     * @var boolean
     */
    protected $has_variations = false;
          
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
     * Returns the items reference
     * 
     * @return type
     */
    public function getReference() {
        return $this->reference;
    }
    
    /**
     * Returns the item name
     * 
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Returns the description
     * 
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Returns if the item is active
     * 
     * @return int
     */
    public function getActive() {
        return $this->active;
    }
    
    /**
     * Returns if the item is active
     * 
     * @return bool
     */
    public function isActive() {
        return (bool) $this->getActive();
    }

    /**
     * Returns the item position
     * 
     * @return int
     */
    public function getPosition() {
        return $this->position;
    }

    /**
     * Returns if the item is deleted
     * 
     * @return int
     */
    public function getDeleted() {
        return $this->deleted;
    }

    /**
     * Returns the heat for the item
     * 
     * @return int
     */
    public function getHeat() {
        return $this->heat;
    }

    /**
     * Returns if the item is vegetarian
     * 
     * @return int
     */
    public function getVegetarian() {
        return $this->vegetarian;
    }
    
    /**
     * Returns if the item is vegetarian
     * 
     * @return bool
     */
    public function isVegetarian() {
        return (bool) $this->getVegetarian();
    }
    
    /**
     * Returns the price
     * 
     * @return float
     */
    public function getPrice() {
        return $this->price;
    }
    
    
        
    /**
     * Returns the section ID
     * 
     * @return int
     */
    public function getSectionId() {
        return $this->section_id;
    }

    /**
     * Returns the gluten free status
     * 
     * @return int
     */
    public function getGlutenFree() {
        return $this->gluten_free;
    }
    
    /**
     * Returns the gluten free status
     * 
     * @return boolean
     */
    public function isGlutenFree() {
        return (bool) $this->getGlutenFree();
    }

    /**
     * Returns the dairy free status
     * 
     * @return int
     */
    public function getDairyFree() {
        return $this->dairy_free;
    }
    
    /**
     * Returns the dairy free status
     * 
     * @return boolean
     */
    public function isDairyFree() {
        return (bool) $this->getDairyFree();
    }

    /**
     * Returns the may contain bones status
     * 
     * @return int
     */
    public function getMayContainBones() {
        return $this->may_contain_bones;
    }
    
    /**
     * Returns the may contain bones status
     * 
     * @return bool
     */
    public function mayContainBones() {
        return (int) $this->getMayContainBones();
    }

    /**
     * Returns if the item has variations
     * 
     * @return int
     */
    public function getHasVariations() {
        return $this->has_variations;
    }
    
    /**
     * Returns if the item has variations
     * 
     * @return bool
     */
    public function hasVariations() {
        return (bool) $this->getHasVariations();
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
     * Sets the reference
     * 
     * @param string $reference
     * @return \App\Entity\Menu\MenuItemEntity
     */
    public function setReference($reference) {
        $this->reference = $reference;
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
     * Set whether the item has variations
     * 
     * @param type $has_variations
     * @return \App\Entity\Menu\MenuItemEntity
     */
    public function setHasVariations($has_variations){
        $this->has_variations = $has_variations;
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
    
    /**
     * Returns the full name
     * 
     * @return string
     */
    public function getFullName($sep = '|'){
        return $this->getName();
    }
    
}