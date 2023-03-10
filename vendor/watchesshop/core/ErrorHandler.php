<?php

namespace watchesshop;

class ErrorHandler
{
    public function __construct(){
        if(DEBUG){
            error_reporting(-1); //Выводим все ошибки
        }else{
            error_reporting(0); //Не выводим ошибка
        }
        set_exception_handler([$this, 'exceptionHandler']); //Задаём обработчик ошибок
    }

    public function exceptionHandler($error){
        $this->logErrors($error->getMessage(), $error->getFile(), $error->getLine());
        $this->displayError('Исключение', $error->getMessage(), $error->getFile(), $error->getLine(),
                            $error->getCode());
    }

    protected function logErrors($message = '', $file = '', $line = ''){
        error_log("[". date("Y-m-d H:i:s") ."] Текст ошибки: $message | Файл: $file | Строка: $line 
        \n********\n", 3, ROOT . "/tmp/errors.log");
    }

    protected function displayError($error_numb, $error_str, $error_file, $error_line, $responce = 404){
        http_response_code($responce); //Отправляет код в заголовок
        if($responce == 404 && !DEBUG){
            require_once WWW . '/errors/404.php';
        }elseif(DEBUG){
            require_once WWW . '/errors/dev.php';
        }else{
            require_once WWW . '/errors/prod.php';
        }
        die;
    }
}