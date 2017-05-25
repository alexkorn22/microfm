<?php

namespace vendor\core;
use vendor\core\base\Model;
use vendor\libs\Cache;
use vendor\core;

/**
 * Class Registry
 * @package vendor\core
 * @property Cache $cache
 * @property Model $model
 * @property User $user
 */
class Registry{

    /**
     * @property Cache $cache
     * @property Model $model
     * @property User $user
     */
    private static $instance;
    private static $objects;

    public static function getInstance(){
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function __construct(){
        $config = require ROOT . '/config/config.php';
        foreach ($config['components'] as $name => $component) {
            self::$objects[$name] = new $component;
        }
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

}