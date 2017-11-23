<?php
/**
 * Created by PhpStorm.
 * User: korns
 * Date: 23.11.2017
 * Time: 21:16
 */

namespace akfw\core;


class Request {
    protected $post;
    protected $get;

    public function __construct(){
        $this->post = $_POST;
        $this->get = $_GET;
    }

    public function isAjax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    public function isPost() {
        return strtoupper($_SERVER['REQUEST_METHOD']) == 'POST';
    }

    public function post($key, $default = null) {
        if (isset($this->post[$key])) {
            return $this->post[$key];
        }
        return $default;
    }

    public function get($key, $default = null) {
        if (isset($this->get[$key])) {
            return $this->get[$key];
        }
        return $default;
    }

    public function getPost() {
        return $this->post;
    }

    public function getGet() {
        return $this->get;
    }

}