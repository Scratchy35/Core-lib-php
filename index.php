<?php
/**
 * Created by PhpStorm.
 * User: Scratchy
 * Date: 24/10/2015
 * Time: 23:23
 */
$loader = require __DIR__ . '/vendor/autoload.php';
use Tools\Router\Router;
use Tools\HttpErrorException\HttpErrorException;

//TODO: Authentification ici

$router = Router::_getInstance();
try
{
    $router->routeTo();
}
catch (HttpErrorException $httpError)
{
    http_response_code($httpError->getErrorCode());
    //error_log(implode('\n',$httpError->getTrace()));
    throw $httpError;
}

