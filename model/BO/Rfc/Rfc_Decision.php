<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rfc_Decision
 *
 * @author CDB
 */
class Rfc_Decision extends Orm{
    
    protected $ID_RFC_DECISION;
    protected $ID_RFC;
    protected $SID_PERS;
    protected $ID_RFC_DECISION_TYPE;
    protected $ID_SOLUTION_RETENUE;
    protected $JUSTIFICATION;
    protected $PLANIFICATION;
    protected $PILOTE;
    protected $DT_DECISION;
    protected $DT_REALISATION_DEB;
    protected $DT_REALISATION_FIN;
    
    public function __construct() {
        parent::__construct();
        $this->addRelation(Orm::ONE_TO_ONE, array('column' => 'ID_RFC', 'foreignClass' => 'Rfc', 'foreignColumn' => 'ID_RFC'));
        $this->addRelation(Orm::ONE_TO_MANY, array('column' => 'SID_PERS', 'foreignClass' => 'Personnes', 'foreignColumn' => 'SID_PERS'));
        $this->addRelation(Orm::ONE_TO_ONE, array('column' => 'ID_RFC_DECISION_TYPE', 'foreignClass' => 'Rfc_Decision_Type', 'foreignColumn' => 'ID_RFC_DECISION_TYPE'));
        $this->addRelation(Orm::ONE_TO_ONE, array('column' => 'ID_SOLUTION_RETENUE', 'foreignClass' => 'Rfc_Solution', 'foreignColumn' => 'ID_SOLUTION_RETENUE'));
    }
}
