<?php

namespace App\API;

class PostcodeLookupCall extends AbstractCall {

    public $content_type = 'application/json';

    /**
     * Handle the API response
     *
     * @param $response
     */
    public function handleResult($response) {

        return $response;

    }

}
