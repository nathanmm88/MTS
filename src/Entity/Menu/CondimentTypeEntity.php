<?php

namespace App\Entity\Menu;

use App\Entity\AbstractEntity;

class CondimentTypeEntity extends AbstractEntity
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
    public $sub_prefix = 'condiment_types';
    
    /**
     * Unique conditment type ID
     * 
     * @var integer
     */
    protected $id = null;
    
    /**
     * Item ID
     */
    protected $item_id = null;       
    
    /**
     * Condiment type description
     * 
     * @var string 
     */
    protected $description = null;     

    /**
     * Getters
     */

    /**
     * Returns the condiment type ID
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
     * Set the condiment type ID
     * 
     * @param type $id
     * @return \App\Entity\Menu\CondimentTypeEntity
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    /**
     * Set the item ID
     * 
     * @param type $item_id
     * @return \App\Entity\Menu\CondimentTypeEntity
     */
    public function setItemId($item_id){
        $this->item_id = $item_id;
        return $this;
    }
      
    /**
     * Set the condiment type description
     * 
     * @param type $description
     * @return \App\Entity\Menu\CondimentTypeEntity
     */
    public function setDescription($description){
        $this->description = $description;
        return $this;
    }                      
}