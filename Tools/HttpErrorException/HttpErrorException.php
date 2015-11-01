<?php
/**
 * Created by PhpStorm.
 * User: Scratchy
 * Date: 30/10/2015
 * Time: 17:15
 */

namespace Tools\HttpErrorException;

abstract class HttpErrorException extends \Exception
{
    protected $errorCode;

    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message,$code,$previous);
        $this->changeCodeError();
    }

    protected function changeCodeError()
    {
        http_response_code($this->errorCode);

    }
}