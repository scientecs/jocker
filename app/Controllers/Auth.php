<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Url;
use App\Models\User;
use App\Core\Session;
use App\Core\Password;
use App\Core\Validator;

/**
 * Class of Auth
 */
class Auth extends Controller {

    public $user = null;

    public function __construct() {
        parent::__construct();

        $this->user = new User();
    }

    /**
     * Register handler
     */
    public function register() {
        if ($this->request->isMethod('post')) {
            $data = $this->request->all();

            (new Validator())->validate($data, [
                'name' => 'required',
                'email' => 'required,email',
                'password' => 'required',
                'repassword' => 'required,equal:password',
                'userEntity' => 'not_exists'
            ]);

            unset($data['repassword']);

            $data['password'] = Password::make($data['password']);

            $this->user->insert($data);

            $this->request->redirect(Url::makeUrl('auth', 'login'));
        } else {
            $errors = [];
            $inputs = [];

            $session = new Session();

            if ($session->has('errors')) {
                $errors = $session->get('errors');
                $session->remove('errors');

                $inputs = $session->get('input');
                $session->remove('input');
            }

            $this->view->render('template/register', [
                'errors' => $errors,
                'inputs' => $inputs
            ]);
        }
    }

    /**
     * Login handler
     */
    public function login() {
        if ($this->request->isMethod('post')) {
            $data = $this->request->all('post');

            (new Validator())->validate($data, [
                'email' => 'required,email',
                'password' => 'required',
                'userEntity' => 'exists,moderation,password'
            ]);

            $user = $this->user->getByEmail($data['email']);

            if ($user) {
                $session = new Session();
                $session->set('auth_id', $user['id']);
                $this->request->redirect();
            }

            $this->request->redirect('back');
        } else {
            $errors = [];
            $inputs = [];

            $session = new Session();

            if ($session->has('errors')) {
                $errors = $session->get('errors');
                $session->remove('errors');

                $inputs = $session->get('input');
                $session->remove('input');
            }

            $this->view->render('template/login', [
                'errors' => $errors,
                'inputs' => $inputs
            ]);
        }
    }

    /**
     * Logout user
     */
    public function logout() {
        $session = new Session();
        $session->remove('auth_id');
        $this->request->redirect();
    }

}
