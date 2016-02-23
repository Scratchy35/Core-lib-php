<?php
namespace Tools\Authentication\Entity;
use Tools\Orm\orm\Orm;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utilisateurs
 *
 * @author CDB
 */
class Utilisateurs extends Orm{
    protected $TRIGRAMME;
    protected $ID_GROUPES;
    
    public function __construct() {
        parent::__construct();
        $this->addRelation(Orm::MANY_TO_ONE, array('column' => 'ID_GROUPES', 'foreignClass' => 'Tools\Authentication\Entity\Groupes', 'foreignColumn' => 'ID_GROUPES'));
    }
}
