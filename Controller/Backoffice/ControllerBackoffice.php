<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controller\Backoffice;
use Tools\MVC\AbstractController;
/**
 * Description of ControllerBackoffice
 *
 * @author CDB
 */
class ControllerBackoffice extends AbstractController{
    
    public function test(){
        $this->display("Template\Backoffice\Add_Groupe",array("truc"=>"trqsd"));
    }
}
