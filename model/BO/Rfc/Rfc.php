<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rfc
 *
 * @author CDB
 */
class Rfc extends Orm {

    public function __construct() {
        parent::__construct();
        $this->addRelation(Orm::ONE_TO_MANY, array('column' => 'SID_PERS', 'foreignClass' => 'Personnes', 'foreignColumn' => 'SID_PERS'));
        $this->addRelation(Orm::ONE_TO_MANY, array('column' => 'ID_RFC_TYPOLOGIE', 'foreignClass' => 'Rfc_Typologie', 'foreignColumn' => 'ID_RFC_TYPOLOGIE'));
        $this->addRelation(Orm::ONE_TO_MANY, array('column' => 'ID_RFC_ETAPE', 'foreignClass' => 'Rfc_Etape', 'foreignColumn' => 'ID_RFC_ETAPE'));
        $this->addRelation(Orm::ONE_TO_MANY, array('column' => 'ID_LOGICIEL', 'foreignClass' => 'Logiciel', 'foreignColumn' => 'ID_LOGICIEL'));
        
        $this->addRelation(Orm::ONE_TO_ONE, array('column' => 'ID_RFC', 'foreignClass' => 'Rfc_Demande', 'foreignColumn' => 'ID_RFC')) ;
        $this->addRelation(Orm::ONE_TO_ONE, array('column' => 'ID_RFC', 'foreignClass' => 'Rfc_Decision', 'foreignColumn' => 'ID_RFC'));
        $this->addRelation(Orm::ONE_TO_ONE, array('column' => 'ID_RFC', 'foreignClass' => 'Rfc_Bilan', 'foreignColumn' => 'ID_RFC'));
        $this->addRelation(Orm::ONE_TO_MANY, array('column' => 'ID_RFC', 'foreignClass' => 'Rfc_Solution', 'foreignColumn' => 'ID_RFC'));
    }

    protected $ID_RFC;
    protected $ID_RFC_TYPOLOGIE;
    protected $ID_RFC_ETAPE;
    protected $ID_LOGICIEL;
    protected $SID_PERS;
    protected $REF_RFC;
    protected $TITRE;
    protected $REF_SERVICECENTER;
    protected $REF_DIIP;

}
