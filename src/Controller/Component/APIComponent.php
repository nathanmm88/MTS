<?php

namespace App\Controller\Component;

use App\Controller\Component\AbstractComponent;
use App\API\GetSettingsCall;
use App\API\GetMenuCall;

class APIComponent extends AbstractComponent {

    /**
     * Makes the get setting API call
     */
    public function setSettings() {
        //get a new instance of the call
        $getSettingsCall = new GetSettingsCall();

        //generate the body
        $body = ['takeawayID' => $this->takeaway->getId(),
            'domain' => $this->request->host(),
            'subDomain' => '',
        ];

        //make the request
        $response = $getSettingsCall->makeRequest(
                '/api/Takeaway/GetSettings', $getSettingsCall->createRequestMessage($body)
        );

        //handle the response
        $getSettingsCall->handleResult($response);
    }

    /**
     * Get the current takeaway menu
     */
    public function getMenu() {
        //first thing - clear down the menu
        $this->menu->clear();      

        //get a new instance of the call
        $getMenuCall = new GetMenuCall();
        
        //generate the body
        $body = ['takeawayID' => $this->takeaway->getId(),
            'domain' => $this->request->host(),
            'subDomain' => '',
        ];

        //make the request
        $response = $getMenuCall->makeRequest(
                '/api/Takeaway/GetMenu', $getMenuCall->createRequestMessage($body)
        );

        //handle the response
        $getMenuCall->handleResult($response);        
    }
}
