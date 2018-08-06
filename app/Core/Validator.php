<?php

namespace App\Core;

use App\Core\Request;
use App\Models\User;
use App\Core\Password;

/**
 * Class of Validator
 */
class Validator {

    /**
     * Do immediate redirect if validate failed
     *
     * @var bool
     */
    public $immediatelyRedirect = true;

    /**
     * Array of errors
     *
     * @var array
     */
    public $errors = [];

    /**
     * Array of success validate fields
     *
     * @var array
     */
    public $success = [];

    /**
     * Method for validate user entity
     * 
     * @param array $rules
     * @param string $email
     * @param string $password
     */
    public function validateUser($rules, $email, $password = null) {
        $user = (new User())->getByEmail($email);

        if (in_array('not_exists', $rules) && $user) {
            $this->errors['exists'] = 'Пользователь с таким email уже существует!';
            return;
        }

        if (in_array('exists', $rules) && !$user) {
            $this->errors['exists'] = 'Такого пользователя не существует!';
            return;
        }

        if (in_array('moderation', $rules) && !$user['moderation']) {
            $this->errors['user_on_moderation'] = 'Пользователь находится на модерации!';
            return;
        }

        if (in_array('password', $rules) && !Password::check($password, $user['password'])) {
            $this->errors['not_correct_password'] = 'Не верный пароль';
            return;
        }
    }

    /**
     * Validate data with special rules
     *
     * @param type $data
     * @param type $rules
     *
     * return mixed
     */
    public function validate($data, $rules = []) {
        foreach ($rules as $name => $value) {
            $tmpRules = explode(',', $value);

            if ($name === "userEntity" && !isset($this->errors['email'])) {
                $password = isset($rules['password']) ? $data['password'] : null;
                $this->validateUser($tmpRules, $data['email'], $password);
                continue;
            }

            foreach ($tmpRules as $rule) {
                $params = [];

                if (preg_match('/\:/i', $rule)) {
                    $tmpRule = explode(':', $rule);
                    $rule = array_shift($tmpRule);
                    $params = $tmpRule;
                }

                switch ($rule) {
                    case 'required' :
                        if (empty($data[$name])) {
                            $this->errors[$name] = 'Заполните поле ' . $name;
                        } else {
                            $this->success[$name] = $data[$name];
                        }

                        break;
                    case 'email' :
                        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                            $this->errors[$name] = 'Введите валидный ' . $name;
                        } else {
                            $this->success[$name] = $data[$name];
                        }

                        break;
                    case 'equal' :
                        $to = $params[0];

                        if ($data[$name] !== $data[$to]) {
                            $this->errors[$name] = 'Поля ' . $name . ' и ' . $to . ' должны совпадать.';
                        } else {
                            $this->success[$name] = $data[$name];
                        }

                        break;
                    case 'auth' :
                        $session = new Session();

                        if (!$session->has('auth_id')) {
                            $this->errors[$name] = 'Только авторизованные пользователи могут отправлять.';
                        } else {
                            $this->success[$name] = $data[$name];
                        }
                        break;
                }
            }
        }

        if ($this->immediatelyRedirect && count($this->errors) > 0) {
            $session = new Session();

            $this->replaceLabels();

            $session->set('errors', $this->errors);
            $session->set('input', $this->success);

            (new Request())->redirect('back');
        }
    }

    /**
     * Replace fields keys to labels for readable
     */
    public function replaceLabels() {
        $keys = array_keys($this->labels());
        $values = array_values($this->labels());

        foreach ($this->errors as $k => $error) {
            $this->errors[$k] = str_ireplace($keys, $values, $error);
        }
    }

    /**
     * Labels of field input
     */
    public function labels() {
        return [
            'name' => 'Имя',
            'email' => 'E-mail',
            'repassword' => 'Повторите пароль',
            'password' => 'Пароль',
            'subject' => 'Тема',
            'message' => 'Сообщение',
        ];
    }

}
