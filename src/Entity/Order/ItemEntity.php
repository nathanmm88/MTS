<?php

namespace App\Entity\Order;

use App\Entity\AbstractEntity;

class ItemEntity extends AbstractEntity
{
    /**
     * The prefix for the entity
     * 
     * Everything will be stored under order => item in the session
     * 
     * @var string
     */
    public $prefix = 'order.item';
    
    /**
     * Unique Item ID
     * 
     * @var integer
     */
    protected $id = null;
    
    /**
     * Order Item ID (specific to this order)
     */
    protected $item_id = null;
    
    /**
     * Order Section ID (specific to this order)
     */
    protected $section_id = null;
    
    /**
     * Order variation ID (specific to this order)
     */
    protected $variation_id = null;
        
    /**
     * Any notes against the item
     * 
     * @var string 
     */
    protected $notes = null;
    
    /**
     * Getters
     */

    /**
     * Returns the item ID
     * 
     * @return string
     */
    public function getId() {
        return $this->id;
        
    }
        
    /**
     * Returns the unique item ID
     * 
     * @return string
     */
    public function getItemId() {
        return $this->item_id;
        
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
     * Returns the variation ID
     * 
     * @return int
     */
    public function getVariationId() {
        return $this->variation_id;
    }
    
    /**
     * Returns the item notes
     * 
     * @return string
     */
    public function getNotes(){
        return $this->notes;
    }
    
    /**
     * Setters
     */
    
    /**
     * Sets the item ID
     * 
     * @param integer $id
     * @return \App\Entity\Order\ItemEntity
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    /**
     * 
     * @param type $item_id
     * @return \App\Entity\Order\ItemEntity
     */
    public function setItemId($item_id){
        $this->item_id = $item_id;
        return $this;
    }
    
    /**
     * Sets the section ID
     * 
     * @param int $section_id
     * @return \App\Entity\Order\ItemEntity
     */
    public function setSectionId($section_id){
        $this->section_id = $section_id;
        return $this;
    }
    
    /**
     * Sets the variation ID
     * 
     * @param int $variation_id
     * @return \App\Entity\Order\ItemEntity
     */
    public function setVariationId($variation_id){
        $this->variation_id = $variation_id;
        return $this;
    }
    
    /**
     * Sets the notes against the item
     * 
     * @param string $notes
     * @return \App\Entity\Order\ItemEntity
     */
    public function setNotes($notes){
        $this->notes = $notes;
        return $this;
    }    
    
}