<?php

namespace App\Entity\Menu;

use App\Entity\Menu\MenuItemEntity;

class MenuItemVariationEntity extends MenuItemEntity
{        
    
    /**
     * Parent ID
     */
    protected $parent_id = null;
    
    /**
     * Parent name
     */
    protected $parent_name = null;
    
    /**
     * Set teh parent ID this variation belongs to
     * 
     * @param type $parent_id
     * @return \App\Entity\Menu\MenuItemVariationEntity
     */
    public function setParentId($parent_id){
        $this->parent_id = $parent_id;
        return $this;
    }
    
    /**
     * Set teh parent name
     * 
     * @param string $parent_name
     * @return \App\Entity\Menu\MenuItemVariationEntity
     */
    public function setParentName($parent_name){
        $this->parent_name = $parent_name;
        return $this;
    }
    
    /**
     * Returns the parent ID
     * 
     * @return int
     */
    public function getParentId() {
        return $this->parent_id;
    }

    /**
     * Returns the parent name
     * 
     * @return string
     */
    public function getParentName() {
        return $this->parent_name;
    }
    
    /**
     * Returns the full name
     * 
     * @return string
     */
    public function getFullName($sep = ' - '){
        return $this->getParentName() . $sep . $this->getName();
    }
    
}