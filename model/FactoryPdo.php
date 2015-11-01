<?php
namespace model;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'model/pdo/PdoCustom.php ';

/**
 * Description of FactoryPdo
 *
 * @author CDB
 */
class FactoryPdo
{

    /**
     * @param string $bdd
     * @return bool|PdoCustom
     */
    public static function getPdo($bdd)
    {
        switch ($bdd) {
            case "TIBIA" :
                return self::getTibia();
            case "DIIP" :
                return self::getDiip();
            case "TMMS":
                return self::getTmms();
            case "EASYVISTA":
                return self::getEasyvista();
            case "CENTREON" :
                return self::getCentreon();
            default :
                return false;
        }
    }

    /**
     * @return bool|PdoCustom
     */
    private static function getTibia()
    {
        $hostname = strtolower(gethostname());
        switch ($hostname[7]) {
            case "d" :
                return new PdoCustom('sqlsrv:Server=tibia-db-D001.glb.intra.groupama.fr\OTSDEV;Database=tibia', 's_iguazu', 'N=G=NXfEHjCuGXjddqq');
            case "r" :
                return new PdoCustom('sqlsrv:Server=tibia-db-R001.glb.intra.groupama.fr\OTSRCT;Database=tibia', 's_iguazu', 'N=G=NXfEHjCuGXjddqq');
            case "q" :
                return new PdoCustom('sqlsrv:Server=tibia-db-Q001.glb.intra.groupama.fr\OTSPPR;Database=tibia', 's_iguazu', 'N=G=NXfEHjCuGXjddqq');
            case "p" :
                return new PdoCustom('sqlsrv:Server=tibia-db-P001.glb.intra.groupama.fr\OTSEXP;Database=tibia', 's_iguazu', 'N=G=NXfEHjCuGXjddqq');
            default :
                return false;
        }
    }

    /**
     * @return bool|PdoCustom
     */
    private static function getDiip()
    {
        $hostname = strtolower(gethostname());
        switch ($hostname[7]) {
            case "d" :
                return new PdoCustom('sqlsrv:Server=diip-db-P001.glb.intra.groupama.fr\DSIDEVEXPB;Database=DIIP', 's_iguazu', 'N=G=NXfEHjCuGXjddqq');
            case "r" :
                return new PdoCustom('sqlsrv:Server=diip-db-P001.glb.intra.groupama.fr\DSIDEVEXPB;Database=DIIP', 's_iguazu', 'N=G=NXfEHjCuGXjddqq');
            case "q" :
                return new PdoCustom('sqlsrv:Server=diip-db-P001.glb.intra.groupama.fr\DSIDEVEXPB;Database=DIIP', 's_iguazu', 'N=G=NXfEHjCuGXjddqq');
            case "p" :
                return new PdoCustom('sqlsrv:Server=diip-db-P001.glb.intra.groupama.fr\DSIDEVEXPB;Database=DIIP', 's_iguazu', 'N=G=NXfEHjCuGXjddqq');
            default :
                return false;
        }
    }

    /**
     * @return bool|PdoCustom
     */
    private static function getCentreon()
    {
        $hostname = strtolower(gethostname());
        switch ($hostname[7]) {
            case "d" :
                return new PdoCustom('mysql:host=centreon-db-D002.glb.intra.groupama.fr;dbname=centreon_storage', 's_iguazu', 'WE8zdQfCEaLajgE71npI');
            case "q" :
                return new PdoCustom('mysql:host=centreon-db-P002.glb.intra.groupama.fr;dbname=centreon_storage', 's_iguazu', 'WE8zdQfCEaLajgE71npI');
            case "r" :
                return new PdoCustom('mysql:host=centreon-db-P002.glb.intra.groupama.fr;dbname=centreon_storage', 's_iguazu', 'WE8zdQfCEaLajgE71npI');
            case "p" :
                return new PdoCustom('mysql:host=centreon-db-P002.glb.intra.groupama.fr;dbname=centreon_storage', 's_iguazu', 'WE8zdQfCEaLajgE71npI');
            default :
                return false;
        }
    }

    /**
     * @return PdoCustom
     */
    private static function getEasyvista()
    {
        return new PdoCustom('sqlsrv:Server=easyvistaP001.glb.intra.groupama.fr\EASYVISTA;Database=EVO_DATA50004', 's_iguazu', 'N=G=NXfEHjCuGXjddqq');
    }

    /**
     * @return PdoCustom
     */
    private static function getTmms()
    {
        return new PdoCustom('sqlsrv:Server=tmms-db-p001.glb.intra.groupama.fr\OTSEXP;Database=TMMS', 's_iguazu', 'N=G=NXfEHjCuGXjddqq');
    }

}
