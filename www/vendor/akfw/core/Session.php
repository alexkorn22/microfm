<?php


namespace akfw\core;


class Session {


    protected static $instance;

    public $session_start = FALSE;
    private function __construct(){
        $this->start();
    }

    public static function getInstance(){
        return (null !== self::$instance) ? self::$instance : (self::$instance = new Session());
    }

    public function start(){
        if($this->session_start){
            return true;
        }
        if(!session_start()){
            throw new \Exception('Error session start');
        }
        $this->session_start = true;
        return true;
    }

    public function get($key){
        $this->start();
        return (!empty($_SESSION[$key])) ? $_SESSION[$key] : false;
    }

    public function set($key, $value){
        $this->start();
        $_SESSION[$key] = $value;
    }

    public function has($key){
        $this->start();
        return isset($_SESSION[$key]);
    }

    public function delete($key){
        $this->start();
        unset($_SESSION[$key]);
    }

    public function setFlash($key, $value) {
        $this->set($key, $value);
    }

    public function getFlash($key) {
        $result = $this->get($key);
        if ($this->has($key)) {
            $this->delete($key);
        }
        return $result;
    }

}