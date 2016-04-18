<?php
/**
 * Created by PhpStorm.
 * User: Scratchy
 * Date: 30/10/2015
 * Time: 17:15
 */

namespace Tools\Exceptions\HttpErrorException;

abstract class HttpErrorException extends \Exception
{
    protected $errorCode;

    /**
     * @return int
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message,$code,$previous);
    }

    public function changeCodeError()
    {
        if(function_exists('http_response_code')){
            http_response_code($this->errorCode);
        }
        else{
            header("HTTP/1.0 $this->errorCode");
        }

    }
}