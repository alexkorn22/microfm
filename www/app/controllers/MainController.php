<?php

namespace app\controllers;

use app\models\Main;
use vendor\core\App;
use vendor\core\Registry;

class MainController extends AppController{

    public function indexAction() {
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

}