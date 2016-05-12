<?php

namespace App\Entity\Takeaway;

use App\Entity\AbstractEntity;

class TakeawayAddressEntity extends AbstractEntity
{
    /**
     * The prefix for the entity
     * 
     * Everything will be stored under takeaway => takeaway_address in the session
     * 
     * @var string
     */
    public $prefix = 'takeaway.address';
    
    /**
     * Address line one
     * 
     * @var string 
     */
    protected $address_line_one = '';
    
    /**
     * Address line two
     * 
     * @var string 
     */
    protected $address_line_two = '';
    
    /**
     * Address line three
     * 
     * @var string 
     */
    protected $address_line_three = '';
    
    /**
     * Address line four
     * 
     * @var string 
     */
    protected $address_line_four = '';
    
    /**
     * Postcode
     * 
     * @var string 
     */
    protected $postcode = '';
    
    /**
     * Latitude
     * 
     * @var string 
     */
    protected $latitude = '';
    
    /**
     * Longitude
     * 
     * @var string 
     */
    protected $longitude = '';
    
    /**
     * Getters
     */

    /**
     * Returns address line one
     * 
     * @return string
     */
    public function getAddressLineOne() {
        return $this->address_line_one;
    }

    /**
     * Returns address line two
     * 
     * @return string
     */
    public function getAddressLineTwo() {
        return $this->address_line_two;
    }

    /**
     * Returns address line three
     * 
     * @return string
     */
    public function getAddressLineThree() {
        return $this->address_line_three;
    }

    /**
     * Returns address line four
     * 
     * @return string
     */
    public function getAddressLineFour() {
        return $this->address_line_four;
    }

    /**
     * Returns postcode
     * 
     * @return string
     */
    public function getPostcode() {
        return $this->postcode;
    }

    /**
     * Returns latitude
     * 
     * @return string
     */
    public function getLatitude() {
        return $this->latitude;
    }

    /**
     * Returns longitude
     * 
     * @return string
     */
    public function getLongitude() {
        return $this->longitude;
    }

    /**
     * Setters
     */
    
    /**
     * Sets address line one
     * 
     * @param string $address_line_one
     * @return \App\Entity\Takeaway\TakeawayAddressEntity
     */
    public function setAddressLineOne($address_line_one) {
        $this->address_line_one = $address_line_one;
        return $this;
    }

    /**
     * Sets address line two
     * 
     * @param string $address_line_two
     * @return \App\Entity\Takeaway\TakeawayAddressEntity
     */
    public function setAddressLineTwo($address_line_two) {
        $this->address_line_two = $address_line_two;
        return $this;
    }

    /**
     * Sets address line three
     * 
     * @param string $address_line_three
     * @return \App\Entity\Takeaway\TakeawayAddressEntity
     */
    public function setAddressLineThree($address_line_three) {
        $this->address_line_three = $address_line_three;
        return $this;
    }

    /**
     * Sets address line four
     * 
     * @param string $address_line_four
     * @return \App\Entity\Takeaway\TakeawayAddressEntity
     */
    public function setAddressLineFour($address_line_four) {
        $this->address_line_four = $address_line_four;
        return $this;
    }

    /**
     * Sets postcode
     * 
     * @param string $postcode
     * @return \App\Entity\Takeaway\TakeawayAddressEntity
     */
    public function setPostcode($postcode) {
        $this->postcode = $postcode;
        return $this;
    }

    /**
     * Sets latitude
     * 
     * @param string $latitude
     * @return \App\Entity\Takeaway\TakeawayAddressEntity
     */
    public function setLatitude($latitude) {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * Sets longitude
     * 
     * @param string $longitude
     * @return \App\Entity\Takeaway\TakeawayAddressEntity
     */
    public function setLongitude($longitude) {
        $this->longitude = $longitude;
        return $this;
    }

}