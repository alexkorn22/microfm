<?php

namespace app\controllers;

use akfw\core\App;
use akfw\core\base\View;
use akfw\core\Registry;

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

}