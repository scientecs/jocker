<?php

namespace App\Core;

/**
 * Class of Request
 */
class Request {

    public $stripHtml = true;
    public $htmlEntity = true;
    public $trim = true;

    /**
     * Check is method post or get or another
     * 
     * @param string $method
     *
     * @return bool
     */
    public function isMethod($method) {
        return strtolower($_SERVER['REQUEST_METHOD']) == strtolower($method);
    }

    /**
     * Get request method
     *
     * @return string
     */
    public function getMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Redirect to antoher page
     * 
     * @param string $url
     * @param integer $code
     */
    public function redirect($url = "/", $code = 301) {
        if ($url === "back") {
            $url = $_SERVER['HTTP_REFERER'];
        }

        header('Location:' . $url, true, $code);
        exit();
    }

    /**
     * Get all variable from global array
     * 
     * @param array $method
     */
    public function all($method = "post", $filter = true) {
        $data = [];

        if ($method === "post") {
            $data = $_POST;
        } elseif ($method === "get") {
            $data = $_GET;
        }

        if ($filter) {
            $data = $this->filter($data);
        }


        return $data;
    }

    /**
     * Get variable from GET array
     *
     * @return mixed
     */
    public function get($name, $type = null, $filter = true) {
        $val = null;
        if (isset($_GET[$name])) {
            $val = $_GET[$name];
        }

        if ($type == 'string') {
            return strval($val);
        }

        if ($type == 'integer') {
            return intval($val);
        }

        if ($type == 'boolean') {
            return boolval($val);
        }

        return $val;
    }

    /**
     * Get post variable
     *
     * @return mixed
     */
    public function post($name = null, $type = null, $filter = true) {
        $val = null;

        if (isset($_POST[$name])) {
            $val = $_POST[$name];
        }

        if ($val && $filter) {
            $val = $this->filter($val);
        }

        if ($type == 'string') {
            return strval($val);
        }

        if ($type == 'integer') {
            return intval($val);
        }

        if ($type == 'boolean') {
            return boolval($val);
        }

        return $val;
    }

    /**
     * Filter request data
     * 
     * @param mixed $value
     * @param bool $stripHtml
     * @param bool $htmlEntity
     * @param bool $trim
     *
     * @return mixed
     */
    public function filter(&$value) {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $value[$this->filter($k)] = $this->filter($v);
            }
        } else {
            if ($this->stripHtml) {
                $value = strip_tags($value);
            }
            if ($this->htmlEntity) {
                $value = htmlentities($value);
            }

            if ($this->trim) {
                $value = trim($value);
            }

            if (get_magic_quotes_gpc()) {
                $value = stripslashes($value);
            }

            mysqli_real_escape_string($value);
        }


        return $value;
    }

}
