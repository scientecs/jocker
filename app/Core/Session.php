<?php

namespace App\Core;

/**
 * Class of Session
 */
class Session {

    private $data = null;

    public function __construct() {
        $this->data =& $_SESSION;
    }

    /**
     * Get variable from session
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key) {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }

        return false;
    }

    /**
     * Set variable to session
     */
    public function set($key, $value) {
        $this->data[$key] = $value;
    }

    /**
     * Check if variable exists
     */
    public function has($key) {
        return isset($this->data[$key]) ? true : false;
    }

    /**
     * Remove data from session
     *
     * @param mixed $key
     *
     * @return void
     */
    public function remove($key) {
        if ($this->data[$key]) {
            unset($this->data[$key]);
        }
    }

}
