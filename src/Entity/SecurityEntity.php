<?php

namespace App\Entity;

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
    public function setAPIToken($token){     
        
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
    
    /**
     * Sets the token type
     * 
     * @param string $token
     * @return App\Entity\TakeawayEntity
     */
    public function setTokenType($token){
        return $this->_set('token_type', $token);
    }
    
    /**
     * Returns the token type
     * 
     * @return string
     */
    public function getTokenType(){
        return $this->_get('token_type');
    }
    
    /**
     * Returns the constructed token ready to use in the API header
     * 
     * @return string
     */
    public function getAuthorisationToken(){
        return $this->getTokenType() . ' ' . $this->getAPIToken();
    }
}