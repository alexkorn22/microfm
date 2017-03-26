<?php
/**
 * Created by PhpStorm.
 * User: korns
 * Date: 26.03.2017
 * Time: 21:46
 */

namespace app\controllers;
use vendor\core\base\Controller;

class Page extends Controller {

    public function indexAction() {
        echo 'Page::indexAction';
    }

    public function viewAction() {
        debug($this->route);
        echo 'Page::view';
    }

}