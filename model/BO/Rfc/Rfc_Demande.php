<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rfc_Demande
 *
 * @author CDB
 */
class Rfc_Demande extends Orm{
    
    public function __construct() {
        parent::__construct();
        $this->addRelation(Orm::ONE_TO_ONE, array('column' => 'ID_RFC', 'foreignClass' => 'Rfc', 'foreignColumn' => 'ID_RFC')) ;
        $this->addRelation(Orm::ONE_TO_MANY, array('column' => 'ID_RFC_URGENCE', 'foreignClass' => 'Rfc_Urgence_Demande', 'foreignColumn' => 'ID_RFC_URGENCE')) ;
    }
    
    protected $ID_RFC;
    protected $ID_RFC_URGENCE;
    protected $DESCRIPTION;
    protected $JUSTIFICATION;
}
