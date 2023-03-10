<?php

namespace app\controllers;

use app\models\User;
use watchesshop\App;

class UserController extends AppController
{
    public function signupAction(){
        if(!empty($_POST)){
            $user = new User();
            $data = $_POST;
            $user->load($data);
            if(!$user->validate($data) || !$user->checkUnique()){
                $user->getErrors();
                $_SESSION['form_data'] = $data;
            }else{
                $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
                if($user->save('user')){
                    $_SESSION['success'] = 'Пользователь зарегистрирован';
                }else{
                    $_SESSION['error'] = 'Ошибка регистрации';
                }
                redirect(PATH . '/user/login');
            }
            redirect();
        }
        $this->setMeta("Регистрация");
    }

    public function loginAction(){
        if(!empty($_POST)){
            $user = new User();
            if($user->login()){
                $_SESSION['success'] = 'Вы авторизованы';
            }else {
                $_SESSION['error'] = 'Логин или пароль введены неверно';
            }
            redirect(PATH);
        }
        $this->setMeta('Вход');
    }

    public function logoutAction(){
        if(isset($_SESSION['user'])) unset($_SESSION['user']);
        redirect();
    }

}