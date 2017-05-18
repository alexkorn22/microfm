<?php
/**
 * Created by PhpStorm.
 * User: korns
 * Date: 18.05.2017
 * Time: 20:31
 */

namespace vendor\core;


class User{

    public $id;
    public $login;

    public function isAuth() {

    }

    public function save(){}

    public static function login($login, $pass) {
        return new User();
    }




}