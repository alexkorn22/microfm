<?php


namespace app\models;


use akfw\core\base\ModelRecord;

class User extends ModelRecord {

    public static $tableName = 'users';
    public $attributes = [
        'login' => '',
        'email' => '',
        'password' => '',
        'role' => 'user',
    ];
    public $rules = [
        'required' => [
            'login',
            'email',
            'password'
        ],
        'email' => ['email'],
        'lengthMin' => [
            ['password',6]
        ]
    ];

}