<?php

namespace Tools\Authentication\Implementation;

use Tools\Authentication\Entity\Permissions;
use Tools\Authentication\Entity\Groupes;
use Tools\Orm\FactoryConnection;
use Tools\Authentication\Entity\Utilisateurs;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PermissionsMgt
 *
 * @author CDB
 */
class PermissionsMgt {

    private static $_instance;
    private $permissions;

    public function getPermissions() {
        return $this->permissions;
    }

    /**
     * 
     * @return PermissionsMgt
     */
    public static function getInstance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new PermissionsMgt();
        }
        return self::$_instance;
    }

    private function __construct() {
        FactoryConnection::getPdo('IGUAZU-BACKOFFICE');

        foreach (Permissions::find() as $permission) {
            $this->permissions[$permission->getLIBELLE()] = $permission->getMASQUE_BINAIRE();
        }
    }

    public function getLibPermissions() {
        return array_keys($this->permissions);
    }

    /**
     * 
     * @param int $userMask 
     * @param string[]|string $permissions 
     * @return boolean
     */
    private function comparePermission($userMask, $permissions) {
        $result = false;
        if (is_array($permissions)) {
            foreach ($permissions as $permission) {
                if (isset($this->permissions[$permission])) {
                    $result = $this->testPermission($this->permissions[$permission], $userMask) ? true : $result;
                }
                if(empty($permission)){
                    $result = true;
                }
            }
        } else {
            $result = $this->testPermission($this->permissions[$permissions], $userMask);
        }
        return $result;
    }

    private function testPermission($perms, $userMask) {
        return (int) $perms & (int) $userMask;
    }

    /**
     * Function to see if the current user have the right to access to something
     * @param string[]|string $permission either array of permissions names or just the name of a permission
     * @return boolean if true, user have the rights else user don't have the rights
     */
    public function canAccess($permission) {
        return $this->comparePermission(CurrentUserImpl::_getInstance()->getPermissions(), $permission);
    }

    /**
     * 
     * @param type $nameGrp
     */
    public function deleteGrp($nameGrp) {
        FactoryConnection::getPdo('IGUAZU-BACKOFFICE');
        $grp = Groupes::findOneByNOM($nameGrp);
        //on supprime le lien utilisateurs groupe avant la suprression du groupe
        if (count($users = $grp->getUtilisateurs()) != 0) {
            array_walk($users, function($user, $key) {
                $user->setID_GROUPES(null);
                $user->save();
            });
        }
        $grp->delete();
    }

    /**
     * 
     * @return type
     */
    public function getTablePermission() {
        FactoryConnection::getPdo('IGUAZU-BACKOFFICE');
        $groupes = Groupes::find();
        foreach ($groupes as $groupe) {
            $tabMask = $this->buildTablePerms($groupe->getMASQUE_BINAIRE());
            $tabGrp[$groupe->getNOM()] = $tabMask;
        }
        return $tabGrp;
    }

    /**
     * 
     * @param type $idGrp
     * @return type
     */
    public function getGrp($nomGrp) {
        FactoryConnection::getPdo('IGUAZU-BACKOFFICE');
        return Groupes::findOneByNOM($nomGrp);
    }

    public function getGrpFromUser($trigramme) {
        FactoryConnection::getPdo('IGUAZU-BACKOFFICE');
        $user = Utilisateurs::findOneByTRIGRAMME($trigramme);
        return $user->getGroupes();
    }

    public function getUsersFromGrp($nameGrp) {
        FactoryConnection::getPdo('IGUAZU-BACKOFFICE');
        $grp = Groupes::findOneByNOM($nameGrp);
        $users = $grp->getUtilisateurs();
        $usersGrp = array();
        \Tools\Orm\FactoryConnection::getPdo('TIBIA');
        foreach ($users as $user) {
            $usersGrp[$user->getTRIGRAMME()] = \Personnes::findOneByTRIGRAMME($user->getTRIGRAMME());
        }
        return $usersGrp;
    }

    /**
     * 
     * @param int $mask
     * @return boolean[]
     */
    public function buildTablePerms($mask) {
        foreach ($this->permissions as $key => $perms) {
            // On examine le bit le plus à droite (1 est le masque correspondant au bit le plus à droite).
            if ($mask & 1) {
                $tabMask[$key] = true;
            } else {
                $tabMask[$key] = false;
            }
            // On passe au bit suivant des Options par un décalage à droite d'un bit.
            $mask >>= 1;
        }
        return $tabMask;
    }

    /**
     * Permet l'insertion d'un groupe avec les personnes lié
     * @param string $nomGrp 
     * @param type $perms
     * @param type $trigrammes
     */
    public function addGroupe($nomGrp, $perms, $groupe_ad, $trigrammes) {
        $droit = 0;
        foreach ($perms as $perm) {
            $droit |= (int) $this->permissions[$perm];
        }
        $grp = Groupes::findOneByNOM($nomGrp);
        if (!isset($grp)) {
            $grp = new Groupes();
        } else {
            $users = $grp->getUtilisateurs();
        }

        $grp->setNOM($nomGrp);
        $grp->setMASQUE_BINAIRE($droit);
        $grp->setGROUPE_AD($groupe_ad);

        foreach ($trigrammes as $trigramme) {
            $this->setPersonneGrp($trigramme, $grp);
        }
        $grp->save();
        array_walk($users, function($user, $key, $trigrammes) {
            if (!in_array($user->getTRIGRAMME(), $trigrammes)) {
                $user->setID_GROUPES(null);
                $user->save();
            }
        }, $trigrammes);
    }

    /**
     * 
     * @param type $trigramme
     * @param type $grp
     */
    private function setPersonneGrp($trigramme, $grp) {
        $user = Utilisateurs::findOneByTrigramme($trigramme);
        if ($user == null) {
            $user = new Utilisateurs();
            $user->setTRIGRAMME($trigramme);
        }
        $grp->setUtilisateurs($user);
    }

    /**
     * 
     * @param type $trigramme
     * @param type $grp
     */
    public function addUser($trigramme, $grp) {
        $user = Utilisateurs::findOneByTrigramme($trigramme);
        if ($user == null) {
            $user = new Utilisateurs();
            $user->setTRIGRAMME($trigramme);
        }
        $grp = Groupes::findOneByNOM($grp);
        if ($grp != null) {
            $user->setID_GROUPES($grp->getID_GROUPES());
        } else {
            $user->setID_GROUPES(null);
        }
        $user->save();
    }

    public function getUsers() {
        $users = Utilisateurs::find();
        $trigrammesGrp = array();
        array_walk($users, function($user, $index, &$res) {
            $grp = $user->getGroupes();
            if ($grp != null) {
                $res[$user->getTRIGRAMME()] = $grp->getNOM();
            } else {
                $res[$user->getTRIGRAMME()] = "";
            }
        }, &$trigrammesGrp);

        $sqlInCond = \SqlCondition::_in("TRIGRAMME", array_keys($trigrammesGrp));
        FactoryConnection::getPdo("TIBIA");
        $personnes = \Personnes::find($sqlInCond);

        $toReturn = array();
        foreach ($personnes as $personne) {
            $tri = $personne->getTRIGRAMME();
            $groupe = $trigrammesGrp[$tri];
            $firstname = $personne->getFIRSTNAME();
            $lastname = $personne->getLASTNAME();
            $toReturn[] = array("trigramme" => $tri, "groupe" => $groupe, "firstname" => $firstname, "lastname" => $lastname);
        }
        return $toReturn;
    }

}
