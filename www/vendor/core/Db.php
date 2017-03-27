<?php

namespace vendor\core;

class Db{

    private static $instance;

    /**
     * @var \PDO
     */
    public $pdo;

    protected function __construct(){

        $config = require ROOT . '/config/db.php';
        $opt = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $this->pdo = new \PDO($config['dsn'], $config['user'], $config['pass'], $opt);
        } catch (\PDOException $e) {
            die('Подключение не удалось: ' . $e->getMessage());
        }

    }

    /**
     * @return Db
     */
    public static function getInstance(){
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function execute($sql){
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute();
    }

    public function query($sql){

        $stmt = $this->pdo->prepare($sql);
        $res = $stmt->execute();
        if ($res != false) {
            return $stmt->fetchAll();
        }else {
            return [];
        }

    }
}