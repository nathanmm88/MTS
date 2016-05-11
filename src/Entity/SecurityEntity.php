<?php

namespace App\Entity;

use App\Entity\AbstractSession;

class SecurityEntity extends AbstractEntity
{
    /**
     * The prefix for the entity
     * 
     * Everything will be stored under security in the session
     * 
     * @var string
     */
    public $prefix = 'security';
    
    /**
     * Sets the API token
     * 
     * @param string $token
     * @return App\Entity\TakeawayEntity
     */
    public function setAPITaken($token){
        return $this->_set('api_token', $token);
    }
    
    /**
     * Returns the API token
     * 
     * @return string
     */
    public function getAPIToken(){
        return $this->_get('api_token');
    }
    
    /**
     * Checks if we have an API token
     * 
     * @return boolean
     */
    public function hasAPIToken(){
        $token = $this->getAPIToken();
        return (is_null($token) || $token == '') ? false : true;
    }
}