<?php
namespace Tools\Authentication\Implementation;
use Tools\Authentication\Entity\Permissions;
use Tools\Orm\FactoryConnection;
use Tools\Orm\db\Db;
use Tools\Orm\orm\Orm;
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

    public static function getInstance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new PermissionsMgt();
        }
        return self::$_instance;
    }

    private function __construct() {
        $this->pdo = FactoryConnection::getPdo('IGUAZU-BACKOFFICE');
        $db = new Db($this->pdo);
        Orm::setDataSource($db);
        foreach (Permissions::find() as $permission){
            $this->permissions[$permission->getLIBELLE()] = $permission->getMASQUE_BINAIRE();
        }        
    }
    
    /**
     * 
     * @param $userMask int
     * @param $routePermissions string[]
     * @return boolean
     */
    public function comparePermission($userMask,$routePermissions){
        $result = false;
        
        foreach($routePermissions as $permission){
            $perms = $this->permissions[$permission];
            if((int)$perms & (int)$userMask){
                $result = true;
            } 
        }
        return true;
    }
}
