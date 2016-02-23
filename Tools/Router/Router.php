<?php

namespace Tools\Router;

use Tools\Exceptions\HttpErrorException\NotFoundException;
use Tools\Exceptions\HttpErrorException\InternalServerErrorException;

/**
 * Created by PhpStorm.
 * User: Scratchy
 * Date: 24/10/2015
 * Time: 19:27
 */
final class Router {

    const PATH_JSON_CONF = '/Configuration/Route.json';

    private static $_instance;
    private $_routes;

    /**
     * Router constructor.
     */
    private function __construct() {
        $this->decodeJson();
    }

    /**
     * Singleton of Router
     * @return Router
     */
    public static function _getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new Router();
        }
        return self::$_instance;
    }

    /**
     * Function for reading conf file and  iniatilize all routes
     */
    private function decodeJson() {
        //reading json conf file
        $json = file_get_contents(getcwd() . self::PATH_JSON_CONF);
        $confObject = json_decode($json);
        if (is_null($confObject) || !is_array($confObject)) {
            throw new InternalServerErrorException("The file " . self::PATH_JSON_CONF . " can't be convert, it's a not a valid JSON");
        }

        //iterate over routes in json conf
        foreach ($confObject as $routeJson) {
            //throw exception if url doesn't match regexp
            if ((preg_match('/\/((?:[\w-]+\/)*(?:[\w-]+(?:\.(?:html|php))?)?)(?:\{(\w+)\})?/', $routeJson->route, $matches)) === 0) {
                throw new InternalServerErrorException("Route was misformed : $routeJson->route");
            }

            //getting params for initiate route
            $action = explode("->", $routeJson->action);
            $method = isset($action[1]) ? $action[1] : "";
            $uriParameter = isset($matches[2]) ? $matches[2] : "";
            $fileToInclude = isset($routeJson->fileToInclude) ? $routeJson->fileToInclude : "";
            $getParameter = array();
            $postParameter = array();
            $methodHttp = "GET";
            $permission = isset($routeJson->permission) ? $routeJson->permission : array();

            //test if there is some get parameter declare in route
            if(isset($routeJson->method) && is_object($routeJson->method) 
                    && isset($routeJson->method->GET) && is_array($routeJson->method->GET)){
                $getParameter =  $routeJson->method->GET ;
            }
            
            //test if there is some post parameter declare in route, if some post parameter is found
            // it assumes that the route method is POST
            if(isset($routeJson->method) && is_object($routeJson->method) 
                    && isset($routeJson->method->POST) && is_array($routeJson->method->POST)){
                $postParameter = $routeJson->method->POST ;
                $methodHttp = "POST";
            }
            
            //test if at least a method is declare in route, otherwise the default will be GET
            if(isset($routeJson->method) && is_string($routeJson->method)){
                $methodHttp = $routeJson->method;
            }

            

            //initiate route
            $this->_routes[] = new Route($matches[0],$fileToInclude, $action[0], $method
                    , $permission, $uriParameter, $methodHttp, $getParameter, $postParameter);
        }
    }

    /**
     * Function for using the route corresponding to conf entry
     * */
    public function routeTo() {
        //find route in array routes
        $routeObject = array_shift(array_filter($this->_routes,array($this,"compare")));
        $routeQueried = explode("?", $_SERVER['REQUEST_URI']);
        
        //if not found throw exception
        if (is_null($routeObject) || !$routeObject instanceof Route) {
            throw new NotFoundException("Failed to find resource");
        } else {
            //otherwise called method build of the route
            $uriParameter = isset($routeQueried[1]) ? $routeQueried[1] : "";
            $routeObject->build($uriParameter);
        }
    }
    
    /**
     * function to see if a route is equal to an url and a method 
     * @param Route $route
     */
    private function compare($route){
        $method = $_SERVER['REQUEST_METHOD'];
        $routeQueried = explode("?", $_SERVER['REQUEST_URI']);
        return $route->equalsRoute($method, $routeQueried[0]);
    }

}
