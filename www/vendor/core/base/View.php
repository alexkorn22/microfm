<?php

namespace vendor\core\base;

class View{

    public $route = [];
    public $view;

    public function __construct($route,$layout = '',$view = ''){
        $this->route = $route;
        $this->view = $route['action'];
        //include APP . "/views/{$this->route['controller']}/{$this->view}.php";
    }



}