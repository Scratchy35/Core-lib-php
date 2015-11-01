<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rfc_Bilan
 *
 * @author CDB
 */
class Rfc_Bilan extends Orm{
    
    protected $ID_RFC_BILAN;
    protected $ID_RFC;
    protected $ATTEINT;
    protected $ANALYSE;
    protected $CAPITALISATION;
    
    public function __construct() {
        parent::__construct();
        $this->addRelation(Orm::ONE_TO_ONE, array('column' => 'SID_PERS', 'foreignClass' => 'Personnes', 'foreignColumn' => 'SID_PERS'));
    }
}
