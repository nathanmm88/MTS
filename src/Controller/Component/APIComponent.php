<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Network\Http\Client;

class APIComponent extends Component
{
    public function getToken()
    {
        
        $http = new Client();
$response = $http->post('http://webapi.mytakeawaysite.com/Token', 'grant_type=password&username=admin@mytakeawaysite.com&password=3ts,9#fY<5[Xi?`-><]qL',[
  //'title' => 'testing',
   // 'type' => 'application/x-www-form-urlencoded',
    'headers' => ['Content-Type' => 'application/x-www-form-urlencoded']
]);
pr($response);
        die('getToken function');
    }
}