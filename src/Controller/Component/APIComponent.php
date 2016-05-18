<?php

namespace App\Controller\Component;

use App\Controller\Component\AbstractComponent;
use Cake\Network\Http\Client;
use Cake\Core\Configure;
use App\Lib\DotNotation;
use App\Entity\Takeaway\TakeawayAddressEntity;
use App\Entity\Takeaway\CurrencyEntity;
use App\Entity\Takeaway\SettingsEntity;
use App\Entity\Menu\MenuSectionEntity;
use App\Entity\Menu\MenuItemEntity;
use App\Entity\Menu\CondimentTypeEntity;
use App\Entity\Menu\CondimentEntity;

class APIComponent extends AbstractComponent {

    /**
     * Sets the token up ready to use the API
     * 
     */
    public function setToken() {

        if (!$this->security->hasAPIToken()) {
            $response = $this->_makeRequest(
                    'Token', 'grant_type=' . Configure::read('api.grant_type') . '&username=' . Configure::read('api.user') . '&password=' . Configure::read('api.password'), false
            );

            if (!array_key_exists('access_token', $response)) {
                throw new Exception('No token returned!');
            }

            if (!array_key_exists('token_type', $response)) {
                throw new Exception('No token type returned!');
            }

            $this->security->setAPIToken($response['access_token'])
                    ->setTokenType($response['token_type']);
        }
    }

    /**
     * Makes the get setting API call
     */
    public function setSettings() {
        $response = $this->_makeRequest(
                '/api/Takeaway/GetSettings?takeawayID=1&domain=&subDomain=', 'takeawayID=1&domain=&subDomain='
        );

        //load in the dot notation class so we can access the values easily
        $responseDotNotation = new DotNotation($response);

        //set the takeaway details
        $this->takeaway->setId($responseDotNotation->get('Takeaway.TakeawayID'))
                ->setName($responseDotNotation->get('Takeaway.Name'))
                ->setTelephone($responseDotNotation->get('Takeaway.PhoneNumber'))
                ->setEmail($responseDotNotation->get('Takeaway.EmailAddress'))
                ->setOpeningHours($responseDotNotation->get('OpeningHours', []))
                ->setDeliveryCharges($responseDotNotation->get('DeliveryCharges', []));

        //set the currency
        $currency = CurrencyEntity::fromArray([
                    'id' => $responseDotNotation->get('Takeaway.CurrencyID'),
                    'code' => $responseDotNotation->get('Takeaway.CurrencyCode', 'GBP'),
                        ], $this->request);

        $this->takeaway->setCurrency($currency);

        //set the address
        $address = TakeawayAddressEntity::fromArray([
                    'address_line_one' => $responseDotNotation->get('Takeaway.Address1'),
                    'address_line_two' => $responseDotNotation->get('Takeaway.Address2'),
                    'address_line_three' => $responseDotNotation->get('Takeaway.Town'),
                    'address_line_four' => $responseDotNotation->get('Takeaway.County'),
                    'postcode' => $responseDotNotation->get('Takeaway.PostCode'),
                    'latitude' => $responseDotNotation->get('Takeaway.Latitude'),
                    'longitude' => $responseDotNotation->get('Takeaway.Longitude')
                        ], $this->request);

        $this->takeaway->setAddress($address);

        //set the settings
        $settings = SettingsEntity::fromArray([
                    'delivery_min_order' => $responseDotNotation->get('TakeawaySettings.DeliveryMinOrder', 0),
                    'collection_min_order' => $responseDotNotation->get('TakeawaySettings.CollectionMinOrder', 0),
                    'current_delivery_time' => $responseDotNotation->get('TakeawaySettings.CurrentDeliveryTime', 0),
                    'current_collection_time' => $responseDotNotation->get('TakeawaySettings.CurrentCollectionTime', 0),
                    'accept_delivery_orders' => $responseDotNotation->get('TakeawaySettings.AcceptDeliveryOrders', 0),
                    'accept_collection_orders' => $responseDotNotation->get('TakeawaySettings.AcceptCollectionOrders', 0),
                    'active' => $responseDotNotation->get('TakeawaySettings.TakeawayActive', 0),
                    'has_website' => $responseDotNotation->get('TakeawaySettings.UseWebSite', 0),
                    'payment_methods' => $responseDotNotation->get('TakeawaySettings.UseWebSite', [
                        \App\Entity\TakeawayEntity::ORDER_TYPE_DELIVERY => [
                            SettingsEntity::PAYMENT_METHOD_PAYPAL,
                        ],
                        \App\Entity\TakeawayEntity::ORDER_TYPE_COLLECTION => [
                            SettingsEntity::PAYMENT_METHOD_CASH,
                            SettingsEntity::PAYMENT_METHOD_PAYPAL,
                        ]
                    ]),
                        ], $this->request);

        $this->takeaway->setSettings($settings);
    }

