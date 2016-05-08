<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Core\Configure;

class TakeawayHelper extends Helper
{
    /**
     * Checks if the ordering system is online
     * 
     * @return boolean
     */
    public function isOnline(){
        return (bool) Configure::read('takeaway.order_settings.status');
    }
    
    /**
     * Checks if the takeaway is accepting delivery orders
     * 
     * @return boolean
     */
    public function isDelivering(){
        return (bool)Configure::read('takeaway.order_settings.delivery');
    }
    
    /**
     * Checks if the takeaway is accepting collection orders
     * 
     * @return boolean
     */
    public function isCollection(){
        return (bool)Configure::read('takeaway.order_settings.collection');
    }
    
    /**
     * Checks if the takeaway is accepting collection and delivery orders
     * 
     * @return boolean
     */
    public function isDeliveryAndCollection(){
        return ($this->isDelivering() && $this->isCollection());
    }
    
    /**
     * Returns the estimated waiting time
     * 
     * @return type
     */
    public function getDeliveryWaitingTime(){
        $minutes = Configure::read('takeaway.order_settings.delivery_time');
        return $this->_getWaitingTime($minutes);
    }
    
    /**
     * Returns the estimated waiting time
     * 
     * @return type
     */
    public function getCollectionWaitingTime(){
        $minutes = Configure::read('takeaway.order_settings.collection_time');
        return $this->_getWaitingTime($minutes);
    }
    
    /**
     * Returns the waiting time for given minutes
     * 
     * @param type $minutes
     * @return type
     */
    protected function _getWaitingTime($minutes){
        $time = mktime(0,$minutes);
        $hours = (int)date('H', $time);
        $minutes = (int)date('i', $time);
        $return = '';
        if($hours > 0){
            $return .= $hours . ' hour';
            if($hours > 1){
                $return .= 's';
            }
        }
        if($minutes > 0){
            $return .= ' ' . $minutes . ' minute';
            if($minutes > 1){
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
    public function getOpeningHours(){
        
        $return = '<div class="row"><div class="col-xs-12">';
        
        /**
         * Go through each day
         */
        if(!is_null(Configure::read('takeaway.opening_hours'))){
            foreach(Configure::read('takeaway.opening_hours') as $day => $times){
                $return .= '<div class="row">';
                $return .= '<div class="col-xs-4 col-sm-3 text-right label-div">' . ucwords($day) . ':</div>';
                $return .= '<div class="col-xs-6 col-sm-9">' . $times . '</div>';
                $return .= '</div>';
            }
        }
        
        $return .= '</div></div>';
        
        return $return;
        
    }
    
    /**
     * Returns the takeaways address formatted
     * 
     * @param string $sep
     */
    public function getAddress($sep = ','){
        $return = array();
        
        if(!is_null(Configure::read('takeaway.contact_details.address_line_one')) && Configure::read('takeaway.contact_details.address_line_one') != ''){
            $return[] = Configure::read('takeaway.contact_details.address_line_one');
        }
        
        if(!is_null(Configure::read('takeaway.contact_details.address_line_two')) && Configure::read('takeaway.contact_details.address_line_two') != ''){
            $return[] = Configure::read('takeaway.contact_details.address_line_two');
        }
        
        if(!is_null(Configure::read('takeaway.contact_details.address_line_three')) && Configure::read('takeaway.contact_details.address_line_three') != ''){
            $return[] = Configure::read('takeaway.contact_details.address_line_three');
        }
        
        if(!is_null(Configure::read('takeaway.contact_details.address_line_four')) && Configure::read('takeaway.contact_details.address_line_four') != ''){
            $return[] = Configure::read('takeaway.contact_details.address_line_four');
        }
        
        if(!is_null(Configure::read('takeaway.contact_details.postcode')) && Configure::read('takeaway.contact_details.postcode') != ''){
            $return[] = Configure::read('takeaway.contact_details.postcode');
        }
        
        return implode($sep, $return);
    }
    
    /**
     * Returns the takeaway name
     * 
     * @return string
     */
    public function getName(){
        return Configure::read('takeaway.name');
    }
    
    /**
     * Returns the takeaway logo URL
     * 
     * @return string
     */
    public function getLogo(){
        return Configure::read('takeaway.logo');
    }
}

