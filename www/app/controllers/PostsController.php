<?php

namespace app\controllers;


class PostsController extends AppController {

    public function indexAction() {

    }

    public function testAction() {

        $name = 'Name value';
        $this->setVars(compact('name'));

    }

}