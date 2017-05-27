<?php

namespace app\controllers;

use app\models\UserModel;
use vendor\core\App;
use vendor\core\base\View;

class UserController extends MainController {

    public function loginAction() {
        View::setMeta('Авторизация', 'Авторизация пользователя');
        $data = [
            'login' => '',
            'password' => '',
            'remember' => '',
            'error' => '',
        ];
        if ($this->isPost()){
            $data = array_merge($data, $_POST);
            $data['error'] = '';
            if (empty($data['error'])){
                //App::$app->user->login = $data['login'];
                //App::$app->user->password = md5($data['password']);
                if (!App::$app->user->login()) {
                    $data['error'] = 'Не удалось найти пользователя';
                }
            }
        }
        if (App::$app->user->isAuth()) {
            header('Location: /');
        }
        $this->setVars(compact('data'));
    }

    public function regAction() {
        if (App::$app->user->isAuth()) {
            header('Location: /');
        }
        View::setMeta('Регистрация', 'Регистрация нового пользователя');
        $data = [
            'login' => '',
            'email' => '',
            'password' => '',
            'password_confirm' => ''
        ];
        $errors = [];
        if ($this->isPost() && isset($_POST['do_registration'])){
            $data = $_POST;
            $errors = App::$app->user->verificationReg($data);
            if (empty($errors)) {
                App::$app->user->save($data);
                if (App::$app->user->login($data['login'],$data['password'])) {
                    header('Location: /');
                }
            }
        }
        $this->setVars(compact('data','errors'));
    }

    public function logoutAction() {
        if (App::$app->user->isAuth()) {
            App::$app->user->logout();
            App::$app->user = new UserModel();
        }
        header('Location: /');
    }

}