<?php

namespace App\Entity\Menu;

use App\Entity\Menu\MenuItemEntity;

class MenuItemVariationEntity extends MenuItemEntity
{        
    /**
     * The sub prefix for the entity
     * 
     * @var string 
     */
    public $sub_prefix = 'variations';
    
    /**
     * Parent ID
     */
    protected $parent_id = null;
    
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
}