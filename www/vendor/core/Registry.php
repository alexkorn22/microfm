<?php

namespace vendor\core;
use vendor\core\base\Model;
use vendor\libs\Cache;

/**
 * Class Registry
 * @package vendor\core
 * @property Cache $cache
 * @property Model $model
 * @property User $user
 */
class Registry{

    use TSingleton;
    private static $objects;

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