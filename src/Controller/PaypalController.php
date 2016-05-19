<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Core\Configure;
//paypal
use PayPal\Service\AdaptivePaymentsService;
use PayPal\Types\AP\FundingConstraint;
use PayPal\Types\AP\FundingTypeInfo;
use PayPal\Types\AP\FundingTypeList;
use PayPal\Types\AP\PayRequest;
use PayPal\Types\AP\Receiver;
use PayPal\Types\AP\ReceiverList;
use PayPal\Types\AP\SenderIdentifier;
use PayPal\Types\Common\PhoneNumberType;
use PayPal\Types\Common\RequestEnvelope;

/**
 * Paypal controller
 *
 * This controller will render views from Template/Order/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PaypalController extends AppController {

    /**
     * When the user is being checked out, they will be redirected here.
     * 
     * If the user hits this action it will assume all details in the session 
     * have been confirmed as this is what will be passed to PayPal
     */
    public function checkout() {

        $domain = 'http://' . $this->request->host();
        
        // ##PayRequest
        // The code for the language in which errors are returned, which must be
        // en_US.
        $requestEnvelope = new RequestEnvelope("en_GB");

        $receiver = array();
        $receiver[0] = new Receiver();

        // A receiver's email address
        //$receiver[0]->email = $this->takeaway->getEmail();
        $receiver[0]->email = 'nathanmm88-facilitator@gmail.com';
        
        // Amount to be credited to the receiver's account
        $receiver[0]->amount = "4.00";
        
        $receiver[0]->name = "test takeaway";

        $receiverList = new ReceiverList($receiver);

        $payRequest = new PayRequest($requestEnvelope, "PAY", $domain . "/paypal/cancel", $this->takeaway->getCurrency()->getCode(), $receiverList, $domain . "/thanks");

        // The URL to which you want all IPN messages for this payment to be
        // sent.
        // This URL supersedes the IPN notification URL in your profile
        $payRequest->ipnNotificationUrl = $domain . "/paypal/ipn";

                //make the call
        $service = new AdaptivePaymentsService(Configure::read('paypal.aps'));
        
        try {
            /* wrap API method calls on the service object with a try catch */
            $response = $service->Pay($payRequest);
        } catch (Exception $ex) {
            require_once 'Common/Error.php';
            exit;
        }

        $ack = strtoupper($response->responseEnvelope->ack);

        if($ack == "SUCCESS") {
            $payPalURL = Configure::read('paypal.redirect_url') . $response->payKey;
            header("Location: " . $payPalURL);
            die();
        } else {
            throw new Exception('Unable to make the pay call');
        }
    }

    /**
     * Handles the IPN call from paypal
     */
    public function ipn(){
        
    }

}
