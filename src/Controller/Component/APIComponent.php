<?php

namespace App\Controller\Component;

use App\Controller\Component\AbstractComponent;
use Cake\Network\Http\Client;
use Cake\Core\Configure;
use App\Lib\DotNotation;

use App\Entity\Takeaway\TakeawayAddressEntity;


class APIComponent extends AbstractComponent {

    /**
     * Sets the token up ready to use the API
     * 
     */
    public function setToken() {

        if(!$this->security->hasAPIToken()){
            $response = $this->_makeRequest(
                'Token', 
                'grant_type='.Configure::read('api.grant_type').'&username='.Configure::read('api.user').'&password='.Configure::read('api.password'),
                false
            );

            if(!array_key_exists('access_token', $response)){
                throw new Exception('No token returned!');
            }

            if(!array_key_exists('token_type', $response)){
                throw new Exception('No token type returned!');
            }

            $this->security->setAPIToken($response['access_token'])
                    ->setTokenType($response['token_type']);
        }
    }
    
    /**
     * Makes the get setting API call
     */
    public function setSettings(){
        $response = $this->_makeRequest(
                '/api/Takeaway/GetSettings?takeawayID=1&domain=&subDomain=', 
                'takeawayID=1&domain=&subDomain='
                
            );
      //  pr($response);
        
        //load in the dot notation class so we can access the values easily
        $responseDotNotation = new DotNotation($response);
        
        //set the takeaway details
        $this->takeaway->setName($responseDotNotation->get('Takeaway.Name'));
        
        //set the address
        $address = TakeawayAddressEntity::fromArray([
            'address_line_one' => $responseDotNotation->get('Takeaway.Address1'),
            'address_line_two' => $responseDotNotation->get('Takeaway.Address2'),
            'address_line_three' => $responseDotNotation->get('Takeaway.Town'),
            'address_line_four' => $responseDotNotation->get('Takeaway.County'),
            'postcode' => $responseDotNotation->get('Takeaway.PostCode'),
            'latitude' => $responseDotNotation->get('Takeaway.Latitude'),
            'longitude' => $responseDotNotation->get('Takeaway.Longitude')
        ], $this->request);
        
        $this->takeaway->setAddress($address);
        
//pr($_SESSION);
        
  //      die(var_dump($this->takeaway->getAddress()));
        
     //   $this->takeaway->setArray();
        
    }

    /**
     * Makes a request to the API
     * 
     * @param string $messageBody
     */
    protected function _makeRequest($action, $messageBody, $needsToken = true) {
        //default headers
        $headers = ['Content-Type' => 'application/x-www-form-urlencoded'];
        
        //add the token if needed
        if($needsToken){
            //make sure we have the token
            $this->setToken();
            $headers['Authorization'] = $this->security->getAuthorisationToken();
        }

        $http = new Client();
        $response = $http->post(
            Configure::read('api.url') . $action, 
            $messageBody, 
            ['headers' => $headers]
        );
   
        $responseArray = json_decode($response->body(), true);
        
        if(array_key_exists('error', $responseArray)){
            throw new Exception('Error returned in ' . $action . ' API call with the error ' . $responseArray['error']);
        }
        
        return $responseArray;
    }

}
