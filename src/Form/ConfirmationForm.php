<?php

namespace App\Form;

use Cake\Validation\Validator;
use App\Form\AbstractForm;
use App\Entity\Order\OrderAddressEntity;
use App\Lib\DotNotation;
use App\Entity\OrderEntity;

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
                        ->notEmpty('telephone', 'Please enter a valid telephone number')
                        ->add('telephone', [
                            'length' => [
                                'rule' => ['maxLength', 50],
                                'message' => 'Please enter a valid telephone number',
                            ]
                                ]
                        )
                        ->notEmpty('email', 'Please enter a valid e-mail address')
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
                        )                        
                        ->add('allergy_disclaimer', [
                            'comparison' => [
                                'rule' => ['comparison', '==', 1],
                                'message' => 'Please confirm you have read and understand the allergy disclaimer'
                            ]
                                ]
                        )
                        ->add('terms', [
                            'comparison' => [
                                'rule' => ['comparison', '==', 1],
                                'message' => 'Please confirm you have read and agree to the terms and conditions'
                            ]
                                ]
                        )
        ;
    }

    protected function _execute(array $data) {        
        $dataDotNotation = new DotNotation($data);

        $orderEntity = new OrderEntity($this->request);

        //map the form data to the session
        $orderAddressEntity = OrderAddressEntity::fromArray([
                    'address_line_one' => $dataDotNotation->get('address_line_one'),
                    'address_line_two' => $dataDotNotation->get('address_line_two'),
                    'address_line_three' => $dataDotNotation->get('address_line_three'),
                    'address_line_four' => $dataDotNotation->get('address_line_four'),
                    'postcode' => $dataDotNotation->get('postcode')
        ]);

        $orderEntity->setAddress($orderAddressEntity)
                ->setFirstName($dataDotNotation->get('first_name'))
                ->setSurname($dataDotNotation->get('surname'))
                ->setEmail($dataDotNotation->get('email'))
                ->setTelephone($dataDotNotation->get('telephone'))
                ->setDeliveryTime($dataDotNotation->get('delivery_time'))
                ->setCollectionTime($dataDotNotation->get('collection_time'));

        
        return true;
    }

}
