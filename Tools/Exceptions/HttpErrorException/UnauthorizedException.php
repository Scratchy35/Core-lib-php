<?php
/**
 * Created by PhpStorm.
 * User: Scratchy
 * Date: 30/10/2015
 * Time: 17:43
 */

namespace Tools\Exceptions\HttpErrorException;


final class UnauthorizedException extends HttpErrorException
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        $this->errorCode =  401;
        parent::__construct($message,$code,$previous);
    }
}