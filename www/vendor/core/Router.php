<?php

class Router{

    protected static $routes = [];
    protected static $route = [];

    public static function add($regexp,$route = []){
        self::$routes[$regexp] = $route;
    }

    public static function getRoutes(){
        return self::$routes;
    }


    public static function getRoute(){
        return self::$route;
    }

    public static function matchRoute($url){
        foreach (self::$routes as $pattern=>$route){
            if (preg_match_all("#$pattern#i",$url,$matches))  {
                foreach ($matches as $key=>$value) {
                    if (is_string($key)){
                        $route[$key] = $value[0];
                    }
                }
                if (empty($route['action'])){
                    $route['action'] = 'index';
                }
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    protected static function upperCamelCase($name){

        return str_replace(' ','',ucwords(str_replace('-',' ',$name)));

    }

    protected static function lowerCamelCase($name){

        return lcfirst(self::upperCamelCase($name));

    }

    public static function dispatch($url){
        if (Router::matchRoute($url)){
            $controller = self::upperCamelCase(self::$route['controller']);
            if (class_exists($controller)) {
                $objController = new $controller;
                $method = self::lowerCamelCase(self::$route['action']) . 'Action';
                if (method_exists($objController,$method)){
                    $objController->$method();
                } else {
                    echo "Метод $controller::$method не найден";
                }
            } else {
                echo "Контролер $controller не найден";
            }
        }else {
            http_response_code(404);
            include_once '404.html';
        }
    }


}
