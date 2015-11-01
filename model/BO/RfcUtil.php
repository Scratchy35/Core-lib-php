<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RfcUtil
 *
 * @author CDB
 */
class RfcUtil {
    private $rfc;
    private $rfcDemande;
    private $rfcSolutions;
    private $rfcDecision;
    private $rfcBilan;
    
    public function __construct() {
        $this->rfc = new Rfc();
        $this->rfcDemande = new Rfc_Demande();
        $this->rfcSolutions = new rfcSolutions();
        $this->rfcDecision = new Rfc_Decision();
        $this->rfcBilan = new Rfc_Bilan;
    }
}
