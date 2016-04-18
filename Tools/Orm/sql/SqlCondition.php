<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Condition
 *
 * @author CDB
 */
class SqlCondition {

    /**
     *
     * @var array|string  
     */
    private $operandes;
    private $operateur;
    private $not;
    private $value;
    private $count;

    public function getValue() {
        return $this->value;
    }

    public function getCount() {
        return $this->count;
    }

    private function setOperandes($operandes) {
        $this->operandes = $operandes;
    }

    private function setOperateur($operateur) {
        $this->operateur = $operateur;
    }

    private function setNot($not) {
        $this->not = $not;
    }

    public function __construct() {
        $this->count = 0;
    }

    public static function _or($operandes, $not = false) {
        $operateur = "OR";
        return self::setCondition($operateur, $operandes, $not);
    }

    public static function _and($operandes, $not = false) {
        $operateur = "AND";
        return self::setCondition($operateur, $operandes, $not);
    }

    public static function _equals($operande1, $operande2, $not = false) {
        $operateur = "=";
        return self::setCondition($operateur, array($operande1, $operande2), $not);
    }

    public static function _like($operande1, $operande2, $not = false) {
        $operateur = "LIKE";
        return self::setCondition($operateur, array($operande1, $operande2), $not);
    }

    public static function _in($operande1, $operande2, $not = false) {
        $operateur = "IN";
        return self::setCondition($operateur, array($operande1, $operande2), $not);
    }

    public static function _not($operande) {
        $operateur = "NOT";
        return self::setCondition($operateur, $operande);
    }

    private static function setCondition($operateur, $operandes, $not = false) {
        $condition = new SqlCondition();
        $condition->setOperateur($operateur);
        $condition->setOperandes($operandes);
        $condition->setNot(isset($not) ? $not : false);
        return $condition;
    }

    public function build() {
        $str= "";
        $this->value=array();
        switch ($this->operateur) {
            case "NOT":
                $str = $this->buildNot();
                break;
            case "IN":
                $str = $this->buildIn();
                break;
            case "=":
                $str = $this->buildEquals();
                break;
            case "LIKE":
                $str = $this->buildLike();
                break;
            case "AND":
                $str = $this->buildAnd();
                break;
            case "OR":
                $str = $this->buildOr();
                break;
            default : throw new Exception("OPERATEUR UNKNOWN");
        }

        return $str;
    }

    private function buildNot() {
        $op = $this->operandes[0];
        if ($op instanceof SqlCondition) {
            $str = $this->operateur . " " . $op->build();
        } else {
            $str = $this->operateur . " " . $op;
        }
        $this->value = array_merge($this->value,$op->getValue());
        return $str;
    }
    
    private function buildIn(){
        $in = "(?";
        for($i = 1; $i< count($this->operandes[1]) - 1; $i++){
            $in .= ",?" ;
        }
        $in .= ",?)";
        $this->value= $this->operandes[1];
        return $this->operandes[0] ." ". $this->operateur ." $in";
    }

    private function buildLike() {
        $this->value[] = $this->operandes[1];
        return $this->operandes[0] ." ". $this->operateur . " ?";
    }
    
    private function buildEquals(){
        if("".intval($this->operandes[1]) == $this->operandes[1]){
            $this->operandes[1] = intval($this->operandes[1]);
        }
        $this->value[] = $this->operandes[1];
        return $this->operandes[0].$this->operateur . "?";
    }
    
    private function buildAnd(){
        foreach ($this->operandes as $op) {
            $tabCond[] = $op->build();
            $this->value = array_merge($this->value,$op->getValue());
        }
        $str = "(".implode(" AND ", $tabCond).")";
        
        return $str;
    }
    
    private function buildOr(){
        foreach ($this->operandes as $op) {
            $tabCond[] = $op->build();
            $this->value = array_merge($this->value,$op->getValue());
        }
        $str = "(".implode(" OR ", $tabCond).")";
        
        return $str;
    }
}
