<?php

namespace vendor\core;

use vendor\libs\Cache;

/**
 * Class App
 * @package vendor\core
 */
class App{

    /**
     * @var Registry
     */
    public static $app;

    public function __construct(){
        self::$app = Registry::getInstance();
    }

}