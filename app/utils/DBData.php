<?php
/**
 * Classe permettant de retourner des données stockées dans la base de données
 */
class DBData {
	/** @var PDO */
	private $dbh;
    /**
     * Constructeur se connectant à la base de données à partir des informations du fichier de configuration
     */
    public function __construct() {
        // Récupération des données du fichier de config
        //   la fonction parse_ini_file parse le fichier et retourne un array associatif
        // Attention, "config.conf" ne doit pas être versionné,
        //   on versionnera plutôt un fichier d'exemple "config.dist.conf" ne contenant aucune valeur
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
    /**
     * Méthode permettant de récupérer les infos de tout les personnages
     * Ainsi que le type de chaques personnages
     */
    public function getAllPost()
    {
        $sql =
        "SELECT p.* , c.name AS category_name, a.name AS author_name
        FROM post AS p
        INNER JOIN category AS c
        ON p.category = c.id_category
        INNER JOIN author AS a
        ON p.author = a.id_author";
        $statement = $this->dbh->query($sql);
        $postList = $statement->fetchAll(PDO::FETCH_CLASS,'Post');
        return $postList;
    }

    public function getAllPostFromCategory($id_category)
    {
        $sql =
        "SELECT p.* , c.name AS category_name, a.name AS author_name
        FROM post AS p
        INNER JOIN category AS c
        ON p.category = c.id_category
        INNER JOIN author AS a
        ON p.author = a.id_author
        WHERE p.category =". $id_category;
        $statement = $this->dbh->query($sql);
        $postList = $statement->fetchAll(PDO::FETCH_CLASS,'Post');
        return $postList;
    }
    public function getAllPostFromAuthor($id_author)
    {
        $sql =
        "SELECT p.* , c.name AS category_name, a.name AS author_name
        FROM post AS p
        INNER JOIN category AS c
        ON p.category = c.id_category
        INNER JOIN author AS a
        ON p.author = a.id_author
        WHERE p.author =". $id_author;
        $statement = $this->dbh->query($sql);
        $postList = $statement->fetchAll(PDO::FETCH_CLASS,'Post');
        return $postList;
    }

    public function getAllAuthor()
    {
        $sql =
        "SELECT * FROM author";
        $statement = $this->dbh->query($sql);
        $authorList = $statement->fetchAll(PDO::FETCH_CLASS,'Author');
        return $authorList;
    }

    public function getAllCategory()
    {
        $sql =
        "SELECT * FROM category";
        $statement = $this->dbh->query($sql);
        $categoryList = $statement->fetchAll(PDO::FETCH_CLASS,'Category');
        return $categoryList;
    }
}
/* Exemple de requête avec alias et jointure : 
    "SELECT c.*, t.name AS type_name 
    FROM `character` AS c 
    INNER JOIN `type` AS t 
    ON c.type_id = t.id
    ORDER BY c.name";
*/