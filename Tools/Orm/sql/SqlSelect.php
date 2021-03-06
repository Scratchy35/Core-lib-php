<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Tools\Orm\sql;
use Tools\Orm\sql\SqlAbstract;
/**
 * Description of SqlSelect
 *
 * @author CDB
 */
class SqlSelect extends SqlAbstract{
  /**
  * @var string
  */
  private $from = '';
  /**
  * @var string
  */
  private $alias = '';
  /**
  * @var string
  */
  private $select = '';
  /**
  * @var array
  */
  private $where = array();
  /**
  * @var array
  */
  private $order = array();
  /**
  * @var int
  */
  private $limit;
  /**
  * @var int
  */
  private $offset;

  /**
  * @return SqlSelect
  */
  public function from($from, $alias = null)
  {
    if(!is_null($alias))
    {
      $alias = $this->alias . '.';
      $this->alias = $alias;
    }

    if(is_array($from))
    {
      $this->from = $alias . $from['table_name'];

      foreach($from['attr'] as $attr)
      {
        $this->select .= $alias . $attr;
      }
    }
    else
    {
      $this->from = $from;
    }

    $this->select = empty($this->select) ? '*' : $this->select;

    return $this;
  }

  public function where($condition){
      if($condition != null){
          $this->where =$condition;
      }
      return $this;
  }
  /**
  * @return SqlSelect
  */
//  public function where($attr, $value)
//  {
//    if(!empty($value))
//    {
//      $this->where[$attr] = $value;
//    }
//
//    return $this;
//  }

  /**
  * @return SqlSelect
  */
  public function orderBy($attr, $sens)
  {
    $this->order[$attr] = $sens;

    return $this;
  }

  /**
  * @return SqlSelect
  */
  public function limit($limit, $offset)
  {
    $this->limit = $limit;
    $this->offset = $offset;

    return $this;
  }

  /**
  * Termine la construction de la requête et la retourne.
  * @return string
  */
  protected function _build()
  {
    if(is_null($this->request))
    {
      $str = 'SELECT ';
      $str .= $this->select;
      $str .= ' FROM ';
      $str .= $this->from;
      $str .= ' ';

      $alias = '';
      if(!empty($this->alias))
      {
        $str .= ' AS ';
        $str .= $this->alias;

        $alias .= $this->alias . '.';
      }

      if($this->where != null)
      {
        $str .= ' WHERE ';
        
        $sqlCondWhere = $this->where;
        
        $where = $sqlCondWhere->build();
        
        $this->parameters = $sqlCondWhere->getValue();
//        foreach($this->where as $attr => $value)
//        {
//          if(!empty($value))
//          {
//            if($where != '')
//            {
//              $where .= ' AND ';
//            }
//
//            $where .= $alias . $attr . '?';
//            $this->parameters[] = $value;
//          }
//        }
        $str .= $where;
      }

      if(count($this->order) > 0)
      {
        $str .= ' ORDER BY ';

        $order = '';
        foreach($this->order as $attr => $sens)
        {
          if($order != '')
          {
            $order .= ',';
          }

          $order .= $alias . $attr . ' ' . $sens;
        }

        $str .= $order;
      }

      if(isset($this->limit))
      {
        //$str .= ' LIMIT ' . $this->limit . ', ' . $this->offset;
      }
      
      $this->request = $str;
    }
  }
}
