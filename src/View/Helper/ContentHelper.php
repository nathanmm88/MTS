<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Core\Configure;

class ContentHelper extends Helper {
    /**
     * Returns text based on the supplied string
     * 
     * @param type $textString
     */
    public function get($textString, $values = array(), $helpText = null, $helpTextAfter = null) {
        $return = Configure::read('text.' . $textString);
        //we have to parse values from the session
      //  $return = $this->addSessionVals($return);
      //  $return = $this->addConfigVals($return);

       // if (count($values) > 0) {
     //       foreach ($values as $key => $value) {
     //           $return = str_replace($key, $value, $return);
      //      }
      //  }
            
        return ($return == false) ? $textString : $return;
    }  
   
}
    