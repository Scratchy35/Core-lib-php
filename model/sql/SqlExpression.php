<?php

/**
 * Created by PhpStorm.
 * User: Scratchy
 * Date: 24/10/2015
 * Time: 12:01
 */
class SqlExpression
{


    public function __construct()
    {
    }

    /**
     * @return $this
     * @throws Exception
     * @internal param SqlExpression $cond1...$condN
     */
    public function andX()
    {
        $args = func_get_args();
        if(count($args)< 2)
        {
            throw new Exception("At least 2 argument should be passed to function andX");
        }
        $str = "(";
        $str .= implode(" AND ",$args);
        $str .= ")";
        return $str;
    }


    public function orX()
    {
        $args = func_get_args();
        if(count($args)< 2)
        {
            throw new Exception("At least 2 argument should be passed to function andX");
        }
        $str = "(";
        $str .= implode(" OR ",$args);
        $str .= ")";
        return $str;
    }


    /** Comparison objects **/

    public function eq($x, $y)
    {
        return "$x = $y";
    }

    // Example - $qb->expr()->neq('u.id', '?1') => u.id <> ?1
    public function neq($x, $y)
    {
        return "$x != $y";
    }

    // Example - $qb->expr()->lt('u.id', '?1') => u.id < ?1
    public function lt($x, $y)
    {
        return "$x < $y";
    }// Returns Expr\Comparison instance

    // Example - $qb->expr()->lte('u.id', '?1') => u.id <= ?1
    public function lte($x, $y)
    {
        return "$x <= $y";
    }// Returns Expr\Comparison instance

    // Example - $qb->expr()->gt('u.id', '?1') => u.id > ?1
    public function gt($x, $y)
    {
        return "$x > $y";
    }// Returns Expr\Comparison instance

    // Example - $qb->expr()->gte('u.id', '?1') => u.id >= ?1
    public function gte($x, $y)
    {
        return "$x >= $y";
    }// Returns Expr\Comparison instance

    // Example - $qb->expr()->isNull('u.id') => u.id IS NULL
    public function isNull($x)
    {
        return "$x IS NULL";
    } // Returns string

    // Example - $qb->expr()->isNotNull('u.id') => u.id IS NOT NULL
    public function isNotNull($x)
    {
        return "$x IS NOT NULL";
    }// Returns string


    /** Arithmetic objects **/

    // Example - $qb->expr()->prod('u.id', '2') => u.id * 2
    public function prod($x, $y)
    {
        return "$x * $y";
    }

    // Example - $qb->expr()->diff('u.id', '2') => u.id - 2
    public function diff($x, $y){
        return "$x - $y";
    } // Returns Expr\Math instance

    // Example - $qb->expr()->sum('u.id', '2') => u.id + 2
    public function sum($x, $y)
    {
        return "$x + $y";
    }

    // Example - $qb->expr()->quot('u.id', '2') => u.id / 2
    public function quot($x, $y)
    {
        return "$x / $y";
    }// Returns Expr\Math instance


    /** Pseudo-function objects **/

    // Example - $qb->expr()->exists($qb2->getDql())
    public function exists($subquery)
    {
        if(!$subquery instanceof SqlAbstract)
        {
            throw new Exception("The argument should be of type SqlAbstract");
        }
        $str = $subquery->getRequest();
        return "EXIST IN ($str)";
    }// Returns Expr\Func instance

    // Example - $qb->expr()->all($qb2->getDql())
    public function all($subquery)
    {
        if(!$subquery instanceof SqlAbstract)
        {
            throw new Exception("The argument should be of type SqlAbstract");
        }
        $str = $subquery->getRequest();
        return "ALL IN ($str)";
    }// Returns Expr\Func instance

    // Example - $qb->expr()->some($qb2->getDql())
    public function some($subquery)
    {
        if(!$subquery instanceof SqlAbstract)
        {
            throw new Exception("The argument should be of type SqlAbstract");
        }
        $str = $subquery->getRequest();
        return "SOME IN ($str)";
    }// Returns Expr\Func instance

