<?php

namespace App\Entity\Menu;

use App\Entity\AbstractEntity;

class CondimentEntity extends AbstractEntity
{  
    /**
     * The prefix for the entity
     * 
     * Everything will be stored under menu in the session
     * 
     * @var string
     */
    public $prefix = 'menu';
    
    /**
     * The sub prefix for the entity
     * 
     * @var string
     */
    public $sub_prefix = 'conditments';
    
    /**
     * Unique conditment type ID
     * 
     * @var integer
     */
    protected $id = null;
    
    /**
     * Condiment type ID
     */
    protected $condiment_type_id = null;       
    
    /**
     * Condiment description
     * 
     * @var string 
     */
    protected $description = null;    
    
    /**
     * Condiment name
     * 
     * @var string 
     */
    protected $name = null;
    
    /**
     * Whether the condiment is active
     * 
     * @var boolean
     */
    protected $active = null;
    
    /**
     * Whether the condiment is deleted
     * 
     * @var boolean
     */
    protected $deleted = null;
    
    /**
     * Whether there is an additional cost
     *  
     * @var float
     */
    protected $additional_cost = null;

    /**
     * Getters
     */

    /**
     * Returns the condiment ID
     * 
     * @return int
     */
    public function getId() {
        return $this->id;        
    }
    
    /**
     * Returns the condimaent name
     * 
     * @return string
     */
    public function getName(){
        return $this->name;
    }
    
    /**
     * Returns the item description
     * 
     * @return string
     */
    public function getDescription(){
        return $this->description;
    }
        
      
    /**
     * Setters
     */
    
    /**
     * Set the condiment ID
     * 
     * @param type $id
     * @return \App\Entity\Menu\CondimentEntity
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    /**
     * Set the condiment type ID
     * 
     * @param type $condiment_type
     * @return \App\Entity\Menu\CondimentEntity
     */
    public function setCondimentTypeID($condiment_type){
        $this->condiment_type_id = $condiment_type;
        return $this;
    }
      
    /**
     * Set the condiment description
     * 
     * @param type $description
     * @return \App\Entity\Menu\CondimentEntity
     */
    public function setDescription($description){
        $this->description = $description;
        return $this;
    }
    
    /**
     * Set the condiment name
     * 
     * @param type $name
     * @return \App\Entity\Menu\CondimentEntity
     */
    public function setName($name){
        $this->name = $name;
        return $this;
    }
    
    /**
     * Set the active flag
     * 
     * @param type $active
     * @return \App\Entity\Menu\CondimentEntity
     */
    public function setActive($active){
        $this->active = $active;
        return $this;
    }
    
    /**
     * Set the deleted flag
     * 
     * @param type $deleted
     * @return \App\Entity\Menu\CondimentEntity
     */
    public function setDeleted($deleted){
        $this->deleted = $deleted;
        return $this;
    }

    /**
     * Set the additional cost (if any)
     * 
     * @param type $additional_cost
     * @return \App\Entity\Menu\CondimentEntity
     */
    public function setAdditionalCost($additional_cost){
        $this->additional_cost = $additional_cost;
        return $this;
    }                   
}