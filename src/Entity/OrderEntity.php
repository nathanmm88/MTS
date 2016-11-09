<?php

namespace App\Entity;

use App\Entity\AbstractSession;
use App\Entity\Order\ItemEntity;
use App\Entity\Order\OrderAddressEntity;
use App\Entity\MenuEntity;
use App\Entity\TakeawayEntity;
use App\Entity\Order\OrderItemCondimentEntity;
use App\Lib\Functions;

class OrderEntity extends AbstractEntity
{

    /**
     * The prefix for the entity
     *
     * Everything will be stored under order in the session
     *
     * @var string
     */
    public $prefix = 'order';

    /**
     * An array of items for this order
     *
     * @var type array
     */
    public $items = array();

    /**
     * Order type
     *
     * @var type string
     */
    public $type = '';

    /**
     * Order address
     *
     * @var \App\Entity\Order\OrderAddressEntity
     */
    public $address = '';

    /**
     * First name
     *
     * @var string
     */
    public $first_name = '';

    /**
     * Surname
     *
     * @var string
     */
    public $surname = '';

    /**
     * Fhone
     *
     * @var string
     */
    public $telephone = '';

    /**
     * Email address
     *
     * @var string
     */
    public $email = '';

    /**
     * Delivery time
     *
     * @var string
     */
    public $delivery_time = '';

    /**
     * Collection time
     *
     * @var string
     */
    public $collection_time = '';

    /**
     * Order ID
     * @var string
     */
    public $order_id = '';


    /**
     * Order type values mapped for the API
     *
     * @var array
     */
    public $mapped_order_type = [ORDER_TYPE_COLLECTION => 1, ORDER_TYPE_DELIVERY => 2];

    /**
     * Payment method values mapped for the API
     *
     * @var array
     */
    public $mapped_payment_methods = [PAYMENT_TYPE_CASH => 1, PAYMENT_TYPE_ONLINE => 2];

    /**
     * Payment method
     *
     * @var string
     */
    public $payment_method = '';

    /**
     * Payment status
     *
     * @var int
     */
    PUBLIC $payment_status = '';

    /**
     * Get the payment method
     *
     * @return string
     */
    public function getPaymentMethod() {
        return $this->_get('payment_method');
    }

    /**
     * Set the payment method
     *
     * @param string $payment_method
     */
    public function setPaymentMethod($payment_method) {
        $this->_set('payment_method', $payment_method);
        return $this;
    }

    /**
     * Get order ID
     *
     * @return string
     */
    public function getOrderId() {
        return $this->_get('order_id');
    }

    /**
     * Set order ID
     *
     * @param string $order_id
     */
    public function setOrderId($order_id) {
        $this->order_id = $order_id;
        return $this;
    }

    /**
     * Returns the order items
     *
     * @return \App\Entity\Order\ItemEntity
     */
    public function getItems() {
        $items = $this->_get('items');

        if (!is_array($items)) {
            $items = [];
        }

        foreach ($items as $key => $item) {
            $items[$key] = ItemEntity::fromArray($item);
        }

        return $items;
    }

    /**
     * Returns the order type
     *
     * @return string
     */
    public function getType() {
        return $this->_get('type');
    }

    /**
     * Checks if a supplied type is the current order type
     *
     * @param string $type
     * @return boolean
     */
    public function isType($type) {
        return $this->getType() == $type ? true : false;
    }

    /**
     * Checks if this is a delivery
     *
     * @return boolean
     */
    public function isDelivery() {
        return $this->isType(TakeawayEntity::ORDER_TYPE_DELIVERY);
    }

    /**
     * Returns the order address
     *
     * @return \App\Entity\Order\OrderAddressEntity
     */
    public function getAddress() {
        return OrderAddressEntity::fromArray($this->_get('address'), $this->request);
    }

    /**
     * Adds an item to the order
     *
     * @param ItemEntity $item
     * @return \App\Entity\OrderEntity
     */
    public function addItem(ItemEntity $item) {
        //get the current items
        $items = $this->_get('items');

        //if null default to an array
        if (is_null($items)) {
            $items = [];
        }

        $items[] = $item->toArray();

        //set the items back to the entity
        $this->_set('items', $items);

        return $this;
    }

    /**
     * Removes an order item from a specific index
     *
     * @param int $index
     * @return \App\Entity\OrderEntity
     */
    public function removeItem($index) {
        //get the current items
        $items = $this->_get('items');

        if (is_array($items) && array_key_exists($index, $items)) {
            unset($items[$index]);
        }

        //set the items back to the entity
        $this->_set('items', $items);

        return $this;
    }

