<?php

namespace App\API;

use App\Lib\DotNotation;
use App\Entity\OrderEntity;

class CreateOrderCall extends AbstractCall {

    /**
     * Content type of the request
     *
     * @var string
     */
    public $content_type = 'application/json';

    /**
     * Handle the API response
     *
     * @param $response
     */
    public function handleResult($response) {
        //load in the dot notation class so we can access the values easily
        $responseDotNotation = new DotNotation($response);

        //set the response values we need
        $this->order->setOrderId($responseDotNotation->get('Order.OrderID'));
        $this->order->setTrackingId($responseDotNotation->get('Order.TrackingID'));
        $this->order->setStatusId($responseDotNotation->get('Order.OrderStatusID'));
    }

}
