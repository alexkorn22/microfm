<?php

namespace vendor\core\base;

class View{

    public $route = [];
    public $view;
    public $layout;

    public function __construct($route,$layout = '',$view = ''){

        $this->route = $route;
        $this->view = $view;
        $this->layout = $layout ? $layout : LAYOUT;

    }

    public function render() {

        $fileView =  APP . "/views/{$this->route['controller']}/{$this->view}.php";
        ob_start();
        if (is_file($fileView)){
            require $fileView;
        } else {
            echo "<p>Не найден вид <b>$fileView</b></p>";
        }
        $content = ob_get_clean();
        $fileLayout = APP . "/views/layouts/{$this->layout}.php";
        if (is_file($fileLayout)){
            require $fileLayout;
        } else {
            echo "<p>Не найден шаблон <b>$fileLayout</b></p>";
        }
    }

}