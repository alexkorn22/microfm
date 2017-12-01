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
        if (User::getCurrentUser()) {
            $this->response->redirect('/');
        }
        $user = new User();
        $user->load(App::$app->session->get('signupDataUser'));
        $errors = App::$app->session->getFlash('errors');
        if ($this->request->isPost()) {
            $this->setSignupDataUser();
            $user->load($this->request->getPost());
            $user->doHashPassword();
            if (!$user->validate()) {
                App::$app->session->setFlash('errors', $user->getErrors());
                $this->response->redirect('/user/signup');
            } else {
                $this->unsetSignupDataUser();
                if ($user->save()) {
                    $user->setCurrentUser();
                }
                $this->response->redirect('/');
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
        if (User::getCurrentUser()) {
            $this->response->redirect('/');
        }
        $errors = App::$app->session->getFlash('errors');
        $login = App::$app->session->getFlash('login');
        if ($this->request->isPost()) {
            $login = $this->request->post('login');
            $user = new User();
            $user->load($this->request->getPost());
            $user = $user->validateLogin();
            if ($user) {
                $user->setCurrentUser();
                $this->response->redirect('/');
            }
            $errors = $user->getErrors();
            App::$app->session->setFlash('login',$login);
            App::$app->session->setFlash('errors',$errors);
            $this->response->redirect('/user/login');
        }
        $this->setVars(compact('login','errors'));
    }

    public function logoutAction() {
        User::unsetCurrentUser();
        $this->response->redirect('/user/signup');
    }

}