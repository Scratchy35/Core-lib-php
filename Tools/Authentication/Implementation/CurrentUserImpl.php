<?php
/**
 * Created by PhpStorm.
 * User: MIG19793
 * Date: 22/01/2016
 * Time: 11:28
 */

namespace Tools\Authentication\Implementation;

use Tools\Authentication\Interfaces\ICurrentUser;


class CurrentUserImpl implements ICurrentUser
{
    private static $_instance;

    private $login;
    private $access;
    private $trigramme;
    private $permissions;

    /**
     * @return String
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * @return string
     */
    public function getTrigramme()
    {
        return $this->trigramme;
    }

    /**
     * @return array
     */
    public function getPermissions()
    {
        // TODO: Implement getPermissions() method.
    }

    /**
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @param string $access
     */
    public function setAccess($access)
    {
        $this->access = $access;
    }

    /**
     * @param string $trigramme
     */
    public function setTrigramme($trigramme)
    {
        $this->trigramme = $trigramme;
    }

    public function setPermissions($permissions)
    {
        // TODO: Implement setPermissions() method.
    }

    public static function _getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new CurrentUserImpl();
        }
        return self::$_instance;
    }



    private function __construct()
    {
    }

}