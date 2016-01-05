<?php

namespace Tools\Router;

use Tools\HttpErrorException\NotFoundException;
use Tools\HttpErrorException\InternalServerErrorException;
/**
 * Created by PhpStorm.
 * User: Scratchy
 * Date: 24/10/2015
 * Time: 19:27
 */
final class Router
{
    const PATH_JSON_CONF = '/conf.json';
    private static $_instance;
    private $_routes;

    private function __construct()
    {
        $this->decodeJson();
    }

    /**
     * Singleton of Router
     * @return Router
     */
    public static function _getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Router();
        }
        return self::$_instance;
    }
    

    /**
     * Function for reading conf file and  iniatilize all routes
     */
    private function decodeJson()
    {
        $json = file_get_contents(getcwd().self::PATH_JSON_CONF);
        $confObject = json_decode($json);
        if (is_null($confObject) || !is_array($confObject)) {
            throw new InternalServerErrorException("The file " . self::PATH_JSON_CONF . " can't be convert, it's a not a valid JSON");
        }
        foreach ($confObject as $routeJson) {
            $action = explode("->",$routeJson->action);
            if((preg_match('/\/((?:\w+\/)*(?:\w+.html)?)(?:\{(\w+)\})?/', $routeJson->route, $matches)) === 0)
            {
                throw new InternalServerErrorException("Route was misformed : $routeJson->route");
            }
            $method= isset($action[1]) ? $action[1]:"";
            $uriParameter= isset($matches[2]) ? $matches[2] :"";
            $getParameter = array();
            $postParameter = array();
            if(isset($routeJson->method)) {
                $getParameter = isset($routeJson->method->GET)?$routeJson->method->GET : array();
                $postParameter =isset($routeJson->method->POST)?$routeJson->method->POST : array();
            }
            $this->_routes[$matches[0]] = new Route($routeJson->fileToInclude,$action[0],$method
               ,$routeJson->permission,$uriParameter,$getParameter,$postParameter);
        }
    }

    /**
     * Function for using the route corresponding to conf entry
     **/ 
    public function routeTo()
    {
        $routeQueried = explode("?",$_SERVER['REQUEST_URI']);
        $routeIndex = array_search($routeQueried[0],array_keys($this->_routes));
        $routeObject = array_values($this->_routes)[$routeIndex];
        if ($routeIndex === false || is_null($routeObject) || !$routeObject instanceof Route) {
            throw new NotFoundException("Failed to find resource");
        } else {
            $uriParameter = isset($routeQueried[1])? $routeQueried[1] : "";
            $routeObject->build($uriParameter);
        }
    }
}