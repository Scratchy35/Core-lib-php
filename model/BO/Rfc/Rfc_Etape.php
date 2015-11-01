<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rfc_Etape
 *
 * @author CDB
 */
class Rfc_Etape extends Orm{
    protected $ID_RFC_ETAPE;
    protected $LIB_RFC_ETAPE;
    
    public function __construct() {
        parent::__construct();
    }
}
