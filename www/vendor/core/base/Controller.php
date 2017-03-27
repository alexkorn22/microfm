<?php
/**
 * Created by PhpStorm.
 * User: korns
 * Date: 26.03.2017
 * Time: 21:56
 */

namespace vendor\core\base;

abstract class Controller{

    /**
     * текущий маршрут
     * @var array
     */
    public $route = [];

    /**
     * имя файла вида(по умолчанию название экшена)
     * @var string
     */
    public $view;

    /**
     * текущий файл шаблона
     * @var string
     */
    public $layout;

    /**
     * параметры для передачи в вид
     * @var array
     */
    public $vars = [];

    public function __construct($route){

        $this->route = $route;
        $this->view = $route['action'];

    }

    public function getView(){

        $objView = new View($this->route, $this->layout, $this->view);
        $objView->render($this->vars);

    }

    public function setVars($vars){

        $this->vars = $vars;

    }

}