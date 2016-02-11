<?php
namespace Tools\Authentication;
/**
 * Created by PhpStorm.
 * User: MIG19793
 * Date: 21/01/2016
 * Time: 16:25
 */
interface IAuthentication
{
    /**
     * Function called for authenticate user
     */
    public function authenticate();

    /**
     * Function called for create user session
     */
    public function createSession();

    /**
     * Function called for starting user session
     */
    public function startSession();

    /**
     * Function for testing if a user have a session on the server
     * @return boolean
     */
    public function sessionExist();

    /**
     * Function called for connecting to db or ldap
     */
    public function connect();

    /**
     * Function called to setting the user singleton
     */
    public function setUser();
}