    // Example - $qb->expr()->any($qb2->getDql())
    /**
     * @param $subquery
     * @return string
     * @throws Exception
     */
    public function any($subquery)
    {
        if(!$subquery instanceof SqlAbstract)
        {
            throw new Exception("The argument should be of type SqlAbstract");
        }
        $str = $subquery->getRequest();
        return "ANY IN ($str)";
    }// Returns Expr\Func instance

    // Example - $qb->expr()->not($qb->expr()->eq('u.id', '?1'))
    public function not($restriction)
    {
        return "NOT $restriction";
    }
     // Returns Expr\Func instance

    // Example - $qb->expr()->in('u.id', array(1, 2, 3))
    // Make sure that you do NOT use something similar to $qb->expr()->in('value', array('stringvalue')) as this will cause Doctrine to throw an Exception.
    // Instead, use $qb->expr()->in('value', array('?1')) and bind your parameter to ?1 (see section above)
    public function in($x, $y)
    {
        if(!is_array($y)){
            throw new Exception("Second argument should be an array");
        }
        $arg = implode(",",$y);
        return "$x IN [$arg]";
    } // Returns Expr\Func instance

    // Example - $qb->expr()->notIn('u.id', '2')
    public function notIn($x, $y)
    {
        if(!is_array($y)){
            throw new Exception("Second argument should be an array");
        }
        $arg = implode(",",$y);
        return "$x NOT IN [$arg]";
    } // Returns Expr\Func instance
    // Example - $qb->expr()->like('u.firstname', $qb->expr()->literal('Gui%'))
    public function like($x, $y)
    {
        return "$x LIKE $y";
    } // Returns Expr\Func instance
    // Example - $qb->expr()->notLike('u.firstname', $qb->expr()->literal('Gui%'))
    public function notLike($x, $y)
    {
        return "$x NOT LIKE $y";
    }

    // Example - $qb->expr()->between('u.id', '1', '10')
    public function between($val, $x, $y)
    {
        return "$val BETWEEN [$x,$y]";
    }


    /** Function objects **/

    // Example - $qb->expr()->trim('u.firstname')
    public function trim($x)
    {
        return trim($x);
    }// Returns Expr\Func

    // Example - $qb->expr()->concat('u.firstname', $qb->expr()->concat($qb->expr()->literal(' '), 'u.lastname'))
    public function concat($x, $y)
    {
        return $x.$y;
    }
     // Returns Expr\Func

    // Example - $qb->expr()->substring('u.firstname', 0, 1)
    public function substring($x, $from, $len)
    {
        return substr($x,$from,$len);
    }// Returns Expr\Func

    // Example - $qb->expr()->lower('u.firstname')
    public function lower($x)
    {
        return strtolower($x);
    } // Returns Expr\Func

    // Example - $qb->expr()->upper('u.firstname')
    public function upper($x)
    {
        return strtoupper($x);
    }// Returns Expr\Func

    // Example - $qb->expr()->length('u.firstname')
    public function length($x)
    {
        return count($x);
    }

    // Example - $qb->expr()->avg('u.age')
    public function avg($x)
    {
        return "AVG($x)";
    } // Returns Expr\Func

    // Example - $qb->expr()->max('u.age')
    public function max($x){
        return "MAX($x)";
    }// Returns Expr\Func

    // Example - $qb->expr()->min('u.age')
    public function min($x){
        return "MIN($x)";
    } // Returns Expr\Func

    // Example - $qb->expr()->abs('u.currentBalance')
    public function abs($x)
    {
        return "ABS($x)";
    }

    // Example - $qb->expr()->sqrt('u.currentBalance')
    public function sqrt($x)
    {
        return "SQRT($x)";
    }

    // Example - $qb->expr()->count('u.firstname')
    public function count($x)
    {
        return " COUNT($x)";
    }// Returns Expr\Func

    // Example - $qb->expr()->countDistinct('u.surname')
    public function countDistinct($x)
    {
        return "COUNTDISTINCT($x)";
    }// Returns Expr\Func

}