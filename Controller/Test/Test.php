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
        $css =  "/Public/common/main.css";
        echo "<link href='$css' rel='stylesheet' type='text/css'>";
        echo "tralalala/<h1>$test</h1>";
    }
}