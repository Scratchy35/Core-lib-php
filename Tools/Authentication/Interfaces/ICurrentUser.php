<?php
/**
 * Created by PhpStorm.
 * User: MIG19793
 * Date: 22/01/2016
 * Time: 11:25
 */

namespace Tools\Authentication;


interface ICurrentUser
{
    /**
     * @return array
     */
    public function getPermissions();

    /**
     * @return String
     */
    public function getLogin();


}