    /**
     * Removes the condiments from an order item from a specific index
     *
     * @param int $index
     * @return \App\Entity\OrderEntity
     */
    public function removeCondiments($index) {
        //get the current items
        $condiments = $this->_get('condiments');

        if (is_array($condiments) && array_key_exists($index, $condiments)) {
            unset($condiments[$index]);
        }

        //set the condiments back to the entity
        $this->_set('condiments', $condiments);

        return $this;
    }

    /**
     * Returns the first name
     *
     * @return string
     */
    public function getFirstName() {
        return $this->_get('first_name');
    }

    /**
     * Surname
     *
     * @return string
     */
    public function getSurname() {
        return $this->_get('surname');
    }

    /**
     * Returns the telephone
     *
     * @return string
     */
    public function getTelephone() {
        return $this->_get('telephone');
    }

    /**
     * Returns the email
     *
     * @return string
     */
    public function getEmail() {
        return $this->_get('email');
    }

    /**
     * Returns the payment status ID
     *
     * @return int
     */
    public function getPaymentStatus(){
        return $this->_get('payment_status');
    }

    /**
     * Returns the delivery time
     *
     * @return int
     */
    public function getDeliveryTime() {
        return $this->_get('delivery_time');
    }

    /**
     * Returns the delivery time options
     *
     * @return array
     */
    public function getDeliveryTimeOptions() {

        //the array we want to store our times in
        $return = array('' => 'A.S.A.P');

        //get the takeaway entity
        $takeawayEntity = new TakeawayEntity($this->request);

        //get the time the takeaway is open until
        $maxTime = $takeawayEntity->getMaxOpeningTime();

        $dateTime = new \DateTime();

        $dateTime->add(new \DateInterval('PT' . $takeawayEntity->getSettings()->getCurrentDeliveryTime() . 'M'));

        $dateTime = Functions::roundTime($dateTime->getTimestamp(), 15);

        $loop = 1;

        while ($dateTime->getTimestamp() < $maxTime && $loop < 30) {
            $return[$dateTime->getTimestamp()] = $dateTime->format('H:ia');
            $dateTime->add(new \DateInterval('PT15M'));
            $loop++;
        }

        return $return;
    }

    /**
     * Returns the collection time options
     *
     * @return array
     */
    public function getCollectionTimeOptions() {

        //the array we want to store our times in
        $return = array('' => 'A.S.A.P');

        //get the takeaway entity
        $takeawayEntity = new TakeawayEntity($this->request);

        //get the time the takeaway is open until
        $maxTime = $takeawayEntity->getMaxOpeningTime();

        $dateTime = new \DateTime();

        $dateTime->add(new \DateInterval('PT' . $takeawayEntity->getSettings()->getCurrentCollectionTime() . 'M'));

        $dateTime = Functions::roundTime($dateTime->getTimestamp(), 15);

        $loop = 1;

        while ($dateTime->getTimestamp() < $maxTime && $loop < 30) {
            $return[$dateTime->getTimestamp()] = $dateTime->format('H:ia');
            $dateTime->add(new \DateInterval('PT15M'));
            $loop++;
        }

        return $return;
    }

    /**
     * Returns the collection time
     *
     * @return int
     */
    public function getCollectionTime() {
        return $this->_get('collection_time');
    }

    /**
     * Sets the order type
     *
     * @param string $type
     * @return \App\Entity\OrderEntity
     */
    public function setType($type) {
        $this->_set('type', $type);
        return $this;
    }

    /**
     * Returns the takeaway address
     *
     * @param \App\Entity\Order\OrderAddressEntity $address
     * @return \App\Entity\OrderEntity
     */
    public function setAddress(OrderAddressEntity $address) {
        $this->_set('address', $address->toArray());
        return $this;
    }

    /**
     * Sets the first name
     *
     * @param string $first_name
     * @return \App\Entity\OrderEntity
     */
    public function setFirstName($first_name) {
        $this->_set('first_name', $first_name);
        return $this;
    }

    /**
     * Sets the surname
     *
     * @param string $surname
     * @return \App\Entity\OrderEntity
     */
    public function setSurname($surname) {
        $this->_set('surname', $surname);
        return $this;
    }

    /**
     * Sets the telephone
     * @param type $telephone
     * @return \App\Entity\OrderEntity
     */
    public function setTelephone($telephone) {
        $this->_set('telephone', $telephone);
        return $this;
    }

    /**
     * Sets the email
     *
     * @param string $email
     * @return \App\Entity\OrderEntity
     */
    public function setEmail($email) {
        $this->_set('email', $email);
        return $this;
    }

    /**
     * Sets the payment status
     *
     * @param int $payment_status
     * @return \App\Entity\OrderEntity
     */
    public function setPaymentStatus($payment_status) {
        $this->_set('payment_status', $payment_status);
        return $this;
    }

