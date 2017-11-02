<?php

namespace app\controllers\admin;

use vendor\core\base\Controller;
use vendor\core\base\View;

class AppController extends Controller {
    public $layout = 'admin';

    public function __construct($route){
        parent::__construct($route);
        View::setMeta('Админка');
    }
}