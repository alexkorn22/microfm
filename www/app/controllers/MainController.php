<?php

namespace app\controllers;

use app\models\Main;
use vendor\core\App;
use vendor\core\base\View;
use vendor\core\Registry;
use vendor\core\User;

class MainController extends AppController{

    public function indexAction() {
        View::setMeta('Главная', 'Описание');
        $posts = App::$app->cache->get('posts');
        if (false === $posts) {
            $posts = \R::findAll('posts');
            App::$app->cache->set('posts', $posts);
        }
        $this->setVars(compact('posts'));
    }

    public function testAjaxAction() {
        if ($this->isAjax()) {
            $post = \R::findOne('posts',"id = {$_POST['id']}");
            $this->loadView('testAjax', compact('post'));
            die();
        }
    }

    public function testAction() {

    }

    public function loginAction() {
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

            }
        }
        $this->setVars(compact('data'));
    }

}