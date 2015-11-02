<?php
/**
 * Created by PhpStorm.
 * User: Scratchy
 * Date: 24/10/2015
 * Time: 23:23
 */


require 'Tools/Autoloader/SplClassLoader.php';
require 'Lib\\apache-log4php-2.3.0\\src\\main\\php\\Logger.php';
//$classLoader = new SplClassLoader('Test','');
//$classLoader->register();
$classLoader = SplClassLoader::getInstance();
$classLoader->addNamespace('Tools', '');
$classLoader->addNamespace('Controller', '');
$classLoader->register();
use Tools\Router\Router;
use Tools\HttpErrorException\HttpErrorException;
$logger = Logger::getLogger("main");
$router = Router::_getInstance();
try
{
    $router->routeTo();
}
catch (HttpErrorException $httpError)
{
    http_response_code($httpError->getErrorCode());
}

