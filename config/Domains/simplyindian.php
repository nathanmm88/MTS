<?php

return [
    'takeaway' => [
        //takeaway name
        'name' => 'Simply Indian',
        //If the domain has a website or not
        'website' => 0, // 0 off / 1 on
        //Contact details
        'contact_details' => [
            'address_line_one' => '41 Bryntaf',
            'address_line_two' => 'Aberfan',
            'address_line_three' => 'Merthyr Tydfil',
            'address_line_four' => '',
            'postcode' => 'CF484PN',
            'lat' => '51.6885373',
            'long' => '-3.34477609999999',
            'telephone' => '01443 123 123',
            'email' => 'contact@simplyindian.co.uk'
        ],
        'opening_hours' => [
            'mon' => '7pm - 1am',
            'tue' => '7pm - 1am',
            'wed' => '7pm - 1am',
            'thu' => '7pm - 1am',
            'fri' => '7pm - 1am',
            'sat' => '7pm - 1am',
            'sun' => '7pm - 1am'
        ],
        'order_settings' => [
            //The ordering system status
            'status' => 1, // 0 off / 1 on
            //are they taking collection orders
            'collection' => 1, // 0 off / 1 on
            //are they taking delivery orders
            'delivery' => 1, // 0 off / 1 on
            //how long collections orders are currently taking
            'collection_time' => 15, // in minutes
            //how long delivery orders are currently taking
            'delivery_time' => 90, // in minutes
            'currency' => 'GBP', //the currency code to pass when formatting info
            'minimum_delivery_amount' => 10.00, //minimum order amount - delivery
            'minimum_collection_amount' => 0.00, //minimum order amount - collection
            'delivery_costs' => array(
              //miles => cost,
                1 => 1.00,
                2 => 1.50,
                3 => 2.00
            ),
            'delivery_payment_options' => array(
                'cash',
                'online'
            )
        ],
        //the takeaway logo URL
        'logo' => '/tmp/logo.png'
    ]
];

