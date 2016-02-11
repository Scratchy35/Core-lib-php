<?php
namespace Tools\Authentication\Interfaces;
/**
 * Created by PhpStorm.
 * User: MIG19793
 * Date: 21/01/2016
 * Time: 16:25
 */
interface IAuthentication
{
    /**
     * @return mixed
     */
    public function authenticate();

    /**
     * @return mixed
     */
    public function startSession();

    /**
     * @return boolean
     */
    public function sessionExist();

    /**
     */
    public function connect();

    /**
     */
    public function setUser();
}