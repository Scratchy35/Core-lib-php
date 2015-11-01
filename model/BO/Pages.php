<?php

/**
 * Description of Pages
 *
 * @author CDB
 */
class Pages extends Orm {

  public function __construct() {
    parent::__construct();
    $this->addRelation(Orm::MANY_TO_MANY, array('column' => 'ID_PAGE', 'foreignClass' => 'Personnes', 'foreignColumn' => 'SID_PERS', 'relationClass' => 'Favoris'));
  }

  protected $ID_PAGE;
  protected $URL;
  protected $LIBELLE;
  private $image;

  public function getImage() {
    return $this->image;
  }

  public function setImage($image) {
    $this->image = $image;
  }

}
