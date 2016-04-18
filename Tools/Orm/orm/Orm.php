<?php

namespace Tools\Orm\orm;

use Tools\Orm\db\adapter\DataSourceAdapter;
use Tools\Orm\db\adapter\CrudAdapter;

require "/Tools/Orm/sql/SqlCondition.php";

use Exception;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Orm
 *
 * @author CDB
 */
abstract class Orm {

    /**
     * Relation 1-1
     */
    const ONE_TO_ONE = 1;

    /**
     * Relation 1-N
     */
    const ONE_TO_MANY = 2;
    const MANY_TO_ONE = 3;

    /**
     * Relation N-N
     */
    const MANY_TO_MANY = 4;

    /**
     * DataSourceAdapter
     * @var DataSourceAdapter
     */
    protected static $_dataSource = null;

    /**
     * Object model name
     * @var string
     */
    protected static $_name = null;

    /**
     * Object table name
     * @var string
     */
    protected static $_tableName = null;

    /**
     * Defines object relations
     * @var array
     */
    protected $_relations = array();

    /**
     * @var boolean
     */
    private $_isNew;

    /**
     * @var DataSourceAdapter
     */
    private $_dataSrc = null;

    /**
     * Model objects relations' container
     * @var array
     */
    protected $_dataRelations = array();

    /**
     * Constructor
     */
    public function __construct() {
        $this->_isNew = true;
        $this->_dataSrc = static::getDataSource();
    }

    /**
     * Setter
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value) {
        $this->$name = htmlspecialchars($value);
    }

    /**
     * Getter
     * @param string $name
     */
    public function __get($name) {
        return htmlspecialchars_decode($this->$name);
    }

    /**
     * Returns the DataSourceAdapter object
     * @return DataSourceAdapter
     */
    public static function getDataSource() {
        return static::$_dataSource;
    }

    /**
     * @param DataSourceAdapter dataSource
     */
    public static function setDataSource(DataSourceAdapter $dataSource) {
        static::$_dataSource = $dataSource;
    }

    /**
     * Retourne le nom de la table en base de données qui correspond à l'objet.
     * @return string
     */
    protected static function _getTableName() {
        return isset(static::$_tableName) ? static::$_tableName : strtolower(preg_replace('/([a-zA-Z]+[\\\])/i', '', static::_getName()));
    }

    /**
     * Retourne le nom de la table en base de données qui correspond à l'objet.
     * @return string
     */
    public static function getTableName() {
        return static::_getTableName();
    }

    /**
     * Retourne le nom de l'objet.
     * @return string
     */
    protected static function _getName() {
        return isset(static::$_name) ? static::$_name : get_called_class();
    }

    /**
     * @param boolean $isNew
     */
    protected function _setNew($isNew) {
        $this->_isNew = $isNew;
    }

    /**
     * Determines if the current object is new or not.
     * @return boolean
     */
    public function isNew() {
        return $this->_isNew;
    }

    /**
     * @return wDataSourceAdapter
     */
    protected function _getDataSource() {
        return $this->_dataSrc;
    }

    /**
     * Returns an objects array.
     * @param array $criteria
     * @param array $order
     * @param integer $limit
     * @param integer $offset
     * @return array
     */
    public static function find($criteria = array(), array $order = null, $limit = null, $offset = null) {
        if(static::getDataSource() == null){
            throw new Exception("Error, connection is missing, try to initialize ");
        }
        $result = static::getDataSource()->find(static::_getName(), $criteria, $order, $limit, $offset);
        
        $objects = array();

        foreach ($result as $object) {
            $object->_setNew(false);
            $objects[] = $object;
        }
        return $objects;
    }

    /**
     * Returns the objects counted number.
     * @param array $criteria
     * @return integer
     */
    public static function count($criteria = array()) {
        return static::getDataSource()->count(static::_getName(), $criteria);
    }

    /**
     * Returns an object.
     * @param array $criteria
     * @param array $order
     * @return wOrm
     */
    public static function findOne($criteria = array(), array $order = null) {
        
        $objects = static::find($criteria, $order, 0, 1);
        return count($objects) == 1 ? $objects[0] : null;
        //return is_object($objects) ? $objects : null;
    }

    /**
     * Checks if the current object is read-only or not.
     */
    private function _validateModifiable() {

        if (!($this->_getDataSource() instanceof CrudAdapter)) {
            throw new Exception('Object is read-only.');
        }
    }

    /**
     * Saves the current object (or updates it).
     */
    public function save() {
        $this->_validateModifiable();
        if ($this->isNew()) {
            $this->_getDataSource()->create($this);
        } else {
            $this->_getDataSource()->update($this);
        }

        $this->_saveRelations();
        $this->_setNew(false);
    }

