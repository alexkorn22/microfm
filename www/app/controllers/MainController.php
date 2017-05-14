<?php

namespace app\controllers;

use app\models\Main;
use vendor\core\Registry;

class MainController extends AppController{

    public function indexAction() {
        $posts = \R::findAll('posts');
        $this->setVars(compact('posts'));
    }
}