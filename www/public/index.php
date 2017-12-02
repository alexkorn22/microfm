<?php

use akfw\core\Router;

require 'front_contoller.php';

//echo $test;
throw new Exception('Exception test',404);

die();
//routers
Router::add('^page/?(?P<alias>[a-z-]+)?$',['controller'=>'Page','action'=>'view']);

//default routers
//admin
Router::add('^admin$', ['prefix' => 'admin', 'controller' => 'Main', 'action' => 'index']);
Router::add('^admin/(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['prefix' => 'admin']);

Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

Router::dispatch(rtrim($_SERVER['QUERY_STRING'], '/'));