<?php

namespace App\Helpers;

use App\Core\Session as CoreSession;

/**
 * Class of Session
 */
class Session {

    /**
     * Get variable from session
     *
     * @param string $key
     *
     * @return mixed
     */
    public static function get($key, $remove = false) {
        $value = false;

        $session = new CoreSession();

        if ($session->has($key)) {
            $value = $session->get($key);
        }

        if ($remove) {
            $session->remove($key);
        }

        return $value;
    }

    /**
     * Check if variable exists
     */
    public static function has($key) {
        $session = new CoreSession();
        return $session->has($key) ? true : false;
    }

}
