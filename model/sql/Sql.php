<?php

include_once 'SqlSelect.php';
include_once 'SqlDelete.php';
include_once 'SqlUpdate.php';
include_once 'SqlInsert.php';
/**
 * Classe Sql.
 * Cette classe représente la couche SQL de la DAL.
 *
 * @author CDB
 */
abstract class Sql {

  public function sqlSelect() {
    return new SqlSelect();
  }

  /**
   * @return SqlUpdate
   */
  public function sqlUpdate() {
    return new SqlUpdate();
  }

  /**
   * @return SqlDelete
   */
  public function sqlDelete() {
    return new SqlDelete();
  }

  /**
   * @return SqlInsert
   */
  public function sqlInsert() {
    return new SqlInsert();
  }

}
