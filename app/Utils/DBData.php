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
     * Méthode permettant de récupérer les infos de tout les articles
     * Ainsi que l'auteur et la catégorie de chaque articles
     */
    public function getAllPost()
    {
        $sql =
        "SELECT p.* , c.name AS category_name, a.name AS author_name
        FROM post AS p
        INNER JOIN category AS c
        ON p.category_id = c.id
        INNER JOIN author AS a
        ON p.author_id = a.id";
        $statement = $this->dbh->query($sql);
        $postList = $statement->fetchAll(PDO::FETCH_CLASS,'Post');
        return $postList;
    }
    /**
     * Méthode permettant de récupérer les infos d'un articles d'après son ID
     * Ainsi que l'auteur et la catégorie de l'article
     */
    public function getPostFromId($id_post)
    {
        $sql =
        "SELECT p.* , c.name AS category_name, a.name AS author_name
        FROM post AS p
        INNER JOIN category AS c
        ON p.category_id = c.id
        INNER JOIN author AS a
        ON p.author_id = a.id
        WHERE p.id = ". $id_post;
        $statement = $this->dbh->query($sql);
        $postList = $statement->fetchObject('Post');
        return $postList;
    }
    /**
     * Méthode permettant de récupérer les infos de tout les articles d'une catégorie
     * Ainsi que l'auteur et la catégorie de chaque articles
     */
    public function getAllPostFromCategory($id_category)
    {
        $sql =
        "SELECT p.* , c.name AS category_name, a.name AS author_name
        FROM post AS p
        INNER JOIN category AS c
        ON p.category_id = c.id
        INNER JOIN author AS a
        ON p.author_id = a.id
        WHERE p.category_id =". $id_category;
        $statement = $this->dbh->query($sql);
        $postList = $statement->fetchAll(PDO::FETCH_CLASS,'Post');
        return $postList;
    }
    /**
     * Méthode permettant de récupérer les infos de tout les articles d'un auteur
     * Ainsi que l'auteur et la catégorie de chaque articles
     */
    public function getAllPostFromAuthor($id_author)
    {
        $sql =
        "SELECT p.* , c.name AS category_name, a.name AS author_name
        FROM post AS p
        INNER JOIN category AS c
        ON p.category_id = c.id
        INNER JOIN author AS a
        ON p.author_id = a.id
        WHERE p.author_id =". $id_author;
        $statement = $this->dbh->query($sql);
        $postList = $statement->fetchAll(PDO::FETCH_CLASS,'Post');
        return $postList;
    }
    /**
     * Méthode permettant de récupérer les infos de tout les auteurs
     */
    public function getAllAuthor()
    {
        $sql =
        "SELECT * FROM author";
        $statement = $this->dbh->query($sql);
        $authorList = $statement->fetchAll(PDO::FETCH_CLASS,'Author');
        return $authorList;
    }
    /**
     * Méthode permettant de récupérer les infos de toutes les catégories
     */
    public function getAllCategory()
    {
        $sql =
        "SELECT * FROM category";
        $statement = $this->dbh->query($sql);
        $categoryList = $statement->fetchAll(PDO::FETCH_CLASS,'Category');
        return $categoryList;
    }
}