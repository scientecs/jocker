<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User as UserModel;
use App\Core\Session;
use App\Core\Validator;
use App\Core\Password;
use App\Core\Mailer;
use App\Helpers\Url;
use App\Models\Role;

/**
 * Class of User
 */
class User extends Controller {

    public $user = null;

    public function __construct() {
        parent::__construct();

        if (!$this->checkPermission('admin')) {
            $this->request->redirect();
        }

        $this->user = new UserModel();
    }

    /**
     * Get list of users
     *
     * @return type
     */
    public function index() {
        $users = $this->user->getUsersWithRole();

        return $this->view->render('admin/users/index', [
                    'users' => $users
        ]);
    }

    /**
     * Edit user
     */
    public function edit($id) {
        $id = (int) $id;

        if ($this->request->isMethod('post')) {
            $data = $this->request->all();

            (new Validator())->validate($data, [
                'name' => 'required',
                'email' => 'required,email',
            ]);

            if ($data['password']) {
                $data['password'] = Password::make($data['password']);
            }

            $this->user->update($id, $data);

            $this->request->redirect(Url::makeUrl('user', 'index'));
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

            $user = $this->user->getById($id);

            $this->view->render('admin/users/edit', [
                'errors' => $errors,
                'inputs' => $inputs,
                'user' => $user
            ]);
        }
    }

    /**
     * Register handler
     */
    public function create() {
        if ($this->request->isMethod('post')) {
            $data = $this->request->all();

            (new Validator())->validate($data, [
                'name' => 'required',
                'email' => 'required,email',
                'password' => 'required',
                'repassword' => 'required,equal:password'
            ]);

            unset($data['repassword']);

            $data['password'] = Password::make($data['password']);
            $this->user->insert($data);

            $this->request->redirect(Url::makeUrl('user', 'index'));
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

            $this->view->render('admin/users/create', [
                'errors' => $errors,
                'inputs' => $inputs
            ]);
        }
    }

    /**
     * Delete user
     *
     * @param integer $id
     */
    public function remove($id) {
        $user = $this->user->getById($id);

        if ($user['role_alias'] === "admin") {
            $this->request->redirect('back');
        }

        $this->user->delete($id);
        $this->request->redirect('back');
    }

    /**
     * Action send message
     */
    public function send() {
        if ($this->request->isMethod('post')) {
            $data = $this->request->all();

            (new Validator())->validate($data, [
                'subject' => 'required',
                'message' => 'required',
                'users' => 'required',
            ]);

            $userIds = [];
            foreach ($data['users'] as $id => $user) {
                if ($user) {
                    $userIds[] = $id;
                }
            }

            $users = $this->user->getByIds($userIds);

            $emails = [];
            foreach ($users as $user) {
                $emails[] = $user['email'];
            }

            $session = new Session();
            $adminId = $session->get('auth_id');

            $admin = $this->user->getById($adminId);

            $mailer = new Mailer();
            $mailer->send($emails, $admin['email'], $data['subject'], $data['message']);

            $session->set('success_message', 'Сообщение успешно отправлено.');
        }

        return $this->request->redirect();
    }

}
