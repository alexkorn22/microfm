<?php
/**
 * Created by PhpStorm.
 * User: korns
 * Date: 25.05.2017
 * Time: 8:00
 */

namespace app\controllers;


use vendor\core\App;

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
            if (empty($data['login']) || strlen($data['login']) < 3) {
                $data['error'] .= 'Минимальная длина логина 3 символа';
            }
            if (empty($data['password']) || strlen($data['password']) < 6){
                $data['error'] .= '<br>Минимальная длина пароля 6 символа';
            }
            if (empty($data['error'])){
                App::$app->user->login = $data['login'];
                App::$app->user->password = md5($data['password']);
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
        $data = [
            'login' => '',
            'password' => '',
            'remember' => '',
            'error' => '',
        ];
        if ($this->isPost()){

            $data = array_merge($data, $_POST);
            $data['error'] = '';
            if (empty($data['login']) || strlen($data['login']) < 3) {
                $data['error'] .= 'Минимальная длина логина 3 символа';
            }
            if (empty($data['password']) || strlen($data['password']) < 6){
                $data['error'] .= '<br>Минимальная длина пароля 6 символа';
            }
            if (empty($data['error'])){
                App::$app->user->login = $data['login'];
                App::$app->user->password = md5($data['password']);
                if (!App::$app->user->save()) {
                    $data['error'] = 'Не удалось создать пользователя';
                }
            }
        }
        if (App::$app->user->isAuth()) {
            header('Location: /');
        }
        $this->setVars(compact('data'));
    }

}