    public function getMenu() {
        unset($_SESSION['simplyindian_mytakeawaysite_localhost']['menu']); //NEED TO TIDY THIS LINE UP to clear down menu everytime we fetch?  

        $response = $this->_makeRequest(
                '/api/Takeaway/GetMenu?takeawayID=1&domain=&subDomain=', 'takeawayID=1&domain=&subDomain='
        );

        //load in the dot notation class so we can access the values easily
        $responseDotNotation = new DotNotation($response);

        //set the takeaway details
        $this->menu->setId($responseDotNotation->get('Menu.MenuID'))
                ->setTakeawayID($responseDotNotation->get('Menu.TakeawayID'))
                ->setDescription($responseDotNotation->get('Menu.MenuDescription'));

        //loop through the sections 
        foreach ($responseDotNotation->get('MenuSections') as $key => $section) {
            //set the values to the entity
            $sectionEntity = MenuSectionEntity::fromArray([
                        'id' => $section['MenuSection']['MenuSectionID'],
                        'menu_id' => $section['MenuSection']['MenuID'],
                        'name' => $section['MenuSection']['MenuSectionName'],
                        'description' => $section['MenuSection']['MenuSectionDesc'],
                        'active' => $section['MenuSection']['Active'],
                        'position' => $section['MenuSection']['Position'],
                            ], $this->request);

            //save this entity to the session
            $sectionEntity->_saveArray();

            //loop through each menu item
            foreach ($section['MenuItems'] as $item) {
                //set the values
                $menuItem = MenuItemEntity::fromArray([
                            'id' => $item['MenuItem']['MenuItemID'],
                            'section_id' => $item['MenuItem']['MenuSectionID'],
                            'name' => $item['MenuItem']['MenuItemName'],
                            'description' => $item['MenuItem']['MenuItemDesc'],
                            'price' => $item['MenuItem']['Price'],
                            'active' => $item['MenuItem']['Active'],
                            'deleted' => $item['MenuItem']['Deleted'],
                            'position' => $item['MenuItem']['Position'],
                            'heat' => $item['MenuItem']['Heat'],
                            'vegetarian' => $item['MenuItem']['Vegetarian'],
                            'gluten_free' => $item['MenuItem']['GlutenFree'],
                            'dairy_free' => $item['MenuItem']['DairyFree'],
                            'may_contain_bones' => $item['MenuItem']['MayContainBones'],
                                ], $this->request);

                //save this entity to the session
                $menuItem->_saveArray();

                //loop through the condiment types
                foreach ($item['CondimentTypes'] as $condimentType) {
                    //set the values
                    $condimentTypeEntity = CondimentTypeEntity::fromArray([
                                'id' => $condimentType['CondimentType']['CondimentTypeID'],
                                'item_id' => $item['MenuItem']['MenuItemID'],
                                'description' => $condimentType['CondimentType']['CondimentTypeDesc'],
                                    ], $this->request);

                    //save this entity to the session
                    $condimentTypeEntity->_saveArray();

                    foreach ($condimentType['Condiments'] as $condiment) {
                        //set the values to the entity
                        $condimentEntity = CondimentEntity::fromArray([
                                    'id' => $condiment['CondimentID'],
                                    'condiment_type_id' => $condiment['CondimentTypeID'],
                                    'name' => $condiment['CondimentName'],
                                    'description' => $condiment['CondimentDesc'],
                                    'active' => $condiment['Active'],
                                    'deleted' => $condiment['Deleted'],
                                    'additional_cost' => $condiment['AdditionalCost'],
                                        ], $this->request);
                        
                        //save this entity to the session
                        $condimentEntity->_saveArray();
                    }
                }
            }
        }       
    }

    /**
     * Makes a request to the API
     * 
     * @param string $messageBody
     */
    protected function _makeRequest($action, $messageBody, $needsToken = true) {
        //default headers
        $headers = ['Content-Type' => 'application/x-www-form-urlencoded'];

        //add the token if needed
        if ($needsToken) {
            //make sure we have the token
            $this->setToken();
            $headers['Authorization'] = $this->security->getAuthorisationToken();
        }

        $http = new Client();
        $response = $http->post(
                Configure::read('api.url') . $action, $messageBody, ['headers' => $headers]
        );

        $responseArray = json_decode($response->body(), true);

        if (array_key_exists('error', $responseArray)) {
            throw new Exception('Error returned in ' . $action . ' API call with the error ' . $responseArray['error']);
        }

        return $responseArray;
    }

}
