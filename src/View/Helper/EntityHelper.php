<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Core\Configure;

class EntityHelper extends Helper {
    
    /**
     * Returns an entity to use in the view
     * 
     * @param string $entityName
     * @return Entity
     * @throws Exception
     */
    public function get($entityName){
        $entities = $this->_View->viewVars['entities'];
        
        if(array_key_exists($entityName, $entities)){
            return $entities[$entityName];
        } else {
            throw new Exception('Unable to find entity with name:' . $entityName);
        }
    }
}
    