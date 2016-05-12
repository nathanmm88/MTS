<?php

namespace App\Controller\Component;

use App\Controller\Component\AbstractComponent;
use Cake\Network\Http\Client;
use Cake\Core\Configure;


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
        pr($response,1);
        die('settings');
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
