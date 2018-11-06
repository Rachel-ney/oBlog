<?php
namespace oBlog\Utils;
use PDO;
/**
 * Classe permettant de retourner des données stockées dans la base de données
 */
class Database {
	/** @var PDO */
    private $dbh;
    private static $_instance;
    /**
     * Constructeur se connectant à la base de données à partir des informations du fichier de configuration
     */
    public function __construct() {
        $configData = parse_ini_file(__DIR__.'/config.conf');
        
        try {
            $this->dbh = new PDO(
                "mysql:host={$configData['DB_HOST']};dbname={$configData['DB_NAME']};charset=utf8",
                $configData['DB_USERNAME'],
                $configData['DB_PASSWORD'],
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING) // Affiche les erreurs SQL à l'écran
            );
        }
        catch(\Exception $exception) {
            echo 'Erreur de connexion...<br>';
            echo $exception->getMessage().'<br>';
            echo '<pre>';
            echo $exception->getTraceAsString();
            echo '</pre>';
            exit;
        }
    }

    public function getDbh()
    {
        // dbh est une instance de PDO
        return $this->dbh;
    }

    // Méthode static, je peux l'executer sans instancier Database
    public static function getPDO()
    {
        // si $_instance n'est pas vide: 
        if (empty(self::$_instance)) {
            // alors je me connecte
            // $_intance ne sera pas détruite tant que le script sera executé
            self::$_instance = new Database();
            /*  Pour rappel:
            self:: me permet d'accèder aux propriété static de ma class
            $this-> me permet d'accèder aux propriétés de mon objet (= de ma classe une fois instanciée)
            */
        }

        return self::$_instance->getDbh();
    }
}