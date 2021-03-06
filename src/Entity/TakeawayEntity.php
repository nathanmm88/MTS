<?php

namespace App\Entity;

use App\Entity\AbstractSession;
use App\Entity\Takeaway\TakeawayAddressEntity;
use App\Entity\Takeaway\CurrencyEntity;
use App\Entity\Takeaway\SettingsEntity;



class TakeawayEntity extends AbstractEntity
{
    /**
     * The prefix for the entity
     *
     * Everything will be stored under takeaway in the session
     *
     * @var string
     */
    public $prefix = 'takeaway';

    /**
     * Takeaway ID
     *
     * @var int
     */
    protected $id = null;

    /**
     * Takeaway address
     *
     * @var \App\Entity\Takeaway\TakeawayAddress
     */
    protected $address = null;

    /**
     * Takeaway telephone
     *
     * @var string
     */
    protected $telephone = null;

    /**
     * Takeaway email
     *
     * @var string
     */
    protected $email = null;

    /**
     * Takeaway currency
     *
     * @var App\Entity\Takeaway\CurrencyEntity
     */
    protected $currency = null;

    /**
     * Takeaway opeining hours
     *
     * @var App\Entity\Takeaway\CurrencyEntity
     */
    protected $opening_hours = [];

    /**
     * Takeaway delivery charges
     *
     * @var App\Entity\Takeaway\CurrencyEntity
     */
    protected $delivery_charges = [];

    /**
     * Takeaway active flag (licensing)
     *
     * @var bool
     */
    protected $active = false;

    /**
     * Constants
     */
    const ORDER_TYPE_DELIVERY = 'delivery',
        ORDER_TYPE_COLLECTION = 'collection';

    /**
     * Getters
     */

    /**
     * Returns the takeaway ID
     *
     * @return string
     */
    public function getId() {
        return $this->_get('id');
    }

    /**
     * Returns the takeaway name
     *
     * @return string
     */
    public function getName() {
        return $this->_get('name');
    }

    /**
     * Returns the takeaway telephone number
     *
     * @return string
     */
    public function getTelephone() {
        return $this->_get('telephone');
    }

    /**
     * Checks if the takeaway has a telephone number
     *
     * @return boolean
     */
    public function hasTelephone() {
        return is_null($this->getTelephone()) ? false : true;
    }

    /**
     * Returns the takeaway email address
     *
     * @return string
     */
    public function getEmail() {
        return $this->_get('email');
    }

    /**
     * Checks if the takeaway has an email address
     *
     * @return boolean
     */
    public function hasEmail() {
        return is_null($this->getEmail()) ? false : true;
    }

    /**
     * Returns the takeaway address
     *
     * @return \App\Entity\Takeaway\TakeawayAddressEntity
     */
    public function getAddress() {
        return TakeawayAddressEntity::fromArray($this->_get('address'), $this->request);
    }

    /**
     * Returns the tcurrency
     *
     * @return \App\Entity\Takeaway\CurrencyEntity
     */
    public function getCurrency() {
        return CurrencyEntity::fromArray($this->_get('currency'), $this->request);
    }

    /**
     * Returns the settings
     *
     * @return \App\Entity\Takeaway\SettingsEntity
     */
    public function getSettings() {
        return SettingsEntity::fromArray($this->_get('settings'), $this->request);
    }

    /**
     * Returns the opeing hours
     *
     * @param boolean $grouped determines if the details should be grouped or not
     * @return array
     */
    public function getOpeningHours($grouped = false) {

        $openingHours = $this->_get('opening_hours');

        if ($grouped === true) {
            $returnOpeningHours = [];
            foreach ($openingHours as $detail) {
                if (!array_key_exists($detail['DayDesc'], $returnOpeningHours)) {
                    $returnOpeningHours[$detail['DayDesc']] = [];
                }
                $returnOpeningHours[$detail['DayDesc']][] = $detail;
            }
            $openingHours = $returnOpeningHours;
        }

        return $openingHours;
    }

    /**
     * Returns the max opening time for the day, this is because we can have
     * more than one opening time in a day
     */
    public function getMaxOpeningTime($day = null) {

        //default value to return
        $return = 0;

        //if null then get today
        if (is_null($day)) {
            $day = date('l');
        }

        $openingHours = $this->getOpeningHours(true);

        if (array_key_exists($day, $openingHours)) {
            foreach ($openingHours[$day] as $openingHours) {
                $time = strtotime(date('Y-m-d ') . $openingHours['EndTime']);
                if ($time > $return) {
                    $return = $time;
                }
            }
        }

        //return the latest found time
        return $return;
    }

