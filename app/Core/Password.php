<?php

namespace App\Core;

/**
 * Class of Password
 */
class Password {

    private static $salt = "Tzaqxbvvw";

    /**
     * Make hash from passwщrd
     * 
     * @param string $password
     *
     * @return string
     */
    public static function make($password) {
        return hash('sha512', self::$salt . $password);
    }

    /**
     * Check if password equal hash
     * 
     * @param string $password
     *
     * @return bool
     */
    public static function check($password, $hash) {
        return ($hash == self::make($password));
    }

}
