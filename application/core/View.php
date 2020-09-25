<?php

namespace application\core;

class View {

    public $path;
    // То же самое, что и в контроллере
    public $route;
    public $layout = 'default';

    public function __construct($route){
        $this->route = $route;
        $this->path = $route['controller']."/".$route['action'];
    }

    public function render($title, $layout, $vars=[]){
        if (isset($layout))
            $this->layout = $layout;
        extract($vars);
        $path = "application/views/".$this->path.".php";
        if (file_exists($path)){
            ob_start();
            require $path;
            $content = ob_get_clean();
            require "application/views/layouts/".$this->layout.".php";
        }
        else{
            View::errorCode(404);
        }
    }

    public function setView($view){
        $this->path = $this->route['controller']."/".$view;
    }

    public function redirect($url){
        header("Location: ".$url);
        exit();
    }

    public static function errorCode($code){
        http_response_code($code);
        // $path = "application/views/errors/".$code.".php";
        // if (file_exists($path))
        //     require $path;
        exit();
    }


}