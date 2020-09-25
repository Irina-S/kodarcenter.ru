<?php

// require 'application/lib/Dev.php';

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

use application\core\Router;

spl_autoload_register(function ($class) {
    $path = str_replace('\\', '/', $class.'.php');
    if (file_exists($path))
        require $path;
});

session_start();

$router = new Router();
$router->run();

