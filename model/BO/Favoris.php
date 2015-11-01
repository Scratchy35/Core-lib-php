<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Favoris
 *
 * @author CDB
 */
class Favoris extends Orm{
  
  protected $SID_PERS;
  protected $ID_PAGE;
    
  public function __construct() {
    parent::__construct();
  }
}
