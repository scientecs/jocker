<?php

namespace App\Helpers;

use App\Core\Session;
use App\Models\User as UserModel;

/**
 * Class of User
 */
class User {

    /**
     * Check if user logged
     */
    public static function isLogged() {
        return (new Session())->has('auth_id');
    }

    /**
     * Check if user admin
     */
    public static function hasUserRole($role = "admin") {
        $session = new Session();


        if ($session->has('auth_id')) {
            $id = $session->get('auth_id');

            $user = (new UserModel())->getById($id);

            if ($user && $user['role_alias'] === $role) {
                return true;
            }
        }

        return false;
    }

}
