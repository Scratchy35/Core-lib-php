<?php
/**
 * Created by PhpStorm.
 * User: Scratchy
 * Date: 30/10/2015
 * Time: 17:42
 */

namespace Tools\HttpErrorException;


final class NotFoundException extends HttpErrorException
{

    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        $this->errorCode = 404;
        parent::__construct($message,$code,$previous);
    }
}