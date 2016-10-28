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
    
    /**
     * Merges the 2 arrays, the second array values will be coppied to the first array
     * 
     * @param array $array1
     * @param array $array2
     * @return array
     */
    public static function overwriteArray($array1 = array(), $array2 = array()) {

        //foreach item in the second array
        foreach ($array2 as $key => $value) {
            // if the item in array 1 is an array and the item in array 2 is then 
            // call this function passing the two arrays
            if (array_key_exists($key, $array1) && is_array($array1[$key]) && is_array($value)) {
                $array1[$key] = self::overwriteArray($array1[$key], $value);
            } else {
                //write the value to the key
                $array1[$key] = $value;
            }
        }

        //return the array
        return $array1;
    }

}
