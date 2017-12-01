<?php

namespace akfw\core\base;

use RedBeanPHP\OODBBean;
use Valitron\Validator;

abstract class ModelRecord{

    protected static $tableName = '';
    /**
     * @var OODBBean
     */
    protected $bean;
    public $attributes = [];
    public $rules = [];
    public $labels = [];
    public $errors = [];
    public $id = 0;


    public function __construct($bean = null){
        if ($bean) {
            $this->bean = $bean;
        }else {
            $this->bean = \R::dispense(static::$tableName);
        }
    }

    public function load($data){
        if (!is_array($data)){
            return false;
        }
        foreach ($this->attributes as $key => $value) {
            if (isset($data[$key])) {
                $this->attributes[$key] = $data[$key];
            }
        }
        return true;
    }

    public function save(){
        $this->bean->import($this->attributes);
        if ($this->id) {
            $this->bean->id = $this->id;
        }
        $res = \R::store($this->bean);
        if (!$res) {
            return false;
        }
        $this->id = $res;
        return true;
    }

    /**
     * @param $sql
     * @param $params
     * @return static[]
     */
    public static function find($sql = '', $params = []) {
        $result = [];
        $beans  = \R::find(static::$tableName, $sql, $params);
        foreach ($beans as $bean) {
            $item = new static();
            foreach ($item->attributes as $key => $value) {
                $item->attributes[$key] = $bean->$key;
            }
            $item->id = $bean->id;
            $item->bean = $bean;
            $result[] = $item;
        }
        return $result;
    }

    public function __get($name){
        if (isset($this->attributes[$name])) {
            return    $this->attributes[$name];
        }
        return null;
    }

    public function __set($name, $value){
        if (isset($this->attributes[$name])) {
            $this->attributes[$name] = $value;
        }
    }

    public static function totalCount($params = []){
        if (count($params) > 0) {
            $sql = 'WHERE ';
            $paramsTotal = [];
            $paramsSql = [];
            foreach ($params as $key => $value) {
                $paramsTotal[':' . $key] = $value;
                $paramsSql[] = ':' . $key . '=' . $key;
            }
            $sql .= implode(' AND ',$paramsSql);
            return \R::count(static::$tableName,$sql,$paramsTotal);
        }
        return \R::count(static::$tableName);
    }

    public static function delete($id) {
        $bean = \R::findOne(static::$tableName,'id = ?',[$id]);
        \R::trash($bean);
    }

    public static function findOneById($id) {
        $bean  = \R::findOne(static::$tableName, 'id = :id', [':id' => $id]);
        $item = new static();
        if ($bean) {
            foreach ($item->attributes as $key => $value) {
                $item->attributes[$key] = $bean->$key;
            }
            $item->id = $bean->id;
            $item->bean = $bean;
        }
        return $item;
    }

    public static function findOne($params = []) {
        $sql = '';
        $paramsTotal = [];
        if (count($params) > 0) {
            $sql = 'WHERE ';
            $paramsSql = [];
            foreach ($params as $key => $value) {
                $paramsTotal[':' . $key] = $value;
                $paramsSql[] = ':' . $key . '=' . $key;
            }
            $sql .= implode(' AND ',$paramsSql);
        }
        $query = static::makeQueryData($params);
        $bean  = \R::findOne(static::$tableName, $query['sql'], $query['params']);
        $item = new static();
        if ($bean) {
            foreach ($item->attributes as $key => $value) {
                $item->attributes[$key] = $bean->$key;
            }
            $item->id = $bean->id;
            $item->bean = $bean;
        }
        return $item;
    }

    protected static function makeQueryData($params) {
        $result = [
            'sql' => '',
            'params' => [],
        ];
        $paramsTotal = [];
        if (count($params) > 0) {
            $result['sql'] = 'WHERE ';
            $paramsSql = [];
            foreach ($params as $key => $value) {
                $result['params'][':' . $key] = $value;
                $paramsSql[] = ':' . $key . '=' . $key;
            }
            $result['sql'] .= implode(' AND ',$paramsSql);
        }
        return $result;
    }

    public function isEmpty(){
        return $this->bean->isEmpty();
    }

    public function validate() {
        $this->errors = [];
        Validator::lang('ru');
        $v = new Validator($this->attributes);
        $v->rules($this->rules);
        $v->labels($this->labels);
        if(!$v->validate()) {
            $this->errors = $v->errors();
            return false;
        }
        return true;
    }

    public function getErrors() {
        $res = '<ul>';
        foreach ($this->errors as $error) {
            foreach ($error as $item) {
                $res .= "<li>$item</li>";
            }
        }
        $res .= '</ul>';
        return $res;
    }

}