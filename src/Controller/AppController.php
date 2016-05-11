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
use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize() {
        parent::initialize();

        //$this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Api');
        $this->helpers[] = 'Takeaway';
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event) {
        if (!array_key_exists('_serialize', $this->viewVars) &&
                in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    /**
     * Possible temp function
     * 
     * Look to replace this for open source service
     * 
     * @param string $postcode
     * @return array
     */
    protected function geolocatePostcode($postcode) {
        $url = "https://api.postcodes.io/postcodes/" . urlencode($postcode);
        //die(var_dump($url));
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //TODO Fix the curl ssl issue
        $result = curl_exec($curl);
        $result = json_decode($result, true);

        if ($result['status'] == '404') {
            return false;
        }
        return $result['result'];
    }

    /**
     * Get the distance between two lat long positions
     * 
     * @param type $lat1
     * @param type $lon1
     * @param type $lat2
     * @param type $lon2
     * @param type $unit
     * @return type
     */
    public function getDistanceBetweenLocations($lat1, $lon1, $lat2, $lon2, $unit = 'M') {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }
    
    /**
     * Gets the delivery cost
     * 
     * @return float|false
     */
    public function getDeliveryCost($distance){
        
        $distances = Configure::read('takeaway.order_settings.delivery_costs');
        
        //go through each one and return the first instance found
        foreach($distances as $miles => $cost){
            if($miles > $distance){
                return $cost;
            }
        }
        
        //none found
        return false;
        
    }

}
