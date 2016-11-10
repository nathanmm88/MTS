<?php

namespace App\API;

use Cake\Core\Configure;
use Cake\Network\Http\Client;
use App\Entity\SecurityEntity;
use App\Entity\TakeawayEntity;
use App\Entity\MenuEntity;
use App\Entity\OrderEntity;
use App\Entity\AbstractEntity;
use App\Network\TakeawayRequest;
use App\Exception\APIException;
use Cake\Log\Log;

abstract class AbstractCall extends AbstractEntity {

    /**
     * Content type of the request
     *
     * @var string
     */
    public $content_type = 'application/x-www-form-urlencoded';

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
        $this->order = new OrderEntity($this->request);
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
        $headers = ['Content-Type' => $this->content_type];

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

        $this->_log(['URL' => Configure::read('api.url') . $action, 'Request' => $messageBody]);
      
        $responseArray = json_decode($response->body(), true);
              
        $this->_log(['Response' => $responseArray]);
        
        if ((array_key_exists('LastError', $responseArray)) && (!empty($responseArray['LastError']))) {
            throw new APIException('Error returned in ' . $action . ' API call with the error "' . $responseArray['LastError'].'"');
        }

        return $responseArray;
    }

    /**
     * Sets the token up ready to use the API
     * 
     */
    protected function _setToken() {
       // if (!$this->security->hasAPIToken()) {
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
       // }
    }
    
    /**
     * Take an array of values to log and do so if logging is turned on
     * 
     * @param type $logValues
     */
    protected function _log($logValues){
         if (Configure::read('log_api_calls')) {
             $output = '';
             foreach ($logValues as $key => $value) {
                 $output.= "\n".$key.': '.print_r($value, true);
             }
             $output.="\n";
            Log::debug($output, ['scope' => ['api']]);
        }
    }

}
