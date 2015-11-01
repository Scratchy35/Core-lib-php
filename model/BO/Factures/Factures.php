<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Factures
 *
 * @author CDB
 */
class Factures extends Orm{
    
    public function __construct() {
        parent::__construct();
        $this->addRelation(Orm::MANY_TO_MANY, array('column' => 'ID_FACTURE', 'foreignClass' => 'Logiciel', 'foreignColumn' => 'ID_LOGICIEL', 'relationClass' => 'Facture_Pour'));
        $this->addRelation(Orm::ONE_TO_MANY, array('column' => 'SID_PERS', 'foreignClass' => 'Personnes', 'foreignColumn' => 'SID_PERS'));
    }
    
    protected $ID_FACTURE;
    protected $SID_PERS;
    protected $DESCRIPTION;
    protected $DATE_SIGNATURE;
    protected $PRIX;
}
