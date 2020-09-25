<?php

namespace application\core;

use application\core\View; //работает и без этого

class Router{

    protected $routes = [];
    protected $params = [];

    function __construct(){
        $arr = require 'application/config/routes.php';
        foreach ($arr as $key => $val){
            $this->add($key, $val);
        }
        // debug($arr);
    }

    public function add($route, $params){
        $route = '#^'.$route.'$#';
        $this->routes[$route] = $params;
    }

    public function match(){
        $uri = $_SERVER['REQUEST_URI'];
        // Вырезаем имя домена
        $uri = preg_replace('%^/%', '', $uri);
        // Вырезаем параметры, если они есть
        $uri = preg_replace('%\?(.*)%', '', $uri);
        // debug($uri);
        foreach ($this->routes as $route =>$params){
            // Eсли, найденно совпадение с каким-либо маршрутом в формате controller/action
            if (preg_match($route, $uri, $matches)){
                // То заносим его controller и action в поле Router->params
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    public function run(){
        if ($this->match()){
            $path = "application\controllers\\".ucfirst($this->params['controller'])."Controller";
            if (class_exists($path)){
                $action = $this->params['action']."Action";
                if (method_exists($path, $action)){
                    $controller= new $path($this->params);
                    $controller->$action();
                }
                else{
                    View::errorCode(404);
                }
            }
            else{
                View::errorCode(404);
            }
        }
        else{
            View::errorCode(404);
        }
    }
}
