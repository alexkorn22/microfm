<?php


namespace app\models;


use akfw\core\App;
use akfw\core\base\ModelRecord;

/**
 * Class User
 * @package app\models,
 * @property string login,
 * @property string email,
 * @property string password,
 * @property string role,
 */
class User extends ModelRecord {

    public static $tableName = 'users';
    /**
     * @var User
     */
    protected static $curUser;

    public $attributes = [
        'login' => '',
        'email' => '',
        'password' => '',
        'role' => 'user',
    ];
    public $rules = [
        'required' => [
            'login',
            'email',
            'password'
        ],
        'email' => ['email'],
        'lengthMin' => [
            ['password',6],
            ['login',3],
        ]
    ];
    public $labels = [
        'password' => 'Пароль',
        'login' => 'Логин',
        'email' => 'Почта',
    ];


    public function validate(){
        $result = parent::validate();
        if (!$result) {
            return false;
        }
        $find = self::getByLogin($this->login);
        if (!$find->isEmpty()) {
            $this->errors['login'][] = 'Логин уже существует';
            return false;
        }
        $find = self::getByEmail($this->email);
        if (!$find->isEmpty()) {
            $this->errors['email'][] = 'Email уже существует';
            return false;
        }
        return true;
    }

    public function doHashPassword(){
        $this->password = password_hash($this->password,PASSWORD_DEFAULT);
    }

    public static function getByLogin($login) {
        return self::findOne(['login' => $login]);
    }

    public static function getByEmail($email) {
        return self::findOne(['email' => $email]);
    }

    public static function getCurrentUser(){

        if (App::$app->session->get('userId')) {
            if (self::$curUser && self::$curUser->id == App::$app->session->get('userId')) {
                return self::$curUser;
            }
            $find = self::findOneById(App::$app->session->get('userId'));
            if ($find->isEmpty()) {
                self::unsetCurrentUser();
                return false;
            }
            self::$curUser = $find;
            return self::$curUser;

        }
        return false;
    }

    public function setCurrentUser(){
        if ($this->id) {
            self::$curUser = $this;
            App::$app->session->set('userId',$this->id);
        }
    }

    public function isAdmin() {
        return $this->role == 'admin';
    }

    public static function unsetCurrentUser(){
        self::$curUser = null;
        App::$app->session->delete('userId');
    }

    public function validateLogin() {
        $find = self::getByLogin($this->login);
        if (!$find->isEmpty()) {
            if (password_verify($this->password,$find->password)) {
                return $find;
            }
        }
        $find = self::getByEmail($this->login);
        if (!$find->isEmpty()) {
            if (password_verify($this->password,$find->password)) {
                return $find;
            }
        }
        $this->errors[][] = 'Неверные данные для входа';
        return false;
    }

}