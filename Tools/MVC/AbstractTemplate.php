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
        foreach ($params as $key => $value) {
            //create dynamically variable
            $this->$key = $value;
        }
    }

    /**
     * function to get title of the page
     * @return string title of the page
     */
    public abstract function getTitle();

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
     * 
     * @param String $fullNameComponent class full name of the component
     */
    protected function includeComponent($fullNameComponent,$params = array()){
        if(!class_exists($fullNameComponent)){
            throw new Exception("Failed to find class $fullNameComponent");
        }  
        $component = new $fullNameComponent($params);
        if(!is_subclass_of($component, "/Tools/MVC/AbstractTemplateComponent")){
            throw new Exception("Error : class $fullNameComponent should extend /Tools/MVC/AbstractTemplateComponent");
        }
        echo $component->build();
    }
    
    protected function table($table){
        echo $table->build();
    }
    
    /**
     * Function to build the page
     */
    public function build() {
        ?>
        <!DOCTYPE HTML>
        <html>
            <head>
                <meta http-equiv="content-type" content="text/html;charset=utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge" />
                <title><?php echo $this->getTitle(); ?></title>
                <?php
                $this->buildHead();
                ?>
            </head>            
            <body>
                <?php
                $this->buildBody();
                $this->buildFooter();
                ?>
            </body>
        </html>
        <?php
    }

}
