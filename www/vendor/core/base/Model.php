<?php

namespace vendor\core\base;

use vendor\core\Db;

class Model{
    protected $connectDb;
    protected $table;

    public function __construct(){

        $this->connectDb = Db::getInstance();

    }
}