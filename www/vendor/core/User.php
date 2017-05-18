<?php


namespace vendor\core;


class User{

    public $id;
    public $login;
    public $password;
    protected $data = [];

    public function save(){
        $rec = \R::dispense('users');
        $rec->login = $this->login;
        $rec->password = $this->password;
        foreach ($this->data as $key=>$value){
            $rec->$key = $value;
        }
        $this->id = \R::store($rec);
    }

    public function isAdmin() {
        return $this->admin == 1;
    }

    public function isAuth() {
        return !empty($this->id);
    }

    public static function login($login, $pass) {
        return new User();
    }

    public function __set($name, $value){
        $this->data[$name] = $value;
    }
    public function __get($name){
        return $this->data[$name];
    }

    public function checkAuth() {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $idUser = unserialize($_SESSION['user_id']);

        }
    }

}