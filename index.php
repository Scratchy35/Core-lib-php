<?php

/**
 * Created by PhpStorm.
 * User: Scratchy
 * Date: 24/10/2015
 * Time: 23:23
 */
$loader = require __DIR__ . '/vendor/autoload.php';

use Tools\Router\Router;
use Tools\Exceptions\HttpErrorException\HttpErrorException;
use Tools\Authentication\Implementation\AuthenticationImpl;
use Tools\Exceptions\AuthenticationException\UserDontExistException;
use Tools\Exceptions\AuthenticationException\FailedKerberosAuthent;

$authentication = AuthenticationImpl::_getInstance();

try {
    $authentication->authenticate();
    $router = Router::_getInstance();
    $router->routeTo();
} catch (UserDontExistException $ex){
    echo "Vous n'êtes pas actuellement autorisé à acceder à Iguazu";
    $ex->changeCodeError();
} catch (HttpErrorException $httpError) {
    $httpError->changeCodeError();
    echo $httpError->getMessage();
} catch (FailedKerberosAuthent $ex) {
    $ex->changeCodeError();
    echo "Aucun jeton kerberos récupéré";
}


