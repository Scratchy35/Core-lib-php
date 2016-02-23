<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Template\Backoffice;

use Tools\MVC\AbstractTemplate;

/**
 * Description of Base
 *
 * @author CDB
 */
class Base extends AbstractTemplate {

    public function buildHead() {
        ?>
        <meta charset="utf-8">
        <title>Hello...</title>
        <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
        <script src="legacy/inc/js/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript">
            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            })
        </script>
        <?php
    }
    
    public function buildBody() {
        ?>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Iguazu</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <!-- item menu -->
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Groupe<span class="sr-only">(current)</span></a></li>
                        <li><a href="#">Utilisateur</a></li>
                    </ul>
                    <!-- search module -->
                    <form class="navbar-form navbar-right" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-default">Rechercher</button>
                    </form>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <?php
    }

    public function buildFooter() {
        
    }

    

//put your code here
}
