<?php
/**
 * Created by PhpStorm.
 * User: MIG19793
 * Date: 22/01/2016
 * Time: 11:28
 */

namespace Tools\Authentication;


class CurrentUserImpl implements ICurrentUser
{
    private static $_instance;

    private function __construct()
    {
    }

    public static function _getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new CurrentUserImpl();
        }
        return self::$_instance;
    }

    /**
     * @return array
     */
    public function getPermissions()
    {
        // TODO: Implement getPermissions() method.
    }

    /**
     * @return String
     */
    public function getLogin()
    {
        // TODO: Implement getLogin() method.
    }
}