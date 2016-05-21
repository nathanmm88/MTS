<?php

return [
    /**
     * The API credentials 
     */
    'api' => [
        'url' => 'http://webapi.mytakeawaysite.com/',
        'user' => 'admin@mytakeawaysite.com',
        'password' => '3ts,9#fY<5[Xi?`-><]qL',
        'grant_type' => 'password'
    ],
    /**
     * Paypal credentials
     */
    'paypal' => [
        'redirect_url' => 'https://www.sandbox.paypal.com/webscr&cmd=_ap-payment&paykey=',
        'aps' => [
            'mode' => 'sandbox',
            "acct1.UserName" => "nathanmm88-app_api1.gmail.com",
            "acct1.Password" => "KNVM4F6WE83XR8LC",
            "acct1.Signature" => "AFcWxV21C7fd0v3bYYYRCpSSRl31AX032M1MLcGxNpSW1q8LMA-yvD0h",
            "acct1.AppId" => "APP-80W284485P519543T"
        ]
    ],
    'log_api_calls' => true    
];
