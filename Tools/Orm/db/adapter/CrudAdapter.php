<?php
namespace Tools\Orm\db\adapter;
/**
 * Description of CrudAdapter
 *
 * @author CDB
 */
interface CrudAdapter {

  /**
   * Create a new object
   * @param object $object
   */
  public function create($object);

  /**
   * Read an object
   * @param object $object
   */
  public function read($object);

  /**
   * Update an object
   * @param object $object
   */
  public function update($object);

  /**
   * Delete an object
   * @param object $object
   */
  public function delete($object);
}
