<?php

require '../vendor/libs/functions.php';
require '../vendor/core/Router.php';

$query = rtrim($_SERVER['REQUEST_URI'],'/');
$query = ltrim($query,'/');

Router::add('posts/add',['controller'=>'Posts','action'=>'add']);
Router::add('',['controller'=>'Main','action'=>'index']);

if (Router::matchRoute($query)){
    //debug(Router::getRoute());
}else {
    echo '404';
}