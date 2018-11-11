<?php
namespace oBlogApi\Models;
use PDO;
use oBlogApi\Utils\Database;

class Author extends CoreModel
{
    private $name;
    private $image;
    private $email;
    const TABLE_NAME = 'author';

    // Méthode permettant d'ajouter un auteur dans la bdd d'après un model reçu en paramètre
    public function insert()
    {
        $sql = 'INSERT INTO '.self::TABLE_NAME.' (name, image, email) VALUES (:insertName, :insertImage, :insertEmail);';
        $pdoStatement = Database::getPDO()->prepare($sql);

        $pdoStatement->bindValue(':insertName',  $this->getName(), PDO::PARAM_STR);
        $pdoStatement->bindValue(':insertImage', $this->getImage(), PDO::PARAM_STR);
        $pdoStatement->bindValue(':insertEmail', $this->getEmail(), PDO::PARAM_STR);

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

    // Méthode permettant de modifier les infos d'un auteur dans la bdd d'après un model reçu en paramètre + l'id de l'auteur
    public function update()
    {
        $sql = 'UPDATE '.self::TABLE_NAME.' SET 
        name =  :newName, 
        image = :newImage, 
        email = :newEmail
        WHERE id = :insertId;';
        $pdoStatement = Database::getPDO()->prepare($sql);

        $pdoStatement->bindValue(':newName',  $this->getName(), PDO::PARAM_STR);
        $pdoStatement->bindValue(':newImage', $this->getImage(), PDO::PARAM_STR);
        $pdoStatement->bindValue(':newEmail', $this->getEmail(), PDO::PARAM_STR);
        $pdoStatement->bindValue(':insertId', $this->getId(), PDO::PARAM_INT);

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