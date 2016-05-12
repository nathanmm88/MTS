<?php

namespace App\Entity\Takeaway;

use App\Entity\AbstractEntity;

class SettingsEntity extends AbstractEntity
{
    /**
     * The prefix for the entity
     * 
     * Everything will be stored under takeaway => takeaway_address in the session
     * 
     * @var string
     */
    public $prefix = 'takeaway.settings';

}