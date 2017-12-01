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
        $response = new Response();
        if (User::getCurrentUser()) {
            $response->redirect('/');
        }
        $user = new User();
        $user->load(App::$app->session->get('signupDataUser'));
        $errors = App::$app->session->getFlash('errors');
        if ($this->request->isPost()) {
            $this->setSignupDataUser();
            $response = new Response();
            $user->load($this->request->getPost());
            $user->doHashPassword();
            if (!$user->validate()) {
                App::$app->session->setFlash('errors', $user->getErrors());
                $response->redirect('/user/signup');
            } else {
                $this->unsetSignupDataUser();
                if ($user->save()) {
                    $user->setCurrentUser();
                }
                $response->redirect('/');
                die();
            }
        }
        $this->setVars(compact('user','errors'));
    }

    protected function setSignupDataUser() {
        $post = $this->request->getPost();
        unset($post['password']);
        App::$app->session->set('signupDataUser',$post);
    }

    protected function unsetSignupDataUser() {
        App::$app->session->delete('signupDataUser');
    }

    public function loginAction() {

    }

    public function logoutAction() {
        User::unsetCurrentUser();
        $response = new Response();
        $response->redirect('/user/signup');
        die();
    }

}