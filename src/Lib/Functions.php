<?php

namespace App\Lib;

/**
 * Functions class to keep all re usable static functions
 *
 * @author nathan.morgan 
 */
class Functions {

    /**
     * Convert strings with underscores into CamelCase
     *
     * @param    string    $string    The string to convert
     * @param    bool    $first_char_caps    camelCase or CamelCase
     * @return    string    The converted string
     */
    public static function underscoreToCamelCase($string, $first_char_caps = false) {
        if ($first_char_caps == true) {
            $string[0] = strtoupper($string[0]);
        }
        $func = create_function('$c', 'return strtoupper($c[1]);');
        return preg_replace_callback('/_([a-z])/', $func, $string);
    }

    /**
     * Converts camel case to underscore
     *
     * @param string $input
     * @return string
     */
    public static function camelCaseToUnderscore($input) {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }

    /**
     * Rounds time to the nearest 15 minutes
     * 
     * @param int $timestamp
     * @param int $precision
     * @return \DateTime
     */
    public static function roundTime($timestamp, $precision = 15) {
        $precision = 60 * $precision;
        $time = (round($timestamp / $precision) * $precision);
        $return = new \DateTime(date('Y-m-d H:i:s', $time));
        return $return;
    }
    
    /**
     * Takes an array and converts all keys tc camel case
     * 
     * @param type $inputArray
     * @return type
     */
    public static function camelizeArrayKeys($inputArray){
        //loop through the array
        foreach ($inputArray as $key => $value) {           
            //covert the key to camel case
            $camelizedKey = Functions::underscoreToCamelCase($key);
            
            //unset the original key
            unset($inputArray[$key]);
            
            //set the new camelized key
            $inputArray[$camelizedKey] = $value;
            
            //if the element is an array recursively call this function
            if (is_array($value)){
                $inputArray[$camelizedKey] = Functions::camelizeArrayKeys($inputArray[$camelizedKey]);
            }
        }
   
        //return the input array which now contains camelized keys
        return $inputArray;
    }

}