    /**
     * Deletes the current object.
     */
    public function delete() {
        $this->_validateModifiable();

        $this->_getDataSource()->delete($this);
    }

    /**
     * Magic finders
     * Usage :
     * - findByTitle(...)
     * - findOneByTitle(...)
     * - countByTitle(...)
     * - findByTitleAndDescription(...)
     */
    public static function __callStatic($method, $params) {
        if (!preg_match('/^(find|findOne|count)By(\w+)$/', $method, $matches)) {
            throw new \Exception("Call to undefined method {$method}");
        }

        //$keys = preg_replace('/([a-z0-9])([A-Z])/', '$1_$2', $matches[2]);
        //var_dump($keys);
        $criteriaKeysAnd = explode('_AND_', $matches[2]);
        $criteriaKeysOr = explode('_OR_', $matches[2]);
        $criteriaKeysAnd = array_map('strtolower', $criteriaKeysAnd);
        $criteriaKeysOr = array_map('strtolower', $criteriaKeysOr);
        if (count($criteriaKeysAnd) > 1) {
            $criteria = self::getSqlConditionArray($criteriaKeysAnd, $params, 'and');
        }
        elseif (count($criteriaKeysOr) > 1) {
            $criteria = self::getSqlConditionArray($criteriaKeysOr, $params, 'or');
        } else {
            $criteria = self::getSqlCondition($matches[2], $params[0]);
        }
//        $criteriaValues = array_slice($params, 0, count($criteriaKeysAnd));
//        $criteria = array_combine($criteriaKeysAnd, $criteriaValues);
//        var_dump($criteria);


        $method = $matches[1];
        return static::$method($criteria);
    }

    private static function getSqlConditionArray($criteria, $values, $op) {
        $op = "_" . $op;
        for ($i = 0; $i < count($criteria); $i++) {
            $arrayCondition[] = self::getSqlCondition($criteria[$i], $values[$i]);
        }
        return \SqlCondition::$op($arrayCondition);
    }

    private static function getSqlCondition($criteria, $value) {
        if ((strpos($value, '%') !== false)) {
            $opCond = '_like';
        } else {
            $opCond = '_equals';
        }
        return \SqlCondition::$opCond($criteria, $value);
    }

    /**
     * Exécute la fonction $callback en mode transactionnel.
     * @param function $callback
     */
    public static function transaction($callback) {
        if (!(static::getDataSource() instanceof Transactional)) {
            call_user_func($callback);
            return;
        }

        try {
            static::getDataSource()->beginTransaction();
            call_user_func($callback);
            static::getDataSource()->commit();
        } catch (Exception $e) {
            static::getDataSource()->rollBack();
            throw $e;
        }
    }

    /* Here is the part of ORM that deals with object relations */

    /**
     * Adds an object relation.
     * @param $type ONE_TO_ONE | ONE_TO_MANY | MANY_TO_MANY
     * @param array $params
     *
     * Parameters :
     * 'column' Generally id
     * 'foreignClass' Model object's class
     * 'foreignColumn' You should set xxxx_id
     * 'relationClass' Model object's class used in N-N relation
     */
    public function addRelation($type, array $params) {
        switch ($type) {
            case self::ONE_TO_ONE:
                $this->_addOneToOneRelation($params);
                break;
            case self::ONE_TO_MANY:
                $this->_addOneToManyRelation($params);
                break;
            case self::MANY_TO_ONE :
                $this->_addManyToOneRelation($params);
                break;
            case self::MANY_TO_MANY:
                $this->_addManyToManyRelation($params);
                break;

            default:
        }
    }

    /**
     * Defines a 1-1 relation
     */
    protected function _addOneToOneRelation(array $params) {
        $name = end(explode('\\', $params['foreignClass']));

        $params['type'] = self::ONE_TO_ONE;

        $this->_relations[$name] = $params;
    }

    /**
     * Defines a 1-N relation
     */
    protected function _addOneToManyRelation(array $params) {
        $name = end(explode('\\', $params['foreignClass']));

        $params['type'] = self::ONE_TO_MANY;

        $this->_relations[$name] = $params;
    }

    protected function _addManyToOneRelation(array $params) {
        $name = end(explode('\\', $params['foreignClass']));

        $params['type'] = self::MANY_TO_ONE;

        $this->_relations[$name] = $params;
    }

    /**
     * Defines a N-N relation
     */
    protected function _addManyToManyRelation(array $params) {
        $name = $params['foreignClass'];

        $params['type'] = self::MANY_TO_MANY;

        $this->_relations[$name] = $params;
    }

