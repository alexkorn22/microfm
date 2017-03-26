<?php
define('WWW',__DIR__);
define('CORE',dirname(__DIR__) . '/vendor/core');
define('ROOT',dirname(__DIR__));
define('APP',dirname(__DIR__) . '/app');

require '../vendor/libs/functions.php';
require '../vendor/core/Router.php';


spl_autoload_register(function ($class){
   $file = APP . "/controllers/$class.php";
    if (file_exists($file)){
        require_once $file;
    }
});

$query = rtrim($_SERVER['REQUEST_URI'],'/');
$query = ltrim($query,'/');

//routers

//default routers
Router::add('^$',['controller'=>'Main','action'=>'index']);
Router::add('(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?');

Router::dispatch($query);
