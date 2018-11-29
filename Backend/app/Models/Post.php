<?php
namespace oBlogApi\Models;
use PDO;
use oBlogApi\Utils\Database;

class Post extends CoreModel
{
    private $title;
    private $resume;
    private $content;
    private $author_id;
    private $category_id;
    private $category_name;
    private $author_name;
    const TABLE_NAME = 'post';

    // Méthode renvoyant TOUT les post EN FONCTION de la catégorie OU de l'auteur.
    // 2 paramètre attendu : 
    // param1 = 'category' OU param1 = 'author'
    // param2 = id
    public static function getAllPostBy($byParam, $id)
    {
        if ($byParam === 'category' || $byParam === 'author')
        {
            $sql =
            'SELECT p.* , c.name AS category_name, a.name AS author_name
            FROM  '. static:: TABLE_NAME .' AS p 
            INNER JOIN category AS c
            ON p.category_id = c.id
            INNER JOIN author AS a
            ON p.author_id = a.id
            WHERE p.'. $byParam .'_id = :id';
            $pdoStatement = Database::getPDO()->prepare($sql);
            $pdoStatement->bindValue(':id', $id, PDO::PARAM_INT);
            $pdoStatement->execute();
            $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, static::class);
            return $results;
        }
        // Si on a entré autre chose que category ou author
        else 
        {
            return false;
        }
    }
    
    // Méthode insérant un nouvel article dans la table post d'après un model reçu en paramètre
    public function insert()
    {
        $sql = 
        'INSERT INTO '.self::TABLE_NAME.' (title, resume, content, author_id, category_id) 
        VALUES (:insertTitle, :insertResume, :insertContent, :insertAuthorId, :insertCategoryId);';
        $pdoStatement = Database::getPDO()->prepare($sql);

        $pdoStatement->bindValue(':insertTitle',     $this->getTitle(), PDO::PARAM_STR);
        $pdoStatement->bindValue(':insertResume',    $this->getResume(), PDO::PARAM_STR);
        $pdoStatement->bindValue(':insertContent',   $this->getContent(), PDO::PARAM_STR);
        $pdoStatement->bindValue(':insertAuthorId',  $this->getAuthorId(), PDO::PARAM_INT);
        $pdoStatement->bindValue(':insertCategoryId',$this->getCategoryId(), PDO::PARAM_INT);

        $success = false;
        if ($pdoStatement->execute()) 
        {
            $success = $pdoStatement->rowCount() > 0;
            if ($success)
            {
                $this->id = Database::getPDO()->lastInsertId();
            }
        } 
        return $success;
    }

    // Méthode modifiant un article dans la table post d'après un model reçu en paramètre et son id
    public function update()
    {
        $sql = 
        'UPDATE '.self::TABLE_NAME.' SET 
        title       = :newTitle, 
        resume      = :newResume, 
        content     = :newContent, 
        author_id   = :newAuthorId, 
        category_id = :newCategoryId,
        updated_at  = NOW() 
        WHERE id    = :insertId ;';

        $pdoStatement = Database::getPDO()->prepare($sql);

        $pdoStatement->bindValue(':newTitle',      $this->getTitle(), PDO::PARAM_STR);
        $pdoStatement->bindValue(':newResume',     $this->getResume(), PDO::PARAM_STR);
        $pdoStatement->bindValue(':newContent',    $this->getContent(), PDO::PARAM_STR);
        $pdoStatement->bindValue(':newAuthorId',   $this->getAuthorId(), PDO::PARAM_INT);
        $pdoStatement->bindValue(':newCategoryId', $this->getCategoryId(), PDO::PARAM_INT);
        $pdoStatement->bindValue(':insertId',      $this->getId(), PDO::PARAM_INT);

        if ($pdoStatement->execute()) 
        {
            return $pdoStatement->rowCount() > 0;
        } 
        else 
        {
             return false;
        }
    }

    // GETTERS & SETTERS

    public function getTitle()
    {
        return $this->title;
    } 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }
 
    public function getResume()
    {
        return $this->resume;
    }
    public function setResume($resume)
    {
        $this->resume = $resume;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthorId()
    {
        return $this->author_id;
    }
    public function setAuthorId($author_id)
    {
        $this->author_id = $author_id;

        return $this;
    }

    public function getCategoryId()
    {
        return $this->category_id;
    }
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function getCategoryName()
    {
        return $this->category_name;
    }
    public function setCategoryName($category_name)
    {
        $this->category_name = $category_name;

        return $this;
    }

    public function getAuthorName()
    {
        return $this->author_name;
    }
    public function setAuthorName($author_name)
    {
        $this->author_name = $author_name;

        return $this;
    }
}