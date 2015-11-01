<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Facture_Pour
 *
 * @author CDB
 */
class Facture_Pour extends Orm{
    
    public function __construct() {
        parent::__construct();
    }
    
    protected $ID_LOGICIEL;
    protected $ID_FACTURE;
}
