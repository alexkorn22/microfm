<?php


namespace vendor\core;


class User{

    public $id = 0;
    public $login;
    public $password;
    protected $admin = 0;

    public function save(){
        $rec = \R::dispense('users');
        $rec->login = $this->login;
        $rec->password = $this->password;
        $rec->admin = $this->admin;
        $this->id = \R::store($rec);
        return true;
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

    public function login() {
        $rec = \R::findOne('users','login = :login AND password = :password'
            ,[
              ':login' => $this->login,
              ':password' => $this->password,
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
        session_start();
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

}