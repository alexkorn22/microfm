<?php
use vendor\core\Router;

define('WWW', __DIR__);
define('CORE', dirname(__DIR__) . '/vendor/core');
define('ROOT', dirname(__DIR__));
define('APP', dirname(__DIR__) . '/app');
define('LAYOUT', 'default');
define('LIBS', dirname(__DIR__) . '/vendor/libs');

error_reporting(-1);

require '../vendor/libs/functions.php';

spl_autoload_register(function ($class) {
    $nameClass = str_replace('\\','/',$class);
    $file = ROOT . "/$nameClass.php";
    if (file_exists($file)) {
        require_once $file;
    }
});

$query = rtrim($_SERVER['QUERY_STRING'], '/');

//routers
Router::add('^page/?(?P<alias>[a-z-]+)?$',['controller'=>'Page','action'=>'view']);

//default routers
Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');