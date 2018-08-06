<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Validator;
use App\Models\Message;
use App\Core\Session;
use App\Helpers\User;

/**
 * Class of Index
 */
class Index extends Controller {

    /**
     * Index action
     */
    public function index() {
        if (User::hasUserRole('admin')) {
            $this->request->redirect(\App\Helpers\Url::makeUrl('user', 'index'));
        }

        $errors = [];
        $inputs = [];

        $session = new Session();

        if ($session->has('errors')) {
            $errors = $session->get('errors');
            $session->remove('errors');

            $inputs = $session->get('input');
            $session->remove('input');
        }

        $this->view->render('template/index', [
            'errors' => $errors,
            'inputs' => $inputs,
        ]);
    }

    /**
     * Action send message
     */
    public function send() {
        if ($this->request->isMethod('post')) {
            $data = $this->request->all();

            (new Validator())->validate($data, [
                'auth' => 'auth',
                'subject' => 'required',
                'message' => 'required',
            ]);

            $session = new Session();

            $data['user_id'] = $session->get('auth_id');

            $message = new Message();
            $message->insert($data);

            $session->set('success_message', 'Сообщение успешно отправлено.');
        }

        return $this->request->redirect();
    }

}
