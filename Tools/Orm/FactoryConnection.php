<?php
namespace Tools\Orm;
use Tools\Orm\pdo\PdoCustom;
use Tools\Orm\db\Db;
use Tools\Orm\orm\Orm;
use Tools\Exceptions\Common\FailedReadConfFileException;
use Exception;

/**
 * Description of FactoryConnection
 *
 * @author CDB
 */
class FactoryConnection {

    private static $confObject = null;
    const PATH_JSON_CONF = "/Configuration/DbConnection.json";

    /**
     * Fonction pour ouvrir une connection PDO vers une base de donnée inscrite dans DbConnection.json
     * @param string $bdd nom de la base de donnée  
     * @return \PdoCustom la connection pdo vers la base de donnée
     * @throws Exception
     */
    public static function getPdo($bdd) {
        $hostname = strtolower(gethostname());
        $env = "";
        switch ($hostname[7]) {
            case "d" :
                $env = "DEV";
                break;
            case "q" :
                $env = "PPR";
                break;
            case "r" :
                $env = "RCT";
                break;
            case "p" :
                $env = "EXP";
                break;
        }
        return self::buildPdo($bdd, $env);
    }

    /**
     * Construit la connection pdo avec le nom de base et l'environnement
     * @param string $bdd nom de la base de donnée
     * @param string $env environnement dans lequelle on se situe
     * @return \PdoCustom la connection pdo vers la base de donnée
     * @throws Exception
     */
    private static function buildPdo($bdd, $env) {
        //on monte en mémoire le json lu 
        if(!isset(self::$jsonConf)){
            $json = file_get_contents(getcwd() . self::PATH_JSON_CONF);
            self::$confObject= json_decode($json);
        }
        if (!isset(self::$confObject) || !is_object(self::$confObject)) {
            throw new FailedReadConfFileException("Erreur lors de la lecture du fichier de configuration");
        }
        if (!isset(self::$confObject->$bdd) || !is_object(self::$confObject->$bdd)) {
            throw new Exception("Erreur, la base de donnée n'a pas d'informations de connection définies");
        }
        if (!isset(self::$confObject->$bdd->DEFAULT) && !isset(self::$confObject->$bdd->$env)) {
            throw new Exception("Erreur, impossible de trouver les informations de connections de la base $bdd pour l'environnement $env");
        }
        //on instancie et renvoie la connection PDO 
        $conf = !isset(self::$confObject->$bdd->$env) ? self::$confObject->$bdd->DEFAULT : self::$confObject->$bdd->$env;
        $pdo = new PdoCustom($conf->ConnectionString, $conf->Login, $conf->Password);
        $db = new Db($pdo);
        Orm::setDataSource($db);
        return $pdo;
    }

}
