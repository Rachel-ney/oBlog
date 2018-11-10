<?php
namespace oBlogApi\Models;
use PDO;
use oBlog\Utils\Database;

class Author extends CoreModel
{
    private $name;
    private $image;
    private $email;
    const TABLE_NAME = 'author';

    // Méthode permettant d'ajouter un auteur dans la bdd d'après un model reçu en paramètre
    public static function insert($model)
    {
        $sql = 'INSERT INTO '.self::TABLE_NAME.' (name, image, email) VALUES (:insertName, :insertImage, :insertEmail);';
        $pdoStatement = Database::getPDO()->prepare($sql);

        $pdoStatement->bindValue(':insertName', $model->getName(), PDO::PARAM_STR);
        $pdoStatement->bindValue(':insertImage', $model->getImage(), PDO::PARAM_STR);
        $pdoStatement->bindValue(':insertEmail', $model->getEmail(), PDO::PARAM_STR);

        if ($pdoStatement->execute()) {
            return $pdoStatement->rowCount() > 0;
        } else {
             return false;
        }
    }

    // Méthode permettant de modifier les infos d'un auteur dans la bdd d'après un model reçu en paramètre + l'id de l'auteur
    public static function update($model, $id)
    {
        // TODO
    }
    
    // GETTERS & SETTERS 
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;

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
}