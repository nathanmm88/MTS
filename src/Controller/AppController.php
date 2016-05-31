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
use App\Entity\TakeawayEntity;
use App\Entity\OrderEntity;
use App\Entity\StepEntity;
use App\Entity\SecurityEntity;
use App\Entity\MenuEntity;

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
     * The steps we want to lock down for a diven controller
     * 
     * Default off
     * 
     * @var null|array 
     */
    public $steps = null;
    
    /**
     * The takeaway
     * 
     * @var string
     */
    public $current_step = '';
    
    /**
     *The default step that should be used if the user has no step yet
     * 
     * @var string
     */
    public $default_step = '';
    
    /**
     * The current step
     * 
     * @var App\Entity\TakeawayEntity
     */
    public $takeaway = null;
    
    /**
     * The order class
     * 
     * @var App\Entity\OrderEntity
     */
    public $order = null;
    
    /**
     * The step class
     * 
     * @var App\Entity\StepEntity
     */
    public $step = null;
    
    /**
     * The security class
     * 
     * @var App\Entity\SecurityEntity
     */
    public $security = null;
    
    /**
     * The entities we want to load
     * 
     * @var array
     */
    public $entities = array(
        'Takeaway',
        'Order',
        'Security',
        'Step',
        'Menu',
        'Menu.MenuSection',
        'Menu.MenuItem',
        'Menu.MenuItemVariation'
    );
    
    /**
     * The API component
     * 
     * @var App\Controller\Component\APIComponent
     */
    public $api = null;
    
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

        $this->helpers[] = 'Takeaway';
        $this->helpers[] = 'Entity';
        $this->helpers[] = 'Menu';
        $this->helpers[] = 'Step';
        
        //load the entities
        $this->_addEntities();
        
        //$this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Api');
        
        
        //get the current controller_action
        $this->current_step = strtolower($this->request->controller . '_' . $this->request->action);
        
        //make sure we call the settings everytime once the app has initialised 
        //but before we do anything
        if (!$this->request->is('ajax')){            
            $this->Api->setSettings();
        }
    }
    
    
    
    /**
     * Load the entities and set in the view ready for use in the helper
     */
    protected function _addEntities(){
        //load the session classes
        $entities = array();
        foreach($this->entities as $entityName){
            //work out if this is a sub entity
            if (strpos($entityName, '.')){
                $entityParts = explode('.', $entityName);                
                $entityClassName = 'App\Entity\\' . $entityParts[0] . '\\'.$entityParts[1].'Entity';                
            } else {                
                $entityClassName = 'App\Entity\\' . $entityName . 'Entity';
            }
            
            $this->{strtolower($entityName)} = new $entityClassName($this->request);
            $entities[$entityName] = $this->{strtolower($entityName)};
        }
        
        //set them for the helper
        $this->set('entities', $entities);
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
        if($this->step->getCurrentStep() === 'order_confirm'){
            $this->set('noCheckoutBtn', true);
        }
    }
    
    /**
     * Checks if the current controller has locked down steps
     * 
     */
    public function _checkStep(){
        //if null or not in the restricted steps ignore this
        if(!is_null($this->steps) && in_array($this->current_step, $this->steps)){
            
            //now we are on a locked down part of the journey lets make sure the session hasnt timed out
            $this->_checkSessionTimeout();
            
            //get the current step
            $currentSessionStep = $this->step->getCurrentStep();
            
            //check we have a step
            if(is_null($currentSessionStep)){
                //get the default step
                $defaultStep = $this->default_step;
                //redirect to the first step
                if($defaultStep != $this->current_step){
                    $this->_redirectToStep($defaultStep);
                } else {
                    //set the step name for next time round
                    $this->step->setCurrentStep($this->current_step);
                }
                
            } else if ($this->current_step != $currentSessionStep){ //if we have a step make sure its the correct one
                //redirect to the step we should be on
                $this->_redirectToStep($currentSessionStep);
            }
        }
    }
    
    /**
     * Checks the session timeout
     */
    protected function _checkSessionTimeout(){
        
        //if the session has timed out
        if($this->step->hasTimedOut(true)){
            throw new \App\Exception\SessionTimeoutException('Session has timed out');
        }
    }
    
    /**
     * Redirects to a step
     * 
     * @param string $stepName controller_action
     */
    protected function _redirectToStep($stepName){
        
        //step name is controller_action
        $parts = explode('_', $stepName);
        
        //set the new step name
        $this->step->setCurrentStep($stepName);
        
        //now redirect to the new step
        $this->redirect([
            'controller' => $parts[0],
            'action' => $parts[1]
        ]);
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
        $url = "https://api.postcodes.io/postcodes/" . urlencode(str_replace(' ', '', $postcode));
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
