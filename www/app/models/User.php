<?php


namespace app\models;


use akfw\core\base\ModelRecord;

/**
 * Class User
 * @package app\models,
 * @property string login,
 * @property string email,
 * @property string password,
 * @property string role,
 */
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
    public $labels = [
        'password' => 'Пароль',
        'login' => 'Логин',
        'email' => 'Почта',
    ];

}