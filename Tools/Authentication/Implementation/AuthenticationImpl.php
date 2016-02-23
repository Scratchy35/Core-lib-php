<?php

/**
 * Created by PhpStorm.
 * User: MIG19793
 * Date: 22/01/2016
 * Time: 11:15
 */

namespace Tools\Authentication\Implementation;

use Tools\Authentication\Interfaces\IAuthentication;
use Tools\Authentication\Interfaces\ICurrentUser;
use Tools\Exceptions\HttpErrorException\InternalServerErrorException;

class AuthenticationImpl implements IAuthentication {

    const PATH_JSON_CONF = "/Configuration/Authentication.json";

    private static $_instance;

    public static function _getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new AuthenticationImpl();
        }
        return self::$_instance;
    }

    private function __construct() {
        session_start();
    }

    /**
     * Function called for authenticate user
     * @return ICurrentUser
     */
    public function authenticate() {
        $currentUser = null;
        if (empty($_SESSION) || $_SESSION['user'] == null) {
            $currentUser = $this->connect();
        } else {
            $currentUser = $_SESSION['user'];
        }
        return $currentUser;
    }

    /**
     * Function called for connecting to db or ldap
     * @return ICurrentUser ;
     * @throws InternalServerErrorException
     */
    private function connect() {
        //reading of configuration json
        $json = file_get_contents(getcwd() . self::PATH_JSON_CONF);
        $confObject = json_decode($json);
        if (is_null($confObject)) {
            throw new InternalServerErrorException("The file " . self::PATH_JSON_CONF . " can't be convert, it's a not a valid JSON");
        }

        //Start connection to ldap
        $connection = ldap_connect($confObject->ldapHost, $confObject->ldapPort);
        if (!$connection) {
            throw new InternalServerErrorException("Failed to connect to LDAP at $confObject->ldapHost:$confObject->ldapPort");
        }

        //Binding
        ldap_bind($connection, $confObject->ldapRdn, $confObject->ldapPass);

        //setting user
        //$userTrigramme = array_shift(explode('\\', $_SERVER['REMOTE_USER']));
        $userTrigramme = 'mig19793';
        $ldapFilter = sprintf($confObject->ldapFilter, $userTrigramme);
        $search = ldap_search($connection, $confObject->ldapBasedn, $ldapFilter);
        $entries = ldap_get_entries($connection, $search);
        $user = $entries[0];
        ldap_close($connection);
        return $this->setUser($user);
    }

    /**
     * Function called to setting the user singleton
     * @return ICurrentUser
     */
    private function setUser($userLdap) {
        $usr = CurrentUserImpl::_getInstance();
        $usr->setLogin($userLdap["cn"]["0"]);
        $usr->setTrigramme($userLdap["samaccountname"][0]);

        $_SESSION['user'] = $usr;
        $_SESSION['login'] = $usr->getLogin();
        $_SESSION['iguazu'] = "connected";
        $_SESSION['access'] = "rw";
        $_SESSION['TRIGRAMME'] = $usr->getTrigramme();
        return $usr;
    }

}
