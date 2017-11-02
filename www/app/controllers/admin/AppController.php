<?php

namespace app\controllers\admin;

use akfw\core\base\Controller;
use akfw\core\base\View;

class AppController extends Controller {
    public $layout = 'admin';

    public function __construct($route){
        parent::__construct($route);
        View::setMeta('Админка');
    }
}