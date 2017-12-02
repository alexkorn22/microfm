<?php

namespace akfw\core;


use akfw\core\base\View;

class ErrorHandler {

    public function __construct(){
        error_reporting(-1);
        set_error_handler([$this,'errorHandler']);
        set_exception_handler([$this,'exceptionHandler']);
        ob_start();
        register_shutdown_function([$this, 'fatalErrorHandler']);
    }

    public function errorHandler($errno, $errstr, $errfile, $errline){
        $this->displayError($errno, $errstr, $errfile, $errline);
        $this->logger($errno, $errstr, $errfile, $errline);
    }

    public function fatalErrorHandler(){
        $error = error_get_last();
        if (!empty($error) && $error['type'] & (E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)) {
            ob_end_clean();
            $this->displayError($error['type'], $error['message'], $error['file'], $error['line']);
            $this->logger($error['type'], $error['message'], $error['file'], $error['line']);
        } else {
            ob_end_flush();
        }
    }

    public function exceptionHandler(\Exception $e) {
        $this->displayError('Exception', $e->getMessage(), $e->getFile(), $e->getLine(),$e->getCode());
        $this->logger('Exception', $e->getMessage(), $e->getFile(), $e->getLine(),$e->getCode());
    }

    protected function displayError($errno, $errstr, $errfile, $errline,$response = 500) {
        http_response_code($response);
        $route = [
            'prefix' => '',
            'controller' => 'Errors'
        ];
        $view = $this->getNameView($response);
        $objView = new View($route, LAYOUT, $view);
        $objView->render(compact('errno','errstr','errfile','errline'));
    }

    protected function getNameView($response) {
        $view = 'prod';
        if ($response == 404) {
            $view = '404';
        }
        if (DEBUG) {
            $view = 'dev';
        }
        return $view;
    }

    protected function logger($errno, $errstr, $errfile, $errline,$response = 500) {
        $text = "[" . date('Y-m-d H:i:s') . "]\n";
        $text .= "Номер ошибки: " . $errno . "\n";
        $text .= "Код ответа:   " . $response . "\n";
        $text .= "Текст:        " . $errstr . "\n";
        $text .= "Файл:         " . $errfile . "\n";
        $text .= "Строка файла: " . $errline . "\n";
        $text .= "##########################################\n";
        error_log($text,3,ROOT . '/tmp/error.log');
    }

}