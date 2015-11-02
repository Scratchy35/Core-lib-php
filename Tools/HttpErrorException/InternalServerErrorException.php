<?php
/**
 * Created by PhpStorm.
 * User: Scratchy
 * Date: 30/10/2015
 * Time: 18:01
 */

namespace Tools\HttpErrorException;


class InternalServerErrorException extends HttpErrorException
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        $this->errorCode =  500;
        parent::__construct($message,$code,$previous);
    }
}