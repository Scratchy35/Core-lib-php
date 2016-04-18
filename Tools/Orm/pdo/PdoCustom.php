<?php

namespace Tools\Orm\pdo;
use PDO;
use Tools\Orm\db\adapter\DbAdapter;
use Tools\Orm\pdo\Statement;

/**
 * Classe Pdo
 *
 * Cette classe étend la classe PDO et implémente l'interface wDbAdapter.
 * C'est l'implémentation de la DAL.
 *
 * @author cdb
 */
class PdoCustom extends PDO implements DbAdapter {

  /**
   * Constructor.
   * Enables PDOExceptions
   * Initiates Statement
   *
   * @param string $dsn
   * @param string $username
   * @param string $password
   * @param array $driver_options
   */
  final public function __construct($dsn, $username = '', $password = '', $driver_options = array()) {
    parent::__construct($dsn, $username, $password, $driver_options);
    $this->setAttribute(self::ATTR_ERRMODE, self::ERRMODE_EXCEPTION);
    $this->setAttribute(self::ATTR_STATEMENT_CLASS, array('Tools\Orm\pdo\Statement'));
    Statement::setPDOInstance($this);
  }

  /**
   * Exécute une requête.
   * @param string $query
   */
  public function exec($query) {
    return parent::exec($query);
  }

  /**
   * Interroge la base de données.
   */
  public function query($query) {
    return parent::query($query);
  }

  /**
   * Retourne une description de la table de base de données spécifiée.
   * @param string $table_name
   * @return array
   */
  public function describeTable($table_name) {
    $request = "SELECT Col.Column_Name from 
    INFORMATION_SCHEMA.TABLE_CONSTRAINTS Tab, 
    INFORMATION_SCHEMA.CONSTRAINT_COLUMN_USAGE Col 
    WHERE 
    Col.Constraint_Name = Tab.Constraint_Name
    AND Col.Table_Name = Tab.Table_Name
    AND Constraint_Type = 'PRIMARY KEY'
    AND Col.Table_Name = '%s'";
    $sql = sprintf($request, $table_name);
    $statment = $this->prepare($sql);

    $statment->execute();

    return $statment->fetchAll(\Pdo::FETCH_ASSOC);
  }

}
