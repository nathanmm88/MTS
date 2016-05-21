<?php

namespace App\API;

use App\API\AbstractCall;
use App\Lib\DotNotation;
use App\Entity\Takeaway\CurrencyEntity;
use App\Entity\Takeaway\TakeawayAddressEntity;
use App\Entity\Takeaway\SettingsEntity;

class GetSettingsCall extends AbstractCall {

    public function handleResult($response) {
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

}
