<?php

namespace app\controllers;

use app\models\Main;

class MainController extends AppController{

    public function indexAction() {
        $posts = \R::findAll('posts');
        $this->setVars(compact('posts'));
    }
}