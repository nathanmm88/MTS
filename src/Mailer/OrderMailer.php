<?php

namespace App\Mailer;

use Cake\Mailer\Mailer;

class OrderMailer extends Mailer {

    /**
     * Send the confirmation email
     * 
     * @param OrderEntity $order
     */
    public function confirmation($order, $menu) {  
        $this->to($order->getEmail())
                ->emailFormat('html')
                ->set(['order' => $order, 'menu' => $menu])
                ->subject('Thank you for your order');
    }
}