    /**
     * Returns the order total
     *
     * @param boolean $includeExtras
     * @return float
     */
    public function getTotal($includeExtras = true) {

        //default to zero
        $total = 0;
        //get all the items
        $items = $this->getItems();
        //get the entity for accessing the session
        $menuEntity = new MenuEntity($this->request);
        //as long as we have items
        if (count($items) > 0) {
            foreach ($items as $orderItem) {
                $item = $menuEntity->getItem($orderItem->getItemId(), $orderItem->getVariationId());
                $total += $item->getPrice();
            }
        }

        //now add any extrad like delivery etc
        if ($includeExtras === true) {
            //if we are on delivery add the delivery cost
            if ($this->isDelivery()) {
                $total += $this->getAddress()->getDeliveryCost();
            }
        }

        //return the total
        return $total;
    }

    /**
     * Checks if the supplied total or session total meets the minimum amount
     *
     * @param float $subTotal
     * @return boolean
     */
    public function meetsMinimumOrderAmount($subTotal = null) {

        //default return value
        $return = false;

        //get the subtotal if one wasnt supplied
        if (is_null($subTotal)) {
            $subTotal = $this->getTotal(false);
        }

        //get the takeaway entity
        $takeawayEntity = new TakeawayEntity($this->request);

        //check against the delivery
        if ($this->isDelivery()) {
            if ($subTotal >= $takeawayEntity->getSettings()->getDeliveryMinOrder()) {
                $return = true;
            }
        } else {
            if ($subTotal >= $takeawayEntity->getSettings()->getCollectionMinOrder()) {
                $return = true;
            }
        }

        //return the result
        return $return;
    }

    /**
     * Returns the estimated delivery time, if format is false the date time
     * object is returned
     *
     * @param string|false $format
     * @return string|DateTime
     */
    public function getEstimatedTime($format = 'Y-m-d H:i:s') {

        //get the takeaway entity
        $takeawayEntity = new TakeawayEntity($this->request);

        //the time we want to add to the current time
        $delay = false;

        //check if we are on delivery
        if ($this->isDelivery()) {
            $delay = $takeawayEntity->getSettings()->getCurrentDeliveryTime();
        } else {
            $delay = $takeawayEntity->getSettings()->getCurrentCollectionTime();
        }

        //if we have a delay then make the date time object
        if ($delay !== false) {
            $delay = $delay * 60; //convert from minutes to seconds
            $dateTime = new \DateTime();
            $delay = $dateTime->setTimestamp(time() + (int)$delay);
        }

        return $format === false ? $delay : $delay->format($format);
    }

    /**
     * Returns the internal order ID of the latest item
     *
     * @return int
     */
    public function getLastOrderItemId() {
        //get all items
        $items = $this->getItems();

        //move the pointer to the end
        end($items);

        //return the key of the end item
        return key($items);
    }

    /**
     * Adds a condiment to the order
     *
     * @param int $$orderItemId The order item index
     * @param \App\Entity\Order\OrderItemCondimentEntity $condiment
     * @return \App\Entity\OrderEntity
     */
    public function addCondiment($orderItemId, OrderItemCondimentEntity $condiment) {
        //get the current condiments
        $condiments = $this->_get('condiments');

        //if null default to an array
        if (is_null($condiments)) {
            $condiments = [];
        }

        if (!array_key_exists($orderItemId, $condiments)) {
            $condiments[$orderItemId] = [];
        }

        $condiments[$orderItemId][] = $condiment->toArray();

        //set the items back to the entity
        $this->_set('condiments', $condiments);

        return $this;
    }

    /**
     * Checks if the item has condiments
     *
     * @param int $itemId
     * @return boolean
     */
    public function itemHasCondiments($itemId) {
        return count($this->getCondimentsForItemId($itemId)) > 0 ? true : false;
    }

    /**
     * Returns the contiments for a given item id
     *
     * @param int $itemId
     * @return array
     */
    public function getCondimentsForItemId($itemId) {
        //get the current condiments
        $condiments = $this->_get('condiments');

        //if null default to an array
        if (is_null($condiments)) {
            $condiments = [];
        }

        return array_key_exists($itemId, $condiments) ? $condiments[$itemId] : array();
    }

    /**
     * Returns the condiments for a given item id in the format expected for the API
     *
     * @param int $itemId
     * @return array
     */
    public function getOrderCondimentsForItemId($itemId) {
        $condiments = $this->getCondimentsForItemId($itemId);

        foreach ($condiments as $index => $condiment) {
            $condiments[$index] = [
                'Order_MenuItemID' => $condiment['item_id'],
                'CondimentID' => $condiment['id'],
                'CondimentTypeID' => $condiment['type_id']
            ];
        }

        return $condiments;
    }

