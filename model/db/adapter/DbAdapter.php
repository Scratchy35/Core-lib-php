<?php
/**
 * Interface DbAdapter
 * Décrit les méthodes nécessaires à la communication avec une DataBase.
 * Cette interface définit la DAL.
 *
 * @author CDB
 */
interface DbAdapter {
  
  /**
  * Exécute une requête.
  * @param string $query
  */
  public function exec($query);
  /**
  * Interroge la base de données.
  */
  public function query($query);
  /**
  * Retourne une description de la table de base de données spécifiée.
  * @param string $table_name
  * @return array
  */
  public function describeTable($table_name);
  
}
