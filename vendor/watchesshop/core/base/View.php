<?php

namespace watchesshop\base;

class View
{
    public $route;  //храним маршрут (контроллер, экшен, префикс)
    public $controller;
    public $view;
    public $model;
    public $prefix;
    public $data = [];
    public $meta = [];
    public $layout;

    public function __construct($route, $layout = '', $view = '', $meta){
        $this->route = $route;
        $this->view = $view;
        $this->meta = $meta;
        $this->controller = $route['controllers'];
        $this->model = $route['controllers'];
        $this->prefix = $route['prefix'];
        if($layout === false){
            $this->layout = false;
        }else{
            $this->layout = $layout ?: LAYOUT;
        }
    }

    public function render($data){
        if(is_array($data)){
            extract($data);
        }
        $viewFile = APP . "/views/{$this->prefix}{$this->controller}/{$this->view}.php";
        if(is_file($viewFile)){
            //Помещаем вид в буфер, а потом в $content
            ob_start();
            require_once $viewFile;
            $content = ob_get_clean();
        }else{
            throw new \Exception("Не найден вид $viewFile", 500);
        }
        if($this->layout !== false){
            $layoutFile = APP . "/views/layouts/{$this->layout}.php";
            if(is_file($layoutFile)){
                require_once $layoutFile;
            }else{
                throw new \Exception("Не найден шаблон $layoutFile", 500);
            }
        }
    }

    public function getMeta(){
        $out_meta =  "<title>" . $this->meta['title'] . "</title>" . PHP_EOL;
        $out_meta .= "<meta name='description' content='" . $this->meta['desc'] . "'>". PHP_EOL;
        $out_meta .= "<meta name='keywords' content='" . $this->meta['keywords'] . "'>";
        return $out_meta;
    }
}