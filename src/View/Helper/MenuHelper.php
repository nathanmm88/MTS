<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Core\Configure;

class MenuHelper extends Helper {
    
    /**
     * Load the helpers we want
     * 
     * @var array 
     */
    public $helpers = ['Entity'];

    /**
     * Return the sections for the current menu
     * 
     * @return array
     */
    public function getSections(){        
        return $this->Entity->get('Menu.MenuSection')->_getAll();      
    }
    
    /**
     * Return the items for a given section
     * 
     * @return type
     */
    public function getSectionItems($section_id){
        //initialise the result array
        $sectionItems = array();
        
        //get all items
        $items = $this->Entity->get('Menu.MenuItem')->_getAll();
        
        //loop through and find the items for the given section
        foreach ($items as $item) {
            if ($item['section_id']==$section_id){
                //add to the result array
                $sectionItems[] = $item;
            }
        }
        
        //return the result
        return $sectionItems;        
    }
   
}
    