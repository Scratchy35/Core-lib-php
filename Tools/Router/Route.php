<?php

namespace Tools\Router;

use Tools\Authentication\Implementation\CurrentUserImpl;
use Tools\Authentication\Implementation\PermissionsMgt;
use Tools\Exceptions\HttpErrorException\ForbiddenException;
use Tools\Exceptions\HttpErrorException\HttpErrorException;
use Tools\Exceptions\HttpErrorException\UnauthorizedException;
use Tools\Exceptions\HttpErrorException\InternalServerErrorException;

/**
 * Created by PhpStorm.
 * User: Scratchy
 * Date: 24/10/2015
 * Time: 19:53
 */
final class Route {

    /**
     *
     * @var string uri of the route
     */
    private $_uri;

    /**
     * @var string path to the file in case of no support of autoloader
     */
    private $_fileToInclude;

    /**
     * @var string class to call
     */
    private $_classToInclude;

    /**
     * @var string method to call
     */
    private $_methodToCall;

    /**
     * @var string[] Groups authorized to access a URI
     */
    private $_permission;

    /**
     * @var string name of parameter in URI
     */
    private $_uriParameterName;

    /**
     * @var string method use to access to the route
     */
    private $_methodHttp;

    /**
     * @var string[] name of parameter GET
     */
    private $_getParameterName;

    /**
     * @var string[] name of parameter POST
     */
    private $_postParameterName;

    /**
     * @var bool boolean to check if input have to be secured
     */
    private $_securedInput;

    /**
     * Route constructor.
     * @param string $uri uri of the route
     * @param string $fileToInclude file to include in case of not OOP paradigm
     * @param string $classToInclude class to include
     * @param string $methodToCall method to call in the class
     * @param string[] $permission permission for this routes
     * @param string $uriParameterName uri parameter for the route
     * @param string $methodHttp method http use to request the route , by default GET
     * @param array $getParameterName get parameter for the route
     * @param array $postParameterName post parameter for the route
     * @param boolean $securedInput boolean to check if input have to be secured
     */
    public function __construct($uri, $fileToInclude, $classToInclude, $methodToCall, $permission, $uriParameterName = "", $methodHttp = "GET", $getParameterName = array(), $postParameterName = array(), $securedInput = false) {
        $regex = str_replace("{".$uriParameterName."}", "((?:\w|\ )+)?", $uri);
        $regex = str_replace("/", "\/", $regex);
        $regex = "/^$regex$/";
        $this->_uri = $regex;
        $this->_fileToInclude = $fileToInclude;
        $this->_classToInclude = $classToInclude;
        $this->_methodToCall = $methodToCall;
        $this->_permission = $permission;
        $this->_methodHttp = $methodHttp;
        $this->_uriParameterName = $uriParameterName;
        $this->_getParameterName = $getParameterName;
        $this->_postParameterName = $postParameterName;
        $this->_securedInput = $securedInput;
        $this->_permission = $permission;
    }

    /**
     * @param $uriParameter
     * @throws HttpErrorException
     * @throws \Exception
     */
    public function build($uriParameter) {
        //permission test
        if(!$this->isPermitted()){
            throw new ForbiddenException("The user is not permitted to access this ressource");
        }
        if (!empty($this->_classToInclude)) {
            //if classToInclude is defined, call the method
            $class = null;
            try {
                $this->callMethod($uriParameter);
            } catch (HttpErrorException $httpError) {
                throw $httpError;
            } catch (Exception $e) {
                throw new InternalServerErrorException("Failed to call the method $this->_methodToCall in class $this->_classToInclude");
            }
        } else {
            //include file if no class is defined
            include $this->_fileToInclude;
        }
    }

    private function isPermitted() {
        return  PermissionsMgt::getInstance()->canAccess($this->_permission)  ;
    }

    /**
     * Call of the method
     * @param $uriParameter
     */
    private function callMethod($uriParameter = null) {
        try {
            $controllerMethodReflection = new \ReflectionMethod($this->_classToInclude, $this->_methodToCall);
        } catch (\ReflectionException $rex) {
            throw new InternalServerErrorException("No method $this->_methodToCall in class $this->_classToInclude");
        }
        $parameterFunc = array();
        $parameters = $controllerMethodReflection->getParameters();

        //iterate over method parameter;
        foreach ($parameters as $parameter) {
            //looking for uri,get,post parameter name in the route,
            //if found then adding them to array parameterFunc
            if ($parameter->name == $this->_uriParameterName) {
                preg_match($this->_uri, $uriParameter,$match);
                if(isset($match[1])){
                    $parameterFunc[] = $match[1];
                }
            }
            if (in_array($parameter->name, $this->_getParameterName)) {
                $parameterFunc[] = $_GET[$parameter->name];
            }
            if (in_array($parameter->name, $this->_postParameterName)) {
                $parameterFunc[] = isset($_POST[$parameter->name]) ? $_POST[$parameter->name] : null;
            }
        }
        //Instantiate class
        $controller = new $this->_classToInclude();

        //invoke method
        $controllerMethodReflection->invokeArgs($controller, $parameterFunc);
    }

    public function equalsRoute($method, $url) {
        return $method == $this->_methodHttp 
                && preg_match($this->_uri, $url)
                && array_keys($_GET) == $this->_getParameterName;
    }

}