    /**
     * Sets the delivery time
     *
     * @param int $delivery_time
     * @return \App\Entity\OrderEntity
     */
    public function setDeliveryTime($delivery_time) {
        $this->_set('delivery_time', $delivery_time);
        return $this;
    }

    /**
     * Sets the collection time
     *
     * @param int $collection_time
     * @return \App\Entity\OrderEntity
     */
    public function setCollectionTime($collection_time) {
        $this->_set('collection_time', $collection_time);
        return $this;
    }

    /**
     * Checks is an order can be processed
     *
     * this can be used to add a disabled class
     *
     * @return boolean
     */
    public function isValidOrder() {

        //default return
        $return = true;

        //get the takeaway entity as we need to access the settings
        $takeawayEntity = new TakeawayEntity($this->request);

        //get the sub total before delivery
        $total = $this->getTotal(false);

        //add any delivery specific checks
        if ($this->isType(TakeawayEntity::ORDER_TYPE_DELIVERY)) {

            //check we are accepting delivery orders
            if (!$takeawayEntity->getSettings()->getAcceptDeliveryOrders()) {
                $return = false;
            }

            //now lets check we meet the minimum order amount
            if ($total < $takeawayEntity->getSettings()->getDeliveryMinOrder()) {
                $return = false;
            }
        } else if ($this->isType(TakeawayEntity::ORDER_TYPE_COLLECTION)) {
            //add any collection specific checks
            //check we are accepting delivery orders
            if (!$takeawayEntity->getSettings()->getAcceptCollectionOrders()) {
                $return = false;
            }
            //now lets check we meet the minimum order amount
            if ($total < $takeawayEntity->getSettings()->getCollectionMinOrder()) {
                $return = false;
            }
        }

        //return our result
        return $return;
    }

    /**
     * Build the order as a JSON object so we can pass to the API
     *
     * @return string
     */
    public function buildOrderObject() {
        pr($_SESSION);
        //return the json encoded order
        return json_encode([
            'Order' => $this->_getOrderDetails(),
            'OrderItems' => $this->_getOrderItems()
        ]);
    }

    /**
     * Returns the order details from our session in a structure for the API
     *
     * @return array
     */
    private function _getOrderDetails() {

        //get the address object
        $address = $this->getAddress();

        //get the takeaway entity
        $takeawayEntity = new TakeawayEntity($this->request);

        return [
            //'OrderID' => '',
            'TakeawayID' => $takeawayEntity->getId(),
            'OrderTypeID' => $this->getOrderTypeForAPI(),
            'OrderStatusID' => '',
            'PaymentStatusID' => $this->getPaymentStatus(),
            'PaymentMethodID' => $this->getPaymentMethodForAPI(),
            'OrderTime' => date('Y-m-d H:i:s'),
            'EstimatedCompletionTime' => $this->getEstimatedTime(),
            'TotalOrder' => $this->getTotal(),
            'TotalDelivery' => $this->isDelivery() ? $this->getAddress()->getDeliveryCost() : null,
            //'TrackingID' => '',
            //'Archived' => '',
            //'Deleted' => '',
            'DeliveryName' => $this->getFirstName() . ' ' . $this->getSurname(),
            'DeliveryAddressLine1' => $address->getAddressLineOne(),
            'DeliveryAddressLine2' => $address->getAddressLineTwo(),
            'DeliveryTown' => $address->getAddressLineThree(),
            'DeliveryPostcode' => $address->getPostcode(),
            'DeliveryPhone' => $this->getTelephone(),
            'DeliveryEmail' => $this->getEmail(),
            'DeliveryLat' => $address->getLatitude(),
            'DeliveryLong' => $address->getLongitude(),
        ];
    }

    /**
     * Returns the order items in a structure ready for the API
     *
     * @return array
     */
    private function _getOrderItems() {

        $items = array();
//die(var_dump($this->getItems()));
        //get all items
        foreach ($this->getItems() as $item) {
            //  pr($item);
            //die(pr($item->toOrderArray($this->request)));
            //add this item (as an array) to the order array
            array_push($items, $item->toOrderArray($this->request));

            //get the key for this item
            end($items);
            $key = key($items);

            //get the condiments for this order item
            $condiments = $this->getOrderCondimentsForItemId($item->getItemId());

            //add the condiments to this order item in the order array
            $items[$key]['Condiments'] = $condiments;
        }

        return $items;
    }

    /**
     * Return the order type mapped to the appropriate API value
     *
     * @return int
     */
    public function getOrderTypeForAPI() {
        //return the mapped api value for the selected order type
        return $this->mapped_order_type[$this->getType()];
    }

    /**
     * Return the payment method mapped to the appropriate API value
     *
     * @return int
     */
    public function getPaymentMethodForAPI(){
        //return the mapped api value for the selected order type
        return $this->mapped_payment_methods[$this->getPaymentMethod()];
    }

}
