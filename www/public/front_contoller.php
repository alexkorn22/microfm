<?php
use akfw\core\Router;

define('DEBUG',1);
define('WWW', __DIR__);
define('CORE', dirname(__DIR__) . '/vendor/akfw/core');
define('ROOT', dirname(__DIR__));
define('APP', dirname(__DIR__) . '/app');
define('LAYOUT', 'default');
define('LIBS', dirname(__DIR__) . '/vendor/akfw/libs');
define('CACHE', dirname(__DIR__) . '/tmp/cache');

require LIBS .'/functions.php';

//spl_autoload_register(function ($class) {
//    $nameClass = str_replace('\\','/',$class);
//    $file = ROOT . "/$nameClass.php";
//    if (file_exists($file)) {
//        require_once $file;
//    }
//});
require __DIR__ . '/../vendor/autoload.php';

new \akfw\core\App();
