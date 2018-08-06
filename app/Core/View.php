<?php

namespace App\Core;

/**
 * Class of View
 */
class View {

    private $pathToView = "";

    public function __construct() {
        $this->pathToView = $_SERVER['DOCUMENT_ROOT'] . '/views/';
    }

    /**
     * Render view
     * 
     * @param type $template
     * @param type $data
     */
    public function render($template, $data = array()) {
        extract($data);
        require $this->pathToView . $template . '.php';
    }

    /**
     * Include header to view
     *
     * @param string $view
     */
    public function includeHeader($view = 'template') {
        require_once $this->pathToView . "/$view/" . 'header.php';
    }

    /**
     * Include header to view
     *
     * @param string $view
     */
    public function includeFooter($view = 'template') {
        require_once $this->pathToView . "/$view/" . 'footer.php';
    }

}
