<?php

namespace app\controllers;


use app\models\AppModel;
use RedBeanPHP\R;
use watchesshop\Cache;

class MainController extends AppController
{
    public function indexAction(){
        $brands = R::findAll("brand", "LIMIT 3");
        $hits = R::findAll('product', "hit = '1' AND status = '1' LIMIT 16");
        $this->setMeta('Главная страница', 'Описание..', 'Ключивые слова');
        $this->set(compact('brands', 'hits'));
    }

}