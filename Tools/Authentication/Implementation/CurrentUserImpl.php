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

class CurrentUserImpl implements ICurrentUser {

    private static $_instance;
    private $login;
    private $access;
    private $trigramme;
    private $permissions;
    private $memberof;
    private $grp;

    public function getGrp(){
        return $this->grp;
    }
    
    /**
     * @return String
     */
    public function getLogin() {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getAccess() {
        return $this->access;
    }

    /**
     * @return string
     */
    public function getTrigramme() {
        return $this->trigramme;
    }

    /**
     * @return array
     */
    public function getPermissions() {
        return $this->permissions;
    }

    /**
     * @param string $login
     */
    public function setLogin($login) {
        $this->login = $login;
    }

    /**
     * @param string $access
     */
    public function setAccess($access) {
        $this->access = $access;
    }

    /**
     * @param string $trigramme
     */
    public function setTrigramme($trigramme) {
        $this->trigramme = $trigramme;
    }

    /**
     * 
     * @param string[] $memberof
     */
    public function setMemberof($memberof) {
        foreach($memberof as $member){
            $temp = explode(',',$member);
            $this->memberof[] = utf8_encode(str_replace("CN=","", $temp[0]));
        }
    }

    /**
     * 
     * @return CurrentUserImpl
     */
    public static function _getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new CurrentUserImpl();
        }
        return self::$_instance;
    }

    private function __construct() {
        
    }

    public function loadGrpPermission() {
        FactoryConnection::getPdo("IGUAZU-BACKOFFICE");

        $user = Utilisateurs::findOneByTRIGRAMME($this->trigramme);
        if ($user == null) {
            try{
            $grp = $this->initUserGrpFromAd();
            } catch (UserDontExistException $ex){
                throw new \Tools\Exceptions\HttpErrorException\ForbiddenException("Vous n'êtes pas autorisé à accèder a Iguazu");
            }
            
        }else{
            $grp = $user->getGroupes();
        }
        if($grp == null){
            throw new \Tools\Exceptions\HttpErrorException\ForbiddenException("Vous n'êtes pas autorisé à accèder a Iguazu");
        }
        $this->grp = $grp->getNOM();
        $this->permissions = $grp->getMASQUE_BINAIRE();
    }
    
    private function initUserGrpFromAd(){
        FactoryConnection::getPdo("IGUAZU-BACKOFFICE");
        $criteria = \SqlCondition::_in("GROUPE_AD", $this->memberof);
        $grp = Groupes::findOne($criteria);
        if($grp != null){
            $user = new Utilisateurs();
            $user->setTRIGRAMME($this->trigramme);
            $grp->setUtilisateurs($user);
            $grp->save();
        } else {
            throw new UserDontExistException("Failed to find user in database");
        }
        return $grp;        
    }

}
