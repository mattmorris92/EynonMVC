<?php

namespace Helpers;

/**
 * Contains helper methods for easier access... :/
 *
 * @author Thomas Eynon
 */
class Security {
    
    /**
     * http://stackoverflow.com/questions/1846202/php-how-to-generate-a-random-unique-alphanumeric-string
     * 
     * @param type $min
     * @param type $max
     * @return type
     */
    private static function crypto_rand_secure($min, $max) {
        $range = $max - $min;
        if ($range < 1) return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(\openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
    }

    /**
     * http://stackoverflow.com/questions/1846202/php-how-to-generate-a-random-unique-alphanumeric-string
     * 
     * @param type $length
     * @return string
     */
    public static function getToken($length) {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet) - 1;
        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[self::crypto_rand_secure(0, $max)];
        }
        return $token;
    }
    
}
