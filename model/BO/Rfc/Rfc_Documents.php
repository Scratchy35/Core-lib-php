<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rfc_Documents
 *
 * @author CDB
 */
class Rfc_Documents extends Orm{
    protected $ID_RFC_DOCUMENTS;
    protected $TYPE;
    protected $URL;
    
    public function __construct() {
        parent::__construct();
    }
}
