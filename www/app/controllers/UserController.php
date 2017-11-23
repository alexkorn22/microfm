<?php
/**
 * Created by PhpStorm.
 * User: korns
 * Date: 04.11.2017
 * Time: 13:44
 */

namespace app\controllers;


use akfw\core\App;
use akfw\core\base\View;
use akfw\core\Response;
use app\models\User;

class UserController extends AppController {

    public function __construct($route){
        parent::__construct($route);
        View::setMeta('Пользователь');
    }

    public function signupAction(){
        $user = new User();
        $user->load(App::$app->session->get('signupDataUser'));
        $errors = App::$app->session->getFlash('errors');
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            unset($post['password']);
            App::$app->session->set('signupDataUser',$this->request->getPost());
            $response = new Response();
            $user->load($this->request->getPost());
            if (!$user->validate()) {
                App::$app->session->setFlash('errors', $user->getErrors());
                $response->redirect('/user/signup');
            } else {
                App::$app->session->delete('signupDataUser');
                App::$app->session->set('curUserId',$user->id);
                $response->redirect('/');
                die();
            }
        }
        $this->setVars(compact('user','errors'));
    }

    public function loginAction() {

    }

    public function logoutAction() {

    }

}