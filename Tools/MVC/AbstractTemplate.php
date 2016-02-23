<?php
namespace Tools\MVC;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AbstractTemplate
 *
 * @author CDB
 */
abstract class AbstractTemplate {
    
    public function __construct(array $params) {
        foreach($params as $key=>$value){
            //create dynamically variable
            $this->$key = $value;
        }
    }
    /**
     * Function to build page head, <head> tag is created in function build()
     */
    public abstract function buildHead();
    
    /**
     * Function to create page body, <body> tag is created in function build()
     */
    public abstract function buildBody();
    
    /**
     * Function to build page footer if needed
     */
    public abstract function buildFooter();
    
    /**
     * Function to build the page
     */
    public function build(){
        echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
            <html>
                <head>';
        $this->buildHead();
        echo '</head>';
        echo '<body>';
        $this->buildBody();
        $this->buildFooter();
        echo '</body>';
        echo '</html>';
    }
}
