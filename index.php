<?php
/**
 * Created by PhpStorm.
 * User: Scratchy
 * Date: 24/10/2015
 * Time: 23:23
 */


require 'Tools/Autoloader/SplClassLoader.php';
//$classLoader = new SplClassLoader('Test','');
//$classLoader->register();
$classLoader = SplClassLoader::getInstance();
$classLoader->addNamespace('Tools', '');
$classLoader->addNamespace('Controller', '');
$classLoader->register();
use Tools\Router\Router;


$router = Router::_getInstance();
$router->routeTo();