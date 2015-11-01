<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rfc_Solution
 *
 * @author CDB
 */
class Rfc_Solution extends Orm{
    protected $ID_SOLUTION;
    protected $SID_PERS;
    protected $ID_SOLUTION_TYPE;
    protected $ID_RFC;
    protected $DESCRIPTION;
    protected $IMPACTS_RISQUES;
    protected $IMPACTS_SECURITE;
    protected $RETOUR_ARRIERE;
    protected $PRESTATION_JH;
    protected $COUT;
    protected $PLANIFICATION;
    protected $EXIGENCES;
    
    public function __construct() {
        parent::__construct();
        $this->addRelation(Orm::ONE_TO_MANY, array('column' => 'ID_SOLUTION_TYPE', 'foreignClass' => 'Rfc_Solution', 'foreignColumn' => 'ID_SOLUTION_TYPE'));
        $this->addRelation(Orm::ONE_TO_MANY, array('column' => 'SID_PERS', 'foreignClass' => 'Personnes', 'foreignColumn' => 'SID_PERS'));
        $this->addRelation(Orm::ONE_TO_ONE, array('column' => 'ID_RFC', 'foreignClass' => 'Rfc', 'foreignColumn' => 'ID_RFC'));
        
    }
}
