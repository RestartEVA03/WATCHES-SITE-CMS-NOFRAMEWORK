<?php

namespace app\controllers\admin;

use app\models\User;

class UserController extends AppController
{
    public function loginAdminAction(){
        if(!empty($_POST)){
            $user = new User();
            if($user->login(true)){
                $_SESSION['success'] = 'Админ успешно авторизован';
            }else{
                $_SESSION['error'] = 'Логин или пароль введены неверно';
            }
            if($user::isAdmin()){
                redirect(ADMIN);
            }else{
                redirect();
            }
        }
        $this->layout = 'login';
    }
}