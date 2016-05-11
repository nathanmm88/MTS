<?php

namespace App\Network;

use Cake\Network\Request;
use App\Network\TakeawaySession;
use Cake\Core\Configure;

class TakeawayRequest extends Request
{
    public static function createFromGlobals() {
        
        list($base, $webroot) = static::_base();
        $sessionConfig = (array)Configure::read('Session') + [
            'defaults' => 'php',
            'cookiePath' => $webroot
        ];

        $config = [
            'query' => $_GET,
            'post' => $_POST,
            'files' => $_FILES,
            'cookies' => $_COOKIE,
            'environment' => $_SERVER + $_ENV,
            'base' => $base,
            'webroot' => $webroot,
            'session' => TakeawaySession::create($sessionConfig)
        ];
        $config['url'] = static::_url($config);
        return new static($config);
    }
}

