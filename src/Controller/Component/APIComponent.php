<?php

namespace App\Controller\Component;

use App\Controller\Component\AbstractComponent;
use App\API\GetSettingsCall;
use App\API\GetMenuCall;
use App\API\GetOrderDetailsCall;
use App\API\UpdatePaymentStatusCall;
use App\API\CreateOrderCall;

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

    /**
     * Update the payment status of a given order
     */
    public function updatePaymentStatus($payment_status){
        //get a new instance of the call
        $updatePaymentSettingsCall = new UpdatePaymentStatusCall();

        //generate the body
        $body = ['orderID' => $this->order->getOrderId(),
            'trackingID' => $this->order->getTrackingId(),
            'paymentStatusID' => $payment_status,
            'transactionRef' => '',
        ];

        //make the request
        $response = $updatePaymentSettingsCall->makeRequest(
            '/api/Orders/UpdatePaymentStatus', $updatePaymentSettingsCall->createRequestMessage($body)
        );

        //handle the response
        $updatePaymentSettingsCall->handleResult($response);
    }

    /**
     * Create an order
     */
    public function createOrder(){
        //get a new instance of the call
        $createOrderCall = new CreateOrderCall();

        //generate the body
        $body = $this->order->buildOrderObject();

        //make the request
        $response = $createOrderCall->makeRequest(
            '/api/Orders/CreateOrder', $body
        );

        //handle the response
        $createOrderCall->handleResult($response);
    }

    /**
     * Get the order details
     */
    public function getOrderDetails($tracking_id = null) {
        //get a new instance of the call
        $getOrderDetailsCall = new GetOrderDetailsCall();

        if (is_null($tracking_id)){
            $tracking_id = $this->order->getTrackingId();
        }

        //generate the body
        $body = [//'OrderID' => $this->order->getOrderId(),
            'TrackingID' => $tracking_id
        ];

        //make the request
        $response = $getOrderDetailsCall->makeRequest(
            '/api/Orders/GetOrderDetails', $getOrderDetailsCall->createRequestMessage($body)
        );

        //handle the response
        $getOrderDetailsCall->handleResult($response);
    }
}
