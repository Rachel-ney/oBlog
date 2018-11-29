<?php
namespace oBlogApi\Models;
use PDO;
use oBlogApi\Utils\Database;

abstract class CoreModel
{
    protected $id;
    protected $created_at;
    protected $updated_at;

    abstract function insert();

    // Méthode renvoyant TOUT les champs d'une table
    public static function getAll()
    {
        if(static:: TABLE_NAME === 'post') 
        {
            $sql = 'SELECT p.* , c.name AS category_name, a.name AS author_name 
            FROM '. static:: TABLE_NAME .' AS p 
            INNER JOIN category AS c 
            ON p.category_id = c.id 
            INNER JOIN author AS a 
            ON p.author_id = a.id;';
        }
        else
        {
            $sql = 'SELECT * FROM '. static:: TABLE_NAME.';';
        }
        $pdoStatement = Database::getPDO()->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, static::class);
        return $results;
    }

    // Méthode renvoyant UN UNIQUE champ d'une table dont l'id est donné
    public static function getOne($id)
    {
        if(static:: TABLE_NAME === 'post') 
        {
            $sql = 'SELECT p.* , c.name AS category_name, a.name AS author_name 
            FROM '. static:: TABLE_NAME .' AS p 
            INNER JOIN category AS c 
            ON p.category_id = c.id 
            INNER JOIN author AS a 
            ON p.author_id = a.id
            WHERE p.id = :id ;';
        }
        else
        {
            $sql = 'SELECT * FROM '. static:: TABLE_NAME.'
            WHERE id = :id;';
        }
        $pdoStatement = Database::getPDO()->prepare($sql);
        $pdoStatement->bindValue(':id', $id, PDO::PARAM_INT);
        $pdoStatement->execute();
        $results = $pdoStatement->fetchObject(static::class);
        return $results;
    }


    // GETTERS & SETTERS

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    } 
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}