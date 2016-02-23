<?php
namespace Tools\Authentication\Entity;
use Tools\Orm\orm\Orm;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Permissions
 *
 * @author CDB
 */
class Permissions extends Orm{
    protected $ID_PERMISSIONS;
    protected $LIBELLE;
    protected $MASQUE_BINAIRE;
    
    public function __construct() {
        parent::__construct();
    }
}
