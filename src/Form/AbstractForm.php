<?php

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class AbstractForm extends Form {

    /**
     * The request object so we have access to the request in all forms
     * 
     * @var \app\Network\TakeawayRequest 
     */
    public $request = null;
    
    /**
     * Form constructor
     * 
     * @param type $request
     */
    public function __construct($request = null) {
        
        /**
         * Set the request if we are passed one
         */
        if(!is_null($request)){
            $this->request = $request;
        }
    }
    
}
