<?php

namespace App\API;

use Cake\Core\Configure;
use Cake\Network\Http\Client;
use App\Entity\SecurityEntity;
use App\Entity\TakeawayEntity;
use App\Entity\MenuEntity;
use App\Entity\AbstractEntity;
use App\Network\TakeawayRequest;

abstract class AbstractCall extends AbstractEntity {

    /**
     * Constructor
     * 
     * Ensure the entities are accessible in all inherited calls
     */
    public function __construct() {
        parent::__construct();
        
        $this->request = TakeawayRequest::createFromGlobals();
        $this->security = new SecurityEntity($this->request);
        $this->takeaway = new TakeawayEntity($this->request);
        $this->menu = new MenuEntity($this->request);
    }

    /**
     * Returns the request message body
     * 
     * @param array $data
     * @return type
     */
    public function createRequestMessage($data) {
        return http_build_query($data);
    }

    /**
     * Makes a request to the API
     * 
     * @param string $messageBody
     */
    public function makeRequest($action, $messageBody, $needsToken = true) {
        //default headers
        $headers = ['Content-Type' => 'application/x-www-form-urlencoded'];

        //add the token if needed
        if ($needsToken) {
            //make sure we have the token
            $this->_setToken();
            
            $headers['Authorization'] = $this->security->getAuthorisationToken();
        }

        $http = new Client();
        $response = $http->post(
                Configure::read('api.url') . $action, $messageBody, ['headers' => $headers]
        );

        $responseArray = json_decode($response->body(), true);

        if (array_key_exists('error', $responseArray)) {
            throw new Exception('Error returned in ' . $action . ' API call with the error ' . $responseArray['error']);
        }

        return $responseArray;
    }

    /**
     * Sets the token up ready to use the API
     * 
     */
    protected function _setToken() {
        if (!$this->security->hasAPIToken()) {
            $response = $this->makeRequest(
                    'Token', 'grant_type=' . Configure::read('api.grant_type') . '&username=' . Configure::read('api.user') . '&password=' . Configure::read('api.password'), false
            );

            if (!array_key_exists('access_token', $response)) {
                throw new Exception('No token returned!');
            }

            if (!array_key_exists('token_type', $response)) {
                throw new Exception('No token type returned!');
            }

            $this->security->setAPIToken($response['access_token'])
                    ->setTokenType($response['token_type']);
        }
    }

}
