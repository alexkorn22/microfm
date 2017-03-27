<?php
/**
 * Created by PhpStorm.
 * User: korns
 * Date: 26.03.2017
 * Time: 21:46
 */

namespace app\controllers;

class PageController extends AppController {

    public function indexAction() {
        echo 'Page::indexAction';
    }

    public function viewAction() {
        echo 'Page::view';
    }

}