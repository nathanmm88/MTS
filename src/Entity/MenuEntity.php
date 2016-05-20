<?php

namespace App\Entity;

use App\Entity\AbstractSession;
use App\Entity\Menu\MenuSectionEntity;
use App\Entity\Menu\MenuItemEntity;
use App\Entity\Menu\MenuItemVariationEntity;
use App\Entity\Menu\CondimentEntity;
use App\Entity\Menu\CondimentTypeEntity;


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
     * An array of items for this menu
     * 
     * @var type array
     */
    public $items = array();

    /**
     * Getters
     */
    
    /**
     * Returns the menu id
     * 
     * @return type
     */
    public function getId() {
        return $this->_get('id');
    }

    /**
     * Returns the takeaway id
     * 
     * @return int
     */
    public function getTakeawayId() {
        return $this->_get('takeaway_id');
    }

    /**
     * Returns the description
     * 
     * @return string
     */
    public function getDescription() {
        return $this->_get('description');
    }

    /**
     * Returns the sections
     * 
     * @return array
     */
    public function getSections() {
        //get the sections
        $sections = $this->_get('sections');
        //wont be an array if none have been set
        if(!is_array($sections)){
            $sections = [];
        }
        //convert to objects
        foreach($sections as $id => $section){
            $sections[$id] = MenuSectionEntity::fromArray($section, $this->request);
        }
        //return the new objects
        return $sections;
    }
    
    /**
     * Returns the menu items
     * 
     * @param int|null $sectionId
     * @return array
     */
    public function getItems($sectionId = null){
        //get the items
        $items = $this->_get('items');
        //wont be an array if none have been set
        if(!is_array($items)){
            $items = [];
        }
        //set if we should be filtering
        $filter = is_null($sectionId) ? false : true;
        //convert to objects
        foreach($items as $id => $item){
            //add if we are not filtering or the id's match
            if(!$filter || (int)$sectionId === (int) $item['section_id']){
                $items[$id] = MenuItemEntity::fromArray($item, $this->request);
            } else {
                unset($items[$id]);
            }
        }
        //return the new objects
        return $items;
    }
    
    /**
     * Returns an item from the session if it exists
     * 
     * @param int $itemId
     * @return MenuSectionEntity|null
     */
    public function getItem($itemId, $variationId = null){
        //get the items
        $items = $this->_get('items');
        //set the item we want to return as default
        $item = null;
        //if we have it return it
        if(is_array($items) && array_key_exists($itemId, $items)){
            $item = MenuItemEntity::fromArray($items[$itemId]);
            if($item->hasVariations() && $variationId > 0){
                $variations = $this->getVariations($item->getId());
                //if we have it set our return value to true
                if(is_array($variations) && array_key_exists($item->getId() . '_' . $variationId, $variations)){
                    $item = $variations[$item->getId() . '_' . $variationId];
                }
            }
        }
        //return our result
        return $item;
    }
    
    /**
     * Checks if an item exists, a section can be supplied if we want to check
     * that the item exists within a section
     * 
     * @param int $itemId
     * @param tint $variationId
     * @param tint $sectionId
     * @return boolean
     */
    public function itemExists($itemId, $variationId = null, $sectionId = null){

        //get our items for the section
        $items = $this->getItems($sectionId);
        
        //default off
        $return = false;
        
        //make sure we have items
        if(is_array($items) && array_key_exists($itemId, $items)){
            //get the item
            $item = $items[$itemId];
            //if we have variations make sure we have it
            if($item->hasVariations()){
                $variations = $this->getVariations($itemId);
                //if we have it set our return value to true
                if(is_array($variations) && array_key_exists($itemId . '_' . $variationId, $variations)){
                    $return = true;
                }
            } else { //otherwise all good
                $return = true;
            }
        }
        
        return $return;
    }
    
    /**
     * Returns the menu item variations
     * 
     * @return array
     */
    public function getVariations($itemId){
        //get the items
        $variations = $this->_get('variations');
        //wont be an array if none have been set
        if(!is_array($variations)){
            $variations = [];
        }
        //set if we should be filtering
        $filter = is_null($itemId) ? false : true;
        //convert to objects
        foreach($variations as $id => $variation){
            
            //add if we are not filtering or the id's match
            if(!$filter || $itemId == $variation['parent_id']){
                $variations[$id] = MenuItemVariationEntity::fromArray($variation, $this->request);
            } else {
                unset($variations[$id]);
            }
        }
        //return the new objects
        return $variations;
    }
    
    /**
     * Returns the condiment types
     * 
     * @return array
     */
    public function getCondimentTypes($itemId = null){
        //get the items
        $condimentTypes = $this->_get('condimentTypes');
        //wont be an array if none have been set
        if(!is_array($condimentTypes)){
            $condimentTypes = [];
        }
        //set if we should be filtering
        $filter = is_null($itemId) ? false : true;
        //convert to objects
        foreach($condimentTypes as $id => $condimentType){
            //add if we are not filtering or the id's match
            if(!$filter || $itemId === $condimentType['item_id']){
                $condimentTypes[$id] = CondimentTypeEntity::fromArray($condimentType, $this->request);
            } else {
                unset($condimentTypes[$id]);
            }
        }
        //return the new objects
        return $condimentTypes;
    }
    
    /**
     * Returns the condiments
     * 
     * @return array
     */
    public function getCondiments($condimentTypeId = null){
        //get the items
        $condiments = $this->_get('condiments');
        //wont be an array if none have been set
        if(!is_array($condiments)){
            $condiments = [];
        }
        //set if we should be filtering
        $filter = is_null($condimentTypeId) ? false : true;
        //convert to objects
        foreach($condiments as $id => $condiment){
            //add if we are not filtering or the id's match
            if(!$filter || $condimentTypeId === $condiment['condiment_type_id']){
                $condiments[$id] = CondimentEntity::fromArray($condiment, $this->request);
            } else {
                unset($condiments[$id]);
            }
        }
        //return the new objects
        return $condiments;
    }
        
    /**
     * Setters
     */
    
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
    
    /**
     * Sets the menu sections
     * 
     * @param array $sections
     * @throws Exception
     * @return \App\Entity\MenuEntity
     */
    public function setSections($sections){
        //the sections we want to save
        $saveSections = [];
        //make sure we have an array of sections
        if(is_array($sections)){
            //go through each one adding it to the sections
            foreach($sections as $section){
                //make sure we have an instance of the menu section entity
                if($section instanceof MenuSectionEntity){
                    $saveSections[$section->getId()] = $section->toArray();
                } else {
                    throw new Exception('A section supplied to setSections in order entity that is not an instance of App\Entity\Menu\MenuSectionEntity');
                }
            }
        }
        //set the new sections
        $this->_set('sections', $saveSections);
        return $this;
    }
    
    /**
     * Adds a menu section to the menu
     * 
     * @param \App\Entity\Menu\MenuSectionEntity $menuSection
     * @return \App\Entity\MenuEntity
     */
    public function addSection(MenuSectionEntity $menuSection){
        //get the existing menu sections
        $menuSections = $this->_get('sections');
        //first time around this wont be an array
        if(!is_array($menuSections)){
            $menuSections = [];
        }
        //add it to the sections
        $menuSections[$menuSection->getId()] = $menuSection->toArray();
        //set the new sections
        $this->_set('sections', $menuSections);
        return $this;
    }
    
    /**
     * Sets the menu items
     * 
     * @param array $items
     * @return \App\Entity\MenuEntity
     * @throws Exception
     */
    public function setItems($items){
        //the items we want to save
        $saveItems = [];
        //make sure we have an array of items
        if(is_array($items)){
            //go through each one adding it to the items
            foreach($items as $item){
                //make sure we have an instance of the menu item entity
                if($item instanceof MenuItemEntity){
                    $saveItems[$item->getId()] = $item->toArray();
                } else {
                    throw new Exception('A item supplied to setItems in order entity that is not an instance of App\Entity\Menu\MenuItemEntity');
                }
            }
        }
        //set the new items
        $this->_set('items', $saveItems);
        return $this;
    }
    
    /**
     * Adds a menu item to the menu
     * 
     * @param \App\Entity\Menu\MenuItemEntity $menuItem
     * @return \App\Entity\MenuEntity
     */
    public function addItem(MenuItemEntity $menuItem){
        //get the existing menu items
        $menuItems = $this->_get('items');
        //first time around this wont be an array
        if(!is_array($menuItems)){
            $menuItems = [];
        }
        //add it to the items
        $menuItems[$menuItem->getId()] = $menuItem->toArray();
        //set the new items
        $this->_set('items', $menuItems);
        return $this;
    }
    
    /**
     * Sets the menu item Variations
     * 
     * @param array $variations
     * @return \App\Entity\MenuEntity
     * @throws Exception
     */
    public function setVariations($variations){
        //the items we want to save
        $saveItemVariations = [];
        //make sure we have an array of items
        if(is_array($variations)){
            //go through each one adding it to the items
            foreach($variations as $variation){
                //make sure we have an instance of the menu item entity
                if($variation instanceof MenuItemVariationEntity){
                    $saveItemVariations[$variation->getParentId() . '_' . $variation->getId()] = $variation->toArray();
                } else {
                    throw new Exception('A item supplied to setItems in order entity that is not an instance of App\Entity\Menu\MenuItemVariationEntity');
                }
            }
        }
        //set the new items
        $this->_set('variations', $saveItemVariations);
        return $this;
    }
    
    /**
     * Adds a menu item variation to the menu
     * 
     * @param \App\Entity\Menu\MenuItemVariationEntity $menuItemVariation
     * @return \App\Entity\MenuEntity
     */
    public function addVariation(MenuItemVariationEntity $menuItemVariation){
        //get the existing menu item variations
        $menuItemVariations = $this->_get('variations');
        //first time around this wont be an array
        if(!is_array($menuItemVariations)){
            $menuItemVariations = [];
        }
        //add it to the variations
        $menuItemVariations[$menuItemVariation->getParentId() . '_' . $menuItemVariation->getId()] = $menuItemVariation->toArray();
        //set the new variations
        $this->_set('variations', $menuItemVariations);
        return $this;
    }
    
    /**
     * Sets the menu item condiment types
     * 
     * @param array $condimentTypes
     * @return \App\Entity\MenuEntity
     * @throws Exception
     */
    public function setCondimentTypes($condimentTypes){
        //the items we want to save
        $saveCondimentTypes = [];
        //make sure we have an array of items
        if(is_array($condimentTypes)){
            //go through each one adding it to the items
            foreach($condimentTypes as $condimentType){
                //make sure we have an instance of the menu item entity
                if($condimentType instanceof CondimentTypeEntity){
                    $saveCondimentTypes[$condimentType->getId()] = $condimentType->toArray();
                } else {
                    throw new Exception('A item supplied to setItems in order entity that is not an instance of App\Entity\Menu\CondimentTypeEntity');
                }
            }
        }
        //set the new items
        $this->_set('condiment_types', $saveCondimentTypes);
        return $this;
    }
    
    /**
     * Adds a condiment type
     * 
     * @param \App\Entity\Menu\CondimentTypeEntity $condimentType
     * @return \App\Entity\MenuEntity
     */
    public function addCondimentType(CondimentTypeEntity $condimentType){
        //get the existing condiment types
        $condimentTypes = $this->_get('condiment_types');
        //first time around this wont be an array
        if(!is_array($condimentTypes)){
            $condimentTypes = [];
        }
        //add it to the condiment type
        $condimentTypes[] = $condimentType->toArray();
        //set the new condiment types
        $this->_set('condiment_types', $condimentTypes);
        return $this;
    }
    
    /**
     * Sets the menu item condiment types
     * 
     * @param array $condiments
     * @return \App\Entity\MenuEntity
     * @throws Exception
     */
    public function setCondiments($condiments){
        //the items we want to save
        $saveCondiments = [];
        //make sure we have an array of items
        if(is_array($condiments)){
            //go through each one adding it to the items
            foreach($condiments as $condiment){
                //make sure we have an instance of the menu item entity
                if($condiment instanceof CondimentEntity){
                    $saveCondiments[$condiment->getId()] = $condiment->toArray();
                } else {
                    throw new Exception('A item supplied to setItems in order entity that is not an instance of App\Entity\Menu\CondimentEntity');
                }
            }
        }
        //set the new items
        $this->_set('condiments', $saveCondiments);
        return $this;
    }
    
    /**
     * Adds a condiment type
     * 
     * @param \App\Entity\Menu\CondimentEntity $condiment
     * @return \App\Entity\MenuEntity
     */
    public function addCondiment(CondimentEntity $condiment){
        //get the existing condiment types
        $condiments = $this->_get('condiments');
        //first time around this wont be an array
        if(!is_array($condiments)){
            $condiments = [];
        }
        //add it to the condiment type
        $condiments[] = $condiment->toArray();
        //set the new condiment types
        $this->_set('condiments', $condiments);
        return $this;
    }
 }