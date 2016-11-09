<?php

namespace App\API;

use App\Lib\DotNotation;

class GetOrderDetailsCall extends AbstractCall {

    /**
     * Handle the API response
     *
     * @param $response
     */
    public function handleResult($response) {
        //load in the dot notation class so we can access the values easily
        $responseDotNotation = new DotNotation($response);

        //set the response values we need
        $this->order->setStatusId($responseDotNotation->get('Order.OrderStatusID'));

        //TODO - we may want to map the description our end from the ID
        $this->order->setStatusDesc($responseDotNotation->get('Order.OrderStatusDesc'));
        $this->order->setPaymentStatusDesc($responseDotNotation->get('Order.PaymentStatusDesc'));
    }

}
