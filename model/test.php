<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
  <head>
    <meta charset="UTF-8">
    <title></title>
  </head>
  <body>
    <?php
//      include 'model/orm/Orm.php ';
//      include 'model/BO/Personnes.php ';
//      include 'model/pdo/PdoCustom.php ';
//      include 'model/BO/Rfc/Rfc.php';
//      include 'model/BO/Rfc/Rfc_Solution.php';
      include 'model/db/Db.php';
//      include 'model/BO/Favoris.php';
//      include 'model/BO/Pages.php';
//      include 'model/BO/Logiciel.php';
//      include 'model/BO/Factures/Factures.php';
//      include 'model/BO/Factures/Facture_Pour.php';
      include 'inc/php/AutoCompleteSearch/AutoCompleteSearchController.php';
      include 'inc/php/AutoCompleteSearch/AutoCompleteSearchView.php';
      
//      $pdo = new PdoCustom('sqlsrv:Server=tibia-db-D001.glb.intra.groupama.fr\OTSDEV;Database=tibia', 's_iguazu', 'N=G=NXfEHjCuGXjddqq');
//      $db = new Db($pdo);
//      Orm::setDataSource($db);
      
      //var_dump(Logiciel::findOneByID_LOGICIEL('DIIP'));
      
      //$personne = Personnes::findOneByTrigramme('MIG19793');
      
//      $rfc = Rfc::findOneByID_RFC(1);
//      var_dump($rfc->getRfc_Solution());
      
//      
//      $page = Pages::findOneById_page('1');
//      var_dump($page->getPersonnes());
      
      //$personne->setPages($page);
      //$personne->save();
      //$personne->getPages();
//      $w1 = new EvTimer(120,0,function(){
//          Mailer::addMail('cdubois@groupama-loire-bretagne.com', 'DUBOIS Charles');
//          Mailer::send('Test', 'test');
//      });
//      $toto = 'Factures';
//      //Factures::find($criteria);      
//      $facture = Factures::findOneByID_FACTURE('1');
      //$titi = 'getLogiciel';
      //var_dump($facture->$titi());
      
      $auto = new AutoCompleteSearchController('Personnes', '', '', 'FIRSTNAME');
      $auto->getContainer('test', 'test', 'test', '', 'toto');
      $auto->responseAjax('', '');
      
    ?>
  </body>
</html>
