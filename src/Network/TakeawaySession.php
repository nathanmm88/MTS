<?php

namespace App\Network;

use Cake\Network\Session;

class TakeawaySession extends Session
{
    /**
     * The prefix used so write / read data to the session
     * 
     * @var string 
     */
    public $prefix = '';
    
    /**
     * Constructor
     * 
     * @param array $config
     */
    public function __construct(array $config = array()) {
        parent::__construct($config);
        /**
         * Set the session index
         */
        $this->prefix = str_replace('.', '_', $_SERVER['HTTP_HOST']) . '.';
    }


    /**
     * Writes value to given session variable name.
     * 
     * Extended to write everything under the current domain
     *
     * @param string|array $name Name of variable
     * @param string|null $value Value to write
     * @return void
     */
    public function write($name, $value = null) {
        parent::write($this->prefix . $name, $value);
    }
    
    /**
     * Returns given session variable, or all of them, if no parameters given.
     *
     * Extended to only read from under the current domain
     * 
     * @param string|null $name The name of the session variable (or a path as sent to Hash.extract)
     * @return string|null The value of the session variable, null if session not available,
     *   session not started, or provided name not found in the session.
     */
    public function read($name = null) {
        return parent::read($this->prefix . $name);
    }
}

