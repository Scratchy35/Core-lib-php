<?php

namespace Controller\Test;
/**
 * Created by PhpStorm.
 * User: Scratchy
 * Date: 25/10/2015
 * Time: 00:22
 */
class Test
{
    public function __construct()
    {

    }
    public function test($test)
    {
        $css =  "/Public/common/css/main.css";
        echo "<link href='$css' rel='stylesheet' type='text/css'>";
        echo "tralalala/<h1>$test</h1>";
        $max =4 ;
        define('MAX',$max);
        echo MAX.'<br>';
        if(8 & 1)
            echo 'ok';
        else
            echo "c'est mort";
//        for($i = 0 ; $i< $max ;$i++ )
//        {
//            echo pow(2,$i);
//
//            define($permsName,$i);
//        }
    }
}