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

        //save the order detailsback to the session
        $this->order->saveOrderBackToSession($responseDotNotation);
    }

}
