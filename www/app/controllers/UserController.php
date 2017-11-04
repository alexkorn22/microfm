<?php
/**
 * Created by PhpStorm.
 * User: korns
 * Date: 04.11.2017
 * Time: 13:44
 */

namespace app\controllers;


use akfw\core\App;
use akfw\core\base\View;
use app\models\User;

class UserController extends AppController {

    public function __construct($route){
        parent::__construct($route);
        View::setMeta('Пользователь');
    }

    public function signupAction(){
        if (!empty($_POST)) {
            $user = new User();
            $user->load($_POST);
            $user->validate();
            debug($user->errors);
        }

    }

    public function loginAction() {

    }

    public function logoutAction() {

    }

}