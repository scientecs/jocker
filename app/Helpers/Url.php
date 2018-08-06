<?php

namespace App\Helpers;

/**
 * Class of Url
 */
class Url {

    /**
     * Make url
     * 
     * @param string $controller
     * @param string $action
     * @param array $args
     *
     * @return string
     */
    public static function makeUrl($controller = "index", $action = "index", $args = []) {
        $url = "/";

        if ($controller === "index" && $action === "index" && !count($args)) {
            return $url;
        }

        $url .= "?cntr=" . $controller . "&act=" . $action;


        if (count($args)) {
            $url .= "&" . http_build_query($args);
        }


        return $url;
    }

}
