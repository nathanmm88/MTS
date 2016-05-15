<?php

namespace App\Form;

use Cake\Validation\Validator;
use App\Form\AbstractForm;

class OrderForm extends AbstractForm {

//    protected function _buildValidator(Validator $validator) {
//        return array());
//    }

    protected function _execute(array $data) {
        
        //map the form data to the session
        return true;
    }

}
