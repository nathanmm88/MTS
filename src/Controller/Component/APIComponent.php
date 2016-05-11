<?php

namespace App\Controller\Component;

use App\Controller\Component\AbstractComponent;
use Cake\Network\Http\Client;

class APIComponent extends AbstractComponent {

    
    public function getToken() {

        $response = $this->_makeRequest(
            'Token', 
            'grant_type=password&username=admin@mytakeawaysite.com&password=3ts,9#fY<5[Xi?`-><]qL'
        );
        pr($response);
        die('getToken function');
    }

    /**
     * Makes a request to the API
     * 
     * @param string $messageBody
     */
    protected function _makeRequest($action, $messageBody) {
        $http = new Client();
        return $http->post(
            'http://webapi.mytakeawaysite.com/' . $action, 
            $messageBody, 
            ['headers' => ['Content-Type' => 'application/x-www-form-urlencoded']]
        );
    }

}
