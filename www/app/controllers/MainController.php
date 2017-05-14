<?php

namespace app\controllers;

use app\models\Main;

class MainController extends AppController{

    public function indexAction() {
        $model = new Main();
        $posts = \R::findAll('posts');
        $this->setVars(compact('posts'));
    }
}