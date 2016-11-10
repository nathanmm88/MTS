<?php

namespace App\Error;

use App\Exception\SessionTimeoutException;
use Cake\Routing\Exception\MissingControllerException;
use Cake\Error\ErrorHandler;
use Cake\Log\Log;

class AppErrorHandler extends ErrorHandler {

    public function _displayError($error, $debug) {
        return 'There has been an error!';
    }

    /**
     * When handling certain exceptions we may want to redirect to certain pages
     * 
     * @param mixed Exceptions
     */
    public function _displayException($exception) {
        //log the exception message
        Log::write('error', $exception->getMessage());
        //if the session has timed out
        if ($exception instanceof SessionTimeoutException) {
            $this->_redirect('/error/sessionTimeout');
        //else if there was a 404 we don't want to manually redirect (302) - we want to maintain the 404
        } else if ($exception instanceof MissingControllerException) {
            parent::_displayException($exception); //this loads /src/Template/Error/error500.ctp
        } else {
            die(var_dump($exception->getMessage()));
            //else reidrect to the standard error page
            $this->_redirect('/error/service');
        }
    }

    /**
     * Redirects to a URL
     * 
     * @param type $url
     */
    protected function _redirect($url) {
        header("Location: " . $url);
        die();
    }

}
