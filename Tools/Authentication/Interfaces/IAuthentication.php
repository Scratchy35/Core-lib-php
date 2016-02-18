<?php
namespace Tools\Authentication\Interfaces;
/**
 * Created by PhpStorm.
 * User: MIG19793
 * Date: 21/01/2016
 * Time: 16:25
 */
/**
 * Interface IAuthentication
 * @package Tools\Authentication
 */
interface IAuthentication
{
    /**
     * Function called for authenticate user
     */
    public function authenticate();
}