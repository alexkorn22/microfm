<?php

class Router{

    /**
     * массив всех правил
     * @var array
     */
    protected static $routes = [];

    /**
     * Текущее правило
     * @var array
     */
    protected static $route = [];

    /**
     * Добавляет правила маршрутизации
     * @param $regexp
     * @param array $route
     */
    public static function add($regexp, $route = []){
        self::$routes[$regexp] = $route;
    }

    /**
     * @return array
     */
    public static function getRoutes(){
        return self::$routes;
    }


    /**
     * @return array
     */
    public static function getRoute(){
        return self::$route;
    }

    /**
     * Проверка совпадения правила роутинга по URL
     * @param $url
     * @return bool
     */
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

    /**
     * @param $name
     * @return mixed
     */
    protected static function upperCamelCase($name){

        return str_replace(' ','',ucwords(str_replace('-',' ',$name)));

    }

    /**
     * @param $name
     * @return string
     */
    protected static function lowerCamelCase($name){

        return lcfirst(self::upperCamelCase($name));

    }

    /**
     * Функция перенаправляет входящий URL по правилам
     * @param $url
     */
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
