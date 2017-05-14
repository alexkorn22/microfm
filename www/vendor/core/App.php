<?php
/**
 * Created by PhpStorm.
 * User: korns
 * Date: 14.05.2017
 * Time: 19:15
 */

namespace vendor\core;


class App{

    public static $app;

    public function __construct(){
        self::$app = Registry::getInstance();
    }

}