<?php
namespace Tools\Orm\sql;
/**
 *
 * @author CDB
 */
abstract class SqlAbstract {
  /**
  * @var string
  */
  protected $request = null;
  /**
  * @var array
  */
  protected $parameters = array();

  /**
  * @return string
  */
  public function getRequest()
  {
    $this->_build();

    return $this->request;
  }

  /**
  * @return array
  */
  public function getParameters()
  {
    $this->_build();
    
    return $this->parameters;
  }

  /**
  * Termine la construction de la requête et la retourne.
  * @return string
  */
  protected abstract function _build();
}
