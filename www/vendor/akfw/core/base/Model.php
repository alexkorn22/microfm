<?php

namespace akfw\core\base;

use akfw\core\Db;

class Model{
    protected $connectDb;
    protected $table;

    public function __construct(){

        $this->connectDb = Db::getInstance();

    }

    public function execute($sql) {

        //return $this->connectDb->execute($sql);

    }

    /**
     * @return array
     */
    public function findAll() {

         $sql = "SELECT * FROM {$this->table}";
        //return $this->connectDb->query($sql);
    }


}