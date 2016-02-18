<?php
/**
 * Created by PhpStorm.
 * User: MIG19793
 * Date: 22/01/2016
 * Time: 11:25
 */

namespace Tools\Authentication\Interfaces;


interface ICurrentUser
{
    /**
     * @return array
     */
    public function getPermissions();

    /**
     * @return string
     */
    public function getLogin();


    /**
     * @param $permissions
     * @return string
     */
    public function setPermissions($permissions);

    /**
     * @param string $login
     */
    public function setLogin($login);
}