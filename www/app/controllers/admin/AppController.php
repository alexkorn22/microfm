<?php

namespace app\controllers\admin;

use akfw\core\App;
use akfw\core\base\Controller;
use akfw\core\base\View;
use app\models\User;

class AppController extends Controller {
    public $layout = 'admin';

    public function __construct($route){
        parent::__construct($route);
        $this->validateUser();
        View::setMeta('Админка');
    }

    protected function validateUser() {
        $user = User::getCurrentUser();
        if (!$user) {
            $this->response->redirect('/user/login/');
        }
        if (!$user->isAdmin()) {
            $this->response->redirect('/');
        }
    }
}