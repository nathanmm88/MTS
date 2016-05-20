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
use App\Entity\Menu\MenuItemVariationEntity;

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

        //build the request message and make the request
        $response = $this->_makeRequest(
                '/api/Takeaway/GetSettings', $this->_createRequestMessage([
                    'takeawayID' => $this->takeaway->getId(),
                    'domain' => $this->request->host(),
                    'subDomain' => '',
                ])
        );

        //load in the dot notation class so we can access the values easily
        $responseDotNotation = new DotNotation($response);

        //set the takeaway details
        $this->takeaway->setId($responseDotNotation->get('Takeaway.TakeawayID'))
                ->setName($responseDotNotation->get('Takeaway.Name'))
                ->setTelephone($responseDotNotation->get('Takeaway.PhoneNumber'))
                ->setEmail($responseDotNotation->get('Takeaway.EmailAddress'))
                ->setOpeningHours($responseDotNotation->get('OpeningHours', []))
                ->setDeliveryCharges($responseDotNotation->get('DeliveryCharges', []))
                ->setLogo($responseDotNotation->get('Logo', '/tmp/logo.png'));

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
                    'latitude' => $responseDotNotation->get('Takeaway.Latitide'),
                    'longitude' => $responseDotNotation->get('Takeaway.Longitude')
                        ], $this->request);

        $this->takeaway->setAddress($address);

        //set the settings
        $settings = SettingsEntity::fromArray([
                    'delivery_min_order' => $responseDotNotation->get('TakeawaySettings.DeliveryMinOrder', 0),
                    'collection_min_order' => $responseDotNotation->get('TakeawaySettings.CollectionMinOrder', 0),
                    'current_delivery_time' => $responseDotNotation->get('TakeawaySettings.CurrentDeliveryTime', 0),
                    'current_collection_time' => $responseDotNotation->get('TakeawaySettings.CurrentCollectionTime', 0),
                    'accept_delivery_orders' => 1, //$responseDotNotation->get('TakeawaySettings.AcceptDeliveryOrders', 0),
                    'accept_collection_orders' => $responseDotNotation->get('TakeawaySettings.AcceptCollectionOrders', 0),
                    'active' => $responseDotNotation->get('TakeawaySettings.TakeawayActive', 0),
                    'has_website' => $responseDotNotation->get('TakeawaySettings.UseWebSite', 0),
                    'payment_methods' => $responseDotNotation->get('TakeawaySettings.PaymentMethods', [
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
        //first thing - clear down the menu
        $this->menu->clear();

        //make the request
        $response = $this->_makeRequest(
                '/api/Takeaway/GetMenu', $this->_createRequestMessage([
                    'takeawayID' => $this->takeaway->getId(),
                    'domain' => $this->request->host(),
                    'subDomain' => '',
                ])
        );

        //load in the dot notation class so we can access the values easily
        $responseDotNotation = new DotNotation($response);

        //set the takeaway details
        $this->menu->setId($responseDotNotation->get('Menu.MenuID'))
                ->setTakeawayID($responseDotNotation->get('Menu.TakeawayID'))
                ->setDescription($responseDotNotation->get('Menu.MenuDescription'));

        //loop through the sections 
        foreach ($responseDotNotation->get('MenuSections') as $key => $section) {
            
            //set in the dot notation
            $sectionDotNotation = new DotNotation($section['MenuSection']);
            
            //set the values to the entity
            $sectionEntity = MenuSectionEntity::fromArray([
                        'id' => $sectionDotNotation->get('MenuSectionID'),
                        'menu_id' => $sectionDotNotation->get('MenuID'),
                        'name' => $sectionDotNotation->get('MenuSectionName'),
                        'description' => $sectionDotNotation->get('MenuSectionDesc'),
                        'active' => $sectionDotNotation->get('Active'),
                        'position' => $sectionDotNotation->get('Position'),
                            ], $this->request);

            //save this entity to the session
            $this->menu->addSection($sectionEntity);

            //loop through each menu item
            foreach ($section['MenuItems'] as $item) {
                
                //set in the dot notation
                $itemDotNotation = new DotNotation($item);

                //set the values
                $menuItem = MenuItemEntity::fromArray([
                            'id' => $itemDotNotation->get('MenuItem.MenuItemID'),
                            'section_id' => $itemDotNotation->get('MenuItem.MenuSectionID'),
                            'name' => $itemDotNotation->get('MenuItem.MenuItemName'),
                            'description' => $itemDotNotation->get('MenuItem.MenuItemDesc'),
                            'price' => $itemDotNotation->get('MenuItem.Price'),
                            'active' => $itemDotNotation->get('MenuItem.Active'),
                            'deleted' => $itemDotNotation->get('MenuItem.Deleted'),
                            'position' => $itemDotNotation->get('MenuItem.Position'),
                            'heat' => $itemDotNotation->get('MenuItem.Heat'),
                            'vegetarian' => $itemDotNotation->get('MenuItem.Vegetarian'),
                            'gluten_free' => $itemDotNotation->get('MenuItem.GlutenFree'),
                            'dairy_free' => $itemDotNotation->get('MenuItem.DairyFree'),
                            'may_contain_bones' => $itemDotNotation->get('MenuItem.MayContainBones'),
                            'has_variations' => ((count($itemDotNotation->get('Variations')) > 0) ? true : false)
                                ], $this->request);

                //save this entity to the session
                $this->menu->addItem($menuItem);


                foreach ($itemDotNotation->get('Variations') as $variation) {
                    
                    //set in the dot notation
                    $variationDotNotation = new DotNotation($variation);
                    
                    $variationEntity = MenuItemVariationEntity::fromArray([
                                'id' => $variationDotNotation->get('MenuItem_VariationID'),
                                'parent_id' => $variationDotNotation->get('MenuItemID'),
                                'parent_name' => $itemDotNotation->get('MenuItem.MenuItemName'),
                                'name' => $variationDotNotation->get('VariationName'),
                                'description' => $variationDotNotation->get('VariationDesc'),
                                'price' => $variationDotNotation->get('Price'),
                                'active' => $variationDotNotation->get('Active'),
                                'deleted' => $variationDotNotation->get('Deleted'),
                                'position' => $variationDotNotation->get('Position'),
                                'heat' => $variationDotNotation->get('Heat'),
                                'vegetarian' => $variationDotNotation->get('Vegetarian'),
                                'gluten_free' => $variationDotNotation->get('GlutenFree'),
                                'dairy_free' => $variationDotNotation->get('DairyFree'),
                                'may_contain_bones' => $variationDotNotation->get('MayContainBones'),
                                    ], $this->request);
                    
                    //save this entity to the session
                    $this->menu->addVariation($variationEntity);
                }
                //loop through the condiment types
                foreach ($itemDotNotation->get('CondimentTypes') as $condimentType) {
                    
                    $condimentTypeDotNotation = new DotNotation($condimentType);
                    
                    //set the values
                    $condimentTypeEntity = CondimentTypeEntity::fromArray([
                                'id' => $condimentTypeDotNotation->get('CondimentType.CondimentTypeID'),
                                'item_id' => $itemDotNotation->get('MenuItem.MenuItemID'),
                                'description' => $condimentTypeDotNotation->get('CondimentType.CondimentTypeDesc'),
                                    ], $this->request);

                    //save this entity to the session
                    $this->menu->addCondimentType($condimentTypeEntity);

                    foreach ($condimentTypeDotNotation->get('Condiments') as $condiment) {
                        
                        $condimentDotNotation = new DotNotation($condiment);
                        
                        //set the values to the entity
                        $condimentEntity = CondimentEntity::fromArray([
                                    'id' => $condimentDotNotation->get('CondimentID'),
                                    'condiment_type_id' => $condimentDotNotation->get('CondimentTypeID'),
                                    'name' => $condimentDotNotation->get('CondimentName'),
                                    'description' => $condimentDotNotation->get('CondimentDesc'),
                                    'active' => $condimentDotNotation->get('Active'),
                                    'deleted' => $condimentDotNotation->get('Deleted'),
                                    'additional_cost' => $condimentDotNotation->get('AdditionalCost'),
                                     ], $this->request);

                        //save this entity to the session
                        $this->menu->addCondiment($condimentEntity);
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

    /**
     * Returns the request message body
     * 
     * @param array $data
     * @return type
     */
    protected function _createRequestMessage($data) {
        return http_build_query($data);
    }

}
