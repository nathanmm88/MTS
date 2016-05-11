<?php

namespace App\Form;

use Cake\Validation\Validator;
use App\Form\AbstractForm;

class ConfirmationForm extends AbstractForm {

    protected function _buildValidator(Validator $validator) {
        return $validator
                ->notEmpty('first_name', 'Please enter a valid first name')
                ->add('first_name', [
                    'length' => [
                        'rule' => ['maxLength', 50],
                        'message' => 'Please enter a valid first name',
                    ]
                        ]
                )
                ->notEmpty('surname', 'Please enter a valid surname')
                ->add('surname', [
                    'length' => [
                        'rule' => ['maxLength', 50],
                        'message' => 'Please enter a valid surname',
                    ]
                        ]
                )
                ->allowEmpty('email')
                ->add('email', [
                    'length' => [
                        'rule' => 'email',
                        'message' => 'Please enter a valid email address',
                    ]
                        ]
                )
                ->notEmpty('address_line_one', 'Please enter a valid address line one')
                ->add('address_line_one', [
                    'length' => [
                        'rule' => ['maxLength', 50],
                        'message' => 'Please enter a valid address line one',
                    ]
                        ]
                )
                ->notEmpty('address_line_three', 'Please enter a valid town')
                ->add('address_line_three', [
                    'length' => [
                        'rule' => ['maxLength', 50],
                        'message' => 'Please enter a valid town',
                    ]
                        ]
                )
                ->notEmpty('postcode', 'Please enter a valid UK postcode')
                ->add('postcode', [
                    'length' => [
                        'rule' => ['maxLength', 50],
                        'message' => 'Please enter a valid UK postcode',
                    ]
                        ]
                );
    }

    protected function _execute(array $data) {
        
        //map the form data to the session
        return true;
    }

}
