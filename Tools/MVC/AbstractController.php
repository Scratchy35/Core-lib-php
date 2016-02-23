<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Tools\MVC;
use Tools\MVC\AbstractTemplate;
/**
 * Description of AbstractController
 *
 * @author CDB
 */
class AbstractController {
    
    
    public function display($template, $params = array()){
        if(class_exists($template)){
            $classTemplate = new $template($params);
            $classTemplate->build();
        }
        else
        {
            throw new \Exception("Template $template don't exist");
        }
    }
}
