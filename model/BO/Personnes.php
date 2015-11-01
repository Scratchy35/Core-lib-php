<?php
/**
 * Description of Personnes
 *
 * @author CDB
 */
class Personnes extends Orm {

  protected $SID_PERS;
  protected $ID_ENTREPRISES;
  protected $TRIGRAMME;
  protected $SERVICE;
  protected $TELEPHONE;
  protected $EMAIL;
  protected $DTDRMAJAD;
  protected $DTSUPP;
  protected $PORTABLE;
  protected $TYPE;
  protected $FIRSTNAME;
  protected $LASTNAME;
  protected $ID_SITEENTREPRISE;

  public function __construct() {
    parent::__construct();
    $this->addRelation(Orm::MANY_TO_MANY, array('column' => 'SID_PERS', 'foreignClass' => 'Pages', 'foreignColumn' => 'ID_PAGE', 'relationClass' => 'Favoris'));
  }

}

?>