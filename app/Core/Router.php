<?php

namespace App\Core;

/**
 * Clas of Router
 */
class Router {

    /**
     * Call controller action
     */
    public function callAction() {
        $this->getController($controller, $action, $args);
        $class = 'App\Controllers\\' . $controller;

        $controller = new $class();

        if (is_callable(array($controller, $action)) == false) {
            die('404 Not Found');
        }

        call_user_func_array(array($controller, $action), $args);
    }

    /**
     * Method for get Controller
     *
     * @param string $file
     * @param string $controller
     * @param string $action
     * @param array $args
     */
    private function getController(&$controller, &$action, &$args) {
        $controller = $_GET['cntr'] ?? $_GET['cntr'];

        if (!$controller) {
            $controller = 'Index';
        } else {
            unset($_GET['cntr']);
        }

        $controller = ucfirst($controller);

        $action = $_GET['act'] ?? $_GET['act'];

        if (!$action) {
            $action = "index";
        } else {
            unset($_GET['act']);
        }

        $args = $_GET;

        if (!$args) {
            $args = [];
        }

        return $args;
    }

}
