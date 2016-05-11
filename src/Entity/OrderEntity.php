<?php

namespace App\Entity;

use App\Entity\AbstractSession;

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
}