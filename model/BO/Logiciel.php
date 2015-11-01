<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Logiciel
 *
 * @author CDB
 */
class Logiciel extends Orm{
  
  public function __construct() {
    parent::__construct();
    $this->addRelation(Orm::MANY_TO_MANY, array('column' => 'ID_LOGICIEL', 'foreignClass' => 'Factures', 'foreignColumn' => 'ID_FACTURE', 'relationClass' => 'Facture_Pour'));
  }
  
  protected $ID_LOGICIEL;
  protected $CD_NATLOG;
  protected $ID_ENTREPRISE;
  protected $NOM_LOGICIEL;
  protected $ABREGE_LOGICIEL;
  protected $DESCRIPTIF_LOGICIEL;
  protected $DEVELOPPEMENT_DSI;
  protected $DEPL_POSTE;
  protected $EDITEUR;
  protected $ICONE;
  protected $NAPD;
  protected $NB_UTILISATEURS;
  protected $ANNEEMOE;
  protected $OUTIL_DEV;
  protected $ORIGINE;
  protected $OSARCHI;
  protected $LINUX;
  protected $REPINSTALL;
  protected $DT_CR;
  protected $OP_CR;
  protected $DT_MAJ;
  protected $OP_MAJ;
  protected $DT_SUPP;
  protected $OP_SUPP;
  protected $Service_Name;
  protected $sensible;
  protected $LienDoc;
  protected $RepInstallGBR;
  protected $CODESA;
  protected $NOTES;
  protected $DATEMIG;
  protected $DATEDEL;
  protected $DATEMEP;
  protected $ID_PSICLASS;
  protected $ID_BAR;
  protected $SCHEMAARCHI;
  protected $ID_FAMILLE;
  protected $ID_GROUPEAPPLI;
  protected $PORTAILG2S;
  
}
