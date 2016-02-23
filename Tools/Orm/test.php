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
//      include 'Tools/Orm/orm/Orm.php ';
//      include 'Tools/Orm/pdo/PdoCustom.php ';
//      include 'Entity/Rfc/Rfc.php';
//      include 'Entity/Rfc/Rfc_Solution.php';
//      include 'Entity/Rfc/Rfc_Etape.php';
//      include 'Entity/Rfc/Rfc_Demande.php';
//      include 'Entity/Rfc/Rfc_Typologie.php';
//      include 'Entity/Rfc/Rfc_Bilan.php';
//      include 'Entity/Rfc/Rfc_Decision.php';
//      include 'Tools/Orm/db/Db.php';
////      include 'Entity/Favoris.php';
////      include 'Entity/Pages.php';
//      include 'Entity/Logiciel.php';
//      include 'Entity/Personnes.php ';
//      include 'Entity/Util/DiipUtil.php ';
//      include 'Entity/Util/SearchUtil.php';
//      include_once 'Tools/Orm/FactoryConnection.php ';
////      include 'Entity/Factures/Factures.php';
////      include 'Entity/Factures/Facture_Pour.php';
////      include 'legacy/inc/php/AutoCompleteSearch/AutoCompleteSearchController.php';
////      include 'legacy/inc/php/AutoCompleteSearch/AutoCompleteSearchView.php';
//      
////      $diipUtil = new DiipUtil();
////      var_dump(intval(null));
//      
//      $searchUtil = new SearchUtil();
//      var_dump($searchUtil->search('test'));
      
//    include 'search/Search_controller.php';
//    $searchController = new Search_controller();
//    $searchController->search();
//        $request = "SELECT
//                        ?
//                    FROM
//                        V_APPLIS_IG v";
//    
//        $pdo = FactoryConnection::getPdo('TIBIA');
//        $sth = $pdo->prepare($request);
//        $fields = 'v.ID_LOGICIEL,v.NOM_LOGICIEL';
//        $sth->bindParam(1, $fields);
//        $sth->execute();
//        var_dump($sth->fetchAll());
//        
        //var_dump($_POST['FIELDS'] );
//    include 'Entity/Util/ExportAppUtil.php';
//    include 'legacy/apps/Export/ExportApp_View.php';
//    
//    $exportApp = new ExportAppUtil();
//    $fieldsRequested  = array('ID_LOGICIEL','NOM_LOGICIEL');
//    $result = $exportApp->exportRequest($fieldsRequested);
//  
     include 'legacy/apps/Export/ExportApp_Controller.php';
     
     $controller = new ExportApp_Controller();
     
     $controller->getView();
     
      
      
     
     
    ?>
  </body>
</html>
