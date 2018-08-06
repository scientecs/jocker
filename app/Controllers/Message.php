<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Message as ModelMessage;

/**
 * Class of Message
 */
class Message extends Controller {

    public $user = null;

    public function __construct() {
        parent::__construct();

        if (!$this->checkPermission('admin')) {
            $this->request->redirect();
        }

        $this->message = new ModelMessage();
    }

    /**
     * Get list of users
     *
     * @return type
     */
    public function index() {
        $messages = $this->message->getAll(true);

        $this->message->setMessagesAsOld();

        return $this->view->render('admin/messages/index', [
                    'messages' => $messages
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

            $this->request->redirect(Url::makeUrl('back'));
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
        $this->user->delete($id);
        $this->request->redirect('back');
    }

}
