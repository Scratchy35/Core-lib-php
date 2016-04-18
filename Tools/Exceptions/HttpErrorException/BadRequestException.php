<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tools\Exceptions\HttpErrorException;

/**
 * Description of BadRequestException
 *
 * @author CDB
 */
class BadRequestException extends HttpErrorException{
    
    public function __construct($message = "", $code = 0, Exception $previous = null) {
        $this->errorCode = 400;
        parent::__construct($message, $code, $previous);
    }
}
