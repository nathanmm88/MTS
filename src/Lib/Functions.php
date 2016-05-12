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
    
}