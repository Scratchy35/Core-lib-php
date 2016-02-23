<?php
/**
 * Created by PhpStorm.
 * User: MIG19793
 * Date: 22/01/2016
 * Time: 11:28
 */


namespace Tools\Authentication\Implementation;


use Tools\Authentication\Interfaces\ICurrentUser;
use Tools\Authentication\Entity\Groupes;
use Tools\Authentication\Entity\Utilisateurs;
use Tools\Orm\FactoryConnection;
use Tools\Orm\db\Db;
use Tools\Orm\orm\Orm;
use Tools\Orm\pdo\PdoCustom;
use Tools\Exceptions\AuthenticationException\UserDontExistException;

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
        if(is_null($this->permissions)){
            $this->permissions = $this->getGrpPermission();
        }
        return $this->permissions;
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

    /**
     * 
     * @return CurrentUserImpl
     */
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
    
    private function getGrpPermission(){
        $pdo = FactoryConnection::getPdo("IGUAZU-BACKOFFICE");
        $db = new Db($pdo);
        Orm::setDataSource($db);
        $user = Utilisateurs::findOneByTRIGRAMME($this->trigramme);
        if(!isset($user)){
            throw new UserDontExistException();
        }
        $mask = $user->getGroupes()->getMASQUE_BINAIRE();
        return $mask;
    }

}