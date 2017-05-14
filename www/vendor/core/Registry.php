<?php

namespace vendor\core;

/**
 * Class Registry
 * @package vendor\core
 */
class Registry{

    private static $instance;
    private static $objects;

    protected function __construct(){
        $config = require ROOT . '/config/config.php';
        foreach ($config['components'] as $name => $component) {
            self::$objects[$name] = new $component;
        }
    }

    public static function getInstance(){
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __set($name, $value){
        if (!isset(self::$objects[$name])) {
            self::$objects[$name] = new $value;
        }
    }
    public function __get($name){
        if (is_object(self::$objects[$name])) {
            return self::$objects[$name];
        }
    }

    public function getObj() {
        debug(self::$objects);
    }

}