<?php

namespace Tools\Router;

use Tools\HttpErrorException\ForbiddenException;
use Tools\HttpErrorException\UnauthorizedException;
//use Tools\HttpErrorException\
/**
 * Created by PhpStorm.
 * User: Scratchy
 * Date: 24/10/2015
 * Time: 19:53
 */
final class Route
{
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
     * @var string Group authorized to access a URI
     */
    private $_permission;

    /**
     * @var string name of parameter in URI
     */
    private $_uriParameterName;

    /**
     * @var array name of parameter GET
     */
    private $_getParameterName;

    /**
     * @var array name of parameter POST
     */
    private $_postParameterName;


    private $_securedInput;

    /**
     * Route constructor.
     * @param $fileToInclude
     * @param $classToInclude
     * @param $permission
     * @param $methodToCall
     * @param $uriParameterName
     * @param $getParameterName
     * @param $postParameterName
     * @param $securedInput
     */
    public function __construct($fileToInclude, $classToInclude, $methodToCall, $permission, $uriParameterName = "", $getParameterName = array(), $postParameterName = array(),$securedInput = false)
    {
        $this->_fileToInclude = $fileToInclude;
        $this->_classToInclude = $classToInclude;
        $this->_methodToCall = $methodToCall;
        $this->_permission = $permission;
        $this->_uriParameterName = $uriParameterName;
        $this->_getParameterName = $getParameterName;
        $this->_postParameterName = $postParameterName;
        $this->_securedInput = $securedInput;
    }

    /**
     * @param $uriParameter
     * @throws Exception
     */
    public function build($uriParameter)
    {
        if ($this->getPermission()) {

            if (!empty($this->_classToInclude)) {
                $class = null;
                try {
                    $this->callMethod($uriParameter);
                }
                catch(Exception $e)
                {
                    throw new Exception("Failed to call the method $this->_methodToCall in class $this->_classToInclude");
                }
            } else {
                include $this->_fileToInclude;
            }
        } else {
            throw new Exception("Failed to find route, maybe redirect to 401");
        }
    }

    private function getPermission()
    {
        // TODO : initialiser si besoin est la session et les permissions
        return true;
    }

    /**
     *
     * @param $uriParameter
     */
    private function callMethod($uriParameter)
    {
        $controllerMethodReflection = new \ReflectionMethod($this->_classToInclude, $this->_methodToCall);
        $parameterFunc = array();
        $parameters = $controllerMethodReflection->getParameters();
        foreach ($parameters as $parameter) {
            if ($parameter->name == $this->_uriParameterName) {
                $parameterFunc[] = $uriParameter;
            }
            if (in_array($parameter->name, $this->_getParameterName)) {
                $parameterFunc[] = $_GET[$parameter->name];
            }
            if (in_array($parameter->name, $this->_postParameterName)) {
                $parameterFunc[] = $_POST[$parameter->name];
            }
        }
        $controller = new $this->_classToInclude();
        $controllerMethodReflection->invokeArgs($controller, $parameterFunc);
    }
}


