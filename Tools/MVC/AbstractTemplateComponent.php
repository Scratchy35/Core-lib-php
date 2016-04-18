<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tools\MVC;

/**
 * Description of AbstractToolsComponent
 *
 * @author CDB
 */
abstract class AbstractTemplateComponent {
    public function __construct(array $params) {
        foreach ($params as $key => $value) {
            //create dynamically variable
            $this->$key = $value;
        }
    }
    
    public abstract function build();
}
