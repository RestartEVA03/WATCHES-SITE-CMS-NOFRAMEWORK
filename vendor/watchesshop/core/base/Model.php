<?php

namespace watchesshop\base;

use RedUNIT\Base\Database;
use Valitron\Validator;
use watchesshop\Db;

abstract class Model
{
    public $attributes = [];
    public $erros = [];
    public $rules = [];

    public function __construct(){
        Db::instance();
    }

    public function load($data){
        foreach ($this->attributes as $name => $value){
            if(isset($data[$name])){
                $this->attributes[$name] = $data[$name];
            }
        }
    }

    public function save($table){
        $tbl = \R::dispense($table);
        foreach ($this->attributes as $name => $value){
            $tbl->$name = $value;
        }
        return \R::store($tbl);
    }

    public function validate($data){
        Validator::langDir(WWW.'/validator/lang');
        Validator::lang('ru');
        $v = new Validator($data);
        $v->rules($this->rules);
        if($v->validate()) return true;
        $this->erros = $v->errors();
        return false;
    }

    public function getErrors(){
        $errors = '<ul>';
        foreach ($this->erros as $error){
            foreach ($error as $item){
                $errors .= "<li>$item</li>";
            }
        }
        $errors .= '</ul>';
        $_SESSION['error'] = $errors;
    }
}