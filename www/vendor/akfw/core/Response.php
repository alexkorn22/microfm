<?php
/**
 * Created by PhpStorm.
 * User: korns
 * Date: 23.11.2017
 * Time: 21:06
 */

namespace akfw\core;


class Response{

    public function redirect($url) {
        header('Location: '.$url);
    }

}