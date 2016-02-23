<?php
namespace Tools\Orm\sql;

use Tools\Orm\sql\SqlSelect;
use Tools\Orm\sql\SqlDelete;
use Tools\Orm\sql\SqlUpdate;
use Tools\Orm\sql\SqlInsert;
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
