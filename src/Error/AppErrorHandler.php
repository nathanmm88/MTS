<?php

namespace App\Error;

use App\Exception\SessionTimeoutException;
use Cake\Routing\Exception\MissingControllerException;
use Cake\Error\ErrorHandler;



class AppErrorHandler extends ErrorHandler
{
    
    public function _displayError($error, $debug)
    {
        return 'There has been an error!';
    }
    
    /**
     * When handling certain exceptions we may want to redirect to certain pages
     * 
     * @param mixed Exceptions
     */
    public function _displayException($exception)
    {
        //TODO:: add logging
        //die(var_dump($exception));   
        if ($exception instanceof SessionTimeoutException) {
            $this->_redirect('/error/sessionTimeout');
        } else { 
            $this->_redirect('/error/service');
        }
    }
    
    /**
     * Redirects to a URL
     * 
     * @param type $url
     */
    protected function _redirect($url){
        header("Location: " . $url);
        die();
    }
}