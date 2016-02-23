<?php
namespace Tools\Orm\db\adapter;
/**
 * Interface DataSourceAdapter
 * Décrit les méthodes nécessaires à une DataSource.
 *
 * @author CDB
 */
interface DataSourceAdapter {

  /**
   * Retourne le nombre d'objets comptés.
   * @param object $object
   * @param array $criteria
   * @return integer
   */
  public function count($object, $criteria = array());

  /**
   * Retourne un tableau d'objets.
   * @param object $object
   * @param array $criteria
   * @param array $order
   * @param integer $limit
   * @param integer $offset
   * @return array
   */
  public function find($object, $criteria = array(), $order = null, $limit = null, $offset = null);
}
