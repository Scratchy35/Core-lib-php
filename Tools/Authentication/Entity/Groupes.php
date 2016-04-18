<?php
namespace Tools\Authentication\Entity;
use Tools\Orm\orm\Orm;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Groupes
 *
 * @author CDB
 */
class Groupes extends Orm{
    protected $ID_GROUPES;
    protected $NOM;
    protected $MASQUE_BINAIRE;
    protected $GROUPE_AD;
    
    public function __construct() {
        parent::__construct();
        $this->addRelation(Orm::ONE_TO_MANY, array('column' => 'ID_GROUPES', 'foreignClass' => 'Tools\Authentication\Entity\Utilisateurs', 'foreignColumn' => 'ID_GROUPES'));
    }
}