    /**
     * Usage :
     * - getProperty()
     * - setProperty()
     * where Property is an attribute
     *
     * - getRelationProperty()
     * - setRelationProperty() where RelationPropery
     * is the name of the relation.
     *
     * Exemple : <code>$object->getMembers()
     */
    public function __call($method, $args) {
        if (!preg_match('/^(get|set)(\w+)$/', $method, $matches)) {
            throw new \Exception("Call to undefined method {$method}");
        }
        if (array_key_exists($matches[2], $this->_relations)) {
            $toCall = '_' . $matches[1] . 'Relation';

            return $this->$toCall($this->_relations[$matches[2]], $args);
        } else {
            $property = $matches[2];
            $reflection = new \ReflectionObject($this);

            if ($reflection->hasProperty($property)) {
                if ($matches[1] == 'get') {
                    return $this->__get($property);
                } else if ($matches[1] == 'set') {
                    return $this->__set($property, $args[0]);
                }
            } else {
                throw new \Exception('Relation ' . $matches[2] . ' not found');
            }
        }
    }

    /**
     * Saves object's relations
     */
    protected function _saveRelations() {
        foreach ($this->_dataRelations as $relation) {
            $this->_saveRelation($relation);
        }
    }

    /**
     * Saves a relation
     */
    protected function _saveRelation(array $params) {
        $objs = $params['objs'];
        $column = $params['column'];
        $object = $params['foreignClass'];
        $foreignColumn = $params['foreignColumn'];

        $object = /* 'objects\\' . strtolower($object) . '\\' . */ $object;

        if ($params['type'] == self::MANY_TO_MANY) {
            $relationClass = $params['relationClass'];
            $relationClass = /* 'objects\\' . strtolower($relationClass) . '\\' . */$relationClass;

            $left_col = /* static::_getTableName() . '_' . */ $column;
            $right_col = /* $object::_getTableName() . '_' . */ $foreignColumn;

            foreach ($objs as $obj) {
                $obj->save();

                $relationObject = new $relationClass();
                $relationObject->$left_col = $this->$column;
                $relationObject->$right_col = $obj->$foreignColumn;

                $relationObject->save();
            }
        } else {
            foreach ($objs as $obj) {
                $obj->$foreignColumn = $this->$column;
                $obj->save();
            }
        }
        $this->_dataRelations = array();
    }

    /**
     * Adds a relation's data to the current object.
     * @param array @params
     * @param array $objects
     */
    protected function _setRelation(array $params, array $objects) {
        if (is_null($objects) || count($objects) < 1) {
            throw new \Exception('Cannot set a relation without at least an object');
        }

        $params['objs'] = $objects;
        array_push($this->_dataRelations, $params);
    }

    /**
     * Returns an objects array.
     * @param array $params
     * @param array $args
     * @return mixed
     */
    protected function _getRelation(array $params, array $args = null) {
        $toReturn = array();
        $found = false;
        $column = $params['column'];
        $object = $params['foreignClass'];
        $foreignColumn = $params['foreignColumn'];


        if ($params['type'] == self::MANY_TO_MANY) {
            $relationClass = $params['relationClass'];

            $left_col = $column;

            $right_col = $foreignColumn;
            $sqlCond= \SqlCondition::_equals($left_col, $this->$column);
            $relationObjects = $relationClass::find( $sqlCond);
            foreach ($relationObjects as $obj) {
                foreach ($object::find(\SqlCondition::_equals($foreignColumn, $obj->$right_col)) as $objToGet) {
                    array_push($toReturn, $objToGet);
                }
            }
        } else {

            $cpt = 0;
            while (!$found && $cpt < count($this->_dataRelations)) {
                if ($this->_dataRelations[$cpt]["foreignClass"] == $object) {
                    $found = true;
                }
                $cpt += 1;
            }
            if (!$found) {
                $toReturn = $object::find( \SqlCondition::_equals($foreignColumn, $this->$column));
            } else {
                $toReturn = $this->_dataRelations[$cpt - 1]["objs"];
            }
        }
        $toReturn = is_null($toReturn) ? array() : $toReturn;
        if ($params['type'] == self::ONE_TO_ONE || $params['type'] == self::MANY_TO_ONE) {
            if (is_array($toReturn) && count($toReturn) == 1) {
                $toReturn = $toReturn[0];
            } else if (count($toReturn) == 0) {
                return null;
            } else if ($toReturn != null) {
                
            } else {
                throw new Exception("Failed to load relation $object, maybe the type of the relation is wrong");
            }
        }
        if (!$found) {
            $params['objs'] = $toReturn;
            $this->_dataRelations[] = array_merge($this->_dataRelations, $params);
        }
        return $toReturn;
    }

}
