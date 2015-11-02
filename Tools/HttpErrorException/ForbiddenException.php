<?php
/**
 * Created by PhpStorm.
 * User: Scratchy
 * Date: 30/10/2015
 * Time: 17:43
 */

namespace Tools\HttpErrorException;


final class ForbiddenException extends HttpErrorException
{

    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        $this->errorCode = 403;
        parent::__construct($message,$code,$previous);
    }
}