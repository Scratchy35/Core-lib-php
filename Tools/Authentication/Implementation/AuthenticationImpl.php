<?php
/**
 * Created by PhpStorm.
 * User: MIG19793
 * Date: 22/01/2016
 * Time: 11:15
 */

namespace Tools\Authentication;


class AuthenticationImpl implements IAuthentication
{

    /**
     * Function called for authenticate user
     */
    public function authenticate()
    {
        if($this->sessionExist()) {
            $this->startSession();
            $this->setUser();
        }
        else{
            $this->connect();
            $this->setUser();
        }
    }

    /**
     * Function called for starting user session
     */
    public function createSession()
    {
        // TODO: Implement startSession() method.
    }

    /**
     * Function for testing if a user have a session on the server
     * @return boolean
     */
    public function sessionExist()
    {
        // TODO: Implement sessionExist() method.
        return true;
    }

    /**
     * Function called for connecting to db or ldap
     */
    public function connect()
    {
        // TODO: Implement connect() method.
    }

    /**
     * Function called to setting the user singleton
     */
    public function setUser()
    {

    }

    /**
     * Function called for starting user session
     */
    public function startSession()
    {
        // TODO: Implement startSession() method.
    }
}