<?php

namespace app\controllers;

class MainController extends AppController{

    public function indexAction() {
        $model = new Main();
        $posts = $model->findAll();
        $this->setVars(compact('posts'));
    }

}