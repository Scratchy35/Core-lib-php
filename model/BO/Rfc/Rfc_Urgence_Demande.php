<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rfc_Urgence_Demande
 *
 * @author CDB
 */
class Rfc_Urgence_Demande extends Orm{
    protected $ID_RFC_URGENCE;
    protected $LIB_RFC_URGENCE;
    
    public function __construct() {
        parent::__construct();
    }
}
