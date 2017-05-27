<?php


namespace app\models;


class User{

    protected $id = 0;
    protected $login;
    protected $password;
    protected $admin = 0;

    public function save($data){
        $rec = \R::dispense('users');
        $rec->login = $data['login'];
        $rec->password = $data['password'];
        $rec->admin = $this->admin;
        $this->id = \R::store($rec);
    }

    public function isAdmin() {
        if (1 == $this->admin) {
            return true;
        } else {
            return false;
        }
    }

    public function isAuth() {
        return !empty($this->id);
    }

    public function login($login, $password) {
        $rec = \R::findOne('users','login = :login AND password = :password'
            ,[
              ':login' => $login,
              ':password' => $password,
            ]);
        if ($rec->isEmpty()){
            return false;
        }
        $this->fillFromRecord($rec);
        $_SESSION['user_id'] = serialize($this->id);
        return true;
    }

    public function fillFromRecord($rec){
        $this->id = $rec->id;
        $this->login = $rec->login;
        $this->admin = $rec->admin;
    }

    public function checkAuth() {
        if (isset($_SESSION['user_id'])) {
            $idUser = unserialize($_SESSION['user_id']);
            $rec = \R::findOne('users','id = :id '
                ,[
                    ':id' => $idUser
                ]);
            if ($rec->isEmpty()){
                return false;
            }
            $this->fillFromRecord($rec);
            return true;
        }
    }

    public function getPerformance() {
        return $this->login;
    }

    public function verificationReg($data){
        $errors = [];
        if (trim($data['login']) == ''){
            $errors[] = 'Не заполнен логин';
        }
        if (trim($data['email']) == ''){
            $errors[] = 'Не заполнен email';
        }
        if ($data['password'] == ''){
            $errors[] = 'Не заполнен пароль';
        } else {
            if ($data['password'] != $data['password_confirm']){
                $errors[] = 'Подтверждение пароля не сопадает';
            }
        }
        return $errors;
    }

}