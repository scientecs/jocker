<?php

namespace App\Core;

use App\Core\View;
use App\Core\Request;
use App\Models\User;

/**
 * Class of Controller
 */
class Controller {

    /**
     * Instance of View
     *
     * @var type 
     */
    public $view = null;

    /**
     * Instance of Request
     *
     * @var type 
     */
    public $request = null;

    public function __construct() {
        $this->view = new View();
        $this->request = new Request();
    }

    /**
     * Check permission for action
     * 
     * @param $role
     */
    public function checkPermission($role = 'admin') {
        if (!$this->isLogged()) {
            return false;
        }

        $session = new Session();
        $id = $session->get('auth_id');
        

        $userModel = new User();
        $identity = $userModel->getById($id);

        if ($identity && $identity['role_alias'] === $role) {
            return true;
        }

        return false;
    }

    /**
     * Check if user is logged
     *
     * @return bool
     */
    public function isLogged() {
        $session = new Session();
        return $session->has('auth_id');
    }

}
