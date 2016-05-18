<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Core\Configure;

class TakeawayHelper extends Helper {

    /**
     * Load the helpers we want
     * 
     * @var array 
     */
    public $helpers = ['Number', 'Entity'];

    /**
     * Returns the estimated waiting time
     * 
     * @return type
     */
    public function getDeliveryWaitingTime() {
        $minutes = $this->Entity->get('Takeaway')->getSettings()->getCurrentDeliveryTime();
        return $this->_getWaitingTime($minutes);
    }

    /**
     * Returns the estimated waiting time
     * 
     * @return type
     */
    public function getCollectionWaitingTime() {
        $minutes = $this->Entity->get('Takeaway')->getSettings()->getCurrentCollectionTime();
        return $this->_getWaitingTime($minutes);
    }

    /**
     * Returns the waiting time for given minutes
     * 
     * @param type $minutes
     * @return type
     */
    protected function _getWaitingTime($minutes) {
        $time = mktime(0, $minutes);
        $hours = (int) date('H', $time);
        $minutes = (int) date('i', $time);
        $return = '';
        if ($hours > 0) {
            $return .= $hours . ' hour';
            if ($hours > 1) {
                $return .= 's';
            }
        }
        if ($minutes > 0) {
            $return .= ' ' . $minutes . ' minute';
            if ($minutes > 1) {
                $return .= 's';
            }
        }
        return trim($return);
    }

    /**
     * Returns the opening hours HTML
     * 
     * @return string
     */
    public function getOpeningHours() {

        $openingHours = $this->Entity->get('Takeaway')->getOpeningHours(true);

        $return = '';

        /**
         * Go through each day
         */
        if (!is_null($openingHours)) {
            $return = '<div class="row"><div class="col-xs-12">';
            foreach ($openingHours as $day => $details) {
                $times = '';
                foreach($details as $detail){
                    $times .= '<div>' . substr_replace($detail['StartTime'] ,"",-3) . ' - ' . substr_replace($detail['EndTime'] ,"",-3) . '</div>';
                }
                $return .= '<div class="row">';
                $return .= '<div class="col-xs-4 col-sm-3 text-right label-div">' . ucwords($day) . ':</div>';
                $return .= '<div class="col-xs-6 col-sm-9">' . $times . '</div>';
                $return .= '</div>';
            }
            $return .= '</div></div>';
        }

        

        return $return;
    }

    /**
     * Returns the takeaways address formatted
     * 
     * 
     * @param string $sep
     */
    public function getAddress($sep = ',') {
        $return = array();

        $address = $this->Entity->get('Takeaway')->getAddress();
        
        if (!is_null($address->getAddressLineOne()) && $address->getAddressLineOne() != '') {
            $return[] = $address->getAddressLineOne();
        }

        if (!is_null($address->getAddressLineTwo()) && $address->getAddressLineTwo() != '') {
            $return[] = $address->getAddressLineTwo();
        }

        if (!is_null($address->getAddressLineThree()) && $address->getAddressLineThree() != '') {
            $return[] = $address->getAddressLineThree();
        }

        if (!is_null($address->getAddressLineFour()) && $address->getAddressLineFour() != '') {
            $return[] = $address->getAddressLineFour();
        }

        if (!is_null($address->getPostcode()) && $address->getPostcode() != '') {
            $return[] = $address->getPostcode();
        }

        return implode($sep, $return);
    }

    /**
     * Returns the minimum delivery amount
     * 
     * @return type
     */
    public function getMinimumDeliveryAmount($format = true) {
        $return = $this->Entity->get('Takeaway')->getSettings()->getDeliveryMinOrder();

        if ($format === true) {
            $return = $this->formatMoney($return);
        }

        return $return;
    }

    /**
     * Returns the minimum dcollection amount
     * 
     * @return type
     */
    public function getMinimumCollectionAmount($format = true) {
        $return = $this->Entity->get('Takeaway')->getSettings()->getCollectionMinOrder();

        if ($format === true) {
            $return = $this->formatMoney($return);
        }

        return $return;
    }

    /**
     * Formats the money
     * 
     * @param float $amount
     * @param string $currency
     * @return string
     */
    public function formatMoney($amount, $currency = null) {

        if (is_null($currency)) {
            $currency = $this->Entity->get('Takeaway')->getCurrency()->getCode();
        }

        return $this->Number->currency($amount, $currency);
    }

    /**
     * Returns the current basket
     */
    public function getBasket() {
        /**
         * Temporarily set the basket contents
         */
        $basket = array(
            '144' => array(
                'amount' => 1,
                'price' => 5.60,
                'name' => 'Prawn Crackers'
            ),
            '136' => array(
                'amount' => 2,
                'price' => 8.40,
                'name' => 'Garlic Bread'
            ),
        );
        return $basket;
    }
    
    public function getPaymentMethods($orderType){
        $paymentMethods = $this->Entity->get('Takeaway')->getSettings()->getPaymentMethods($orderType);
        foreach($paymentMethods as $key => $index){
            $paymentMethods[$key] = ucwords($index);
        }
        return implode(' - ', $paymentMethods);
    }
}
    