    /**
     * Returns the delivery charges
     *
     * @return array
     */
    public function getDeliveryCharges() {
        return $this->_get('delivery_charges');
    }

    /**
     * Returns the delivery cost
     *
     * @param int $miles
     * @return int|false
     */
    public function getDeliveryCost($miles) {
        $return = false;
        $deliveryCharges = $this->getDeliveryCharges();
        foreach ($deliveryCharges as $deliveryCharge) {
            if ($deliveryCharge['MilesTo'] != '' && $miles < $deliveryCharge['MilesTo']) {
                return $deliveryCharge['Cost'];
            }
        }
        return $return;
    }

    /**
     * Returns the logo URL
     *
     * @return string
     */
    public function getLogo() {
        return $this->_get('logo');
    }

    /**
     * Returns the active flag
     *
     * @return bool
     */
    public function isActive() {
        return $this->_get('active');
    }

    /**
     * Setters
     */

    /**
     * Sets the takeaway ID
     *
     * @param int $id
     * @return App\Entity\TakeawayEntity
     */
    public function setId($id) {
        $this->_set('id', $id);
        return $this;
    }

    /**
     * Sets the takeaway name
     *
     * @param string $name
     * @return App\Entity\TakeawayEntity
     */
    public function setName($name) {
        $this->_set('name', $name);
        return $this;
    }

    /**
     * Sets the takeaway name
     *
     * @param string $telephone
     * @return string
     */
    public function setTelephone($telephone) {
        $this->_set('telephone', $telephone);
        return $this;
    }

    /**
     * Sets the takeaway email address
     *
     * @param string $email
     * @return string
     */
    public function setEmail($email) {
        $this->_set('email', $email);
        return $this;
    }

    /**
     * Sets the takeaway address
     *
     * @param \App\Entity\Takeaway\TakeawayAddressEntity $takeawayAddress
     * @return \App\Entity\TakeawayEntity
     */
    public function setAddress(Takeaway\TakeawayAddressEntity $takeawayAddress) {
        $this->_set('address', $takeawayAddress->toArray());
        return $this;
    }

    /**
     * Sets the currency
     *
     * @param \App\Entity\Takeaway\CurrencyEntity $currency
     * @return \App\Entity\TakeawayEntity
     */
    public function setCurrency(CurrencyEntity $currency) {
        $this->_set('currency', $currency->toArray());
        return $this;
    }

    /**
     * Sets the takeaway settings
     *
     * @param \App\Entity\Takeaway\SettingsEntity $settings
     * @return \App\Entity\TakeawayEntity
     */
    public function setSettings(SettingsEntity $settings) {
        $this->_set('settings', $settings->toArray());
        return $this;
    }

    /**
     * Sets the opeing hours
     *
     * @param array $openingHours
     * @return \App\Entity\TakeawayEntity
     */
    public function setOpeningHours($openingHours) {
        $this->_set('opening_hours', $openingHours);
        return $this;
    }

    /**
     * Sets the delivery charges
     *
     * @param array $deliveryCharges
     * @return \App\Entity\TakeawayEntity
     */
    public function setDeliveryCharges($deliveryCharges) {
        $this->_set('delivery_charges', $deliveryCharges);
        return $this;
    }

    /**
     * Sets the logo URL
     *
     * @param array $logo
     * @return \App\Entity\TakeawayEntity
     */
    public function setLogo($logo) {
        $this->_set('logo', $logo);
        return $this;
    }

    /**
     * Sets the active flag
     *
     * @param array $active
     * @return \App\Entity\TakeawayEntity
     */
    public function setActive($active) {
        $this->_set('active', $active);
        return $this;
    }


    /**
     * Whether the takeaway is online
     *
     * @return bool
     */
    public function isOnline() {
        //get the current time
        $now = date('H:i:s');

        //get today's opening hours/times
        $openingHours = $this->_getOpeningHoursForToday();
        $startTime = $openingHours['StartTime'];
        $endTime = $openingHours['EndTime'];

        //work out whether the current time is within the opening hours
        if ((empty($openingHours)) || ($now > $endTime) || ($now < $startTime)) {
            $open = false;
        } else {
            $open = true;
        }
        return $open;
    }

    /**
     * Returns the opening hours for today
     *
     * @return array
     * @throws Exception
     */
    private function _getOpeningHoursForToday() {
        //initialise return array
        $return = [];

        //get today's dat of the week
        $day = date('w');

        //get all opening hours
        $allOpeningHours = $this->getOpeningHours();

        //loop through each opening hours
        foreach ($allOpeningHours as $openingHours) {
            //if these are today's opening hours
            if ($day == $openingHours['DayID']) {
                //return the opening hours
                $return = $openingHours;
            }
        }

        return $return;
    }

}