<?php

include_once 'SqlAbstract.php';

/**
 * Description of SqlInsert
 *
 * @author CDB
 */
class SqlInsert extends SqlAbstract {

  /**
   * @var string
   */
  private $into;

  /**
   * @var array
   */
  private $values = array();

  /**
   * @param string $table_name
   * @return SqlInsert
   */
  public function into($table_name) {
    $this->into = $table_name;

    return $this;
  }

  /**
   * @param string $attr
   * @param string $value
   */
  public function addValue($attr, $value) {
    if (!empty($value)) {
      $this->values[$attr] = $value;
    }
    return $this;
  }

  /**
   * Termine la construction de la requête et la retourne.
   * @return string
   */
  protected function _build() {
    if (is_null($this->request)) {
      $str = 'INSERT INTO ';
      $str .= $this->into;

      $nameValues = array();
      $parameters = '';
      foreach ($this->values as $attr => $values) {
        if (!empty($values)) {
          $nameValues[] = $attr;
          $this->parameters[] = $values;
          $parameters[] = '?';
        }
      }
     
      if (!empty($nameValues) && !empty($parameters)) {
        $str .= ' (' . implode(',', $nameValues) . ') ';
        $str .= 'VALUES (';
        $str .= implode(',', $parameters) . ')';
      }

      $this->request = $str;
    }
  }

}
