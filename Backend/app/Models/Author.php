<?php
namespace oBlogApi\Models;
use PDO;
use oBlogApi\Utils\Database;

class Author extends CoreModel
{
    private $name;
    private $password;
    private $email;
    private $status;
    private $token;
    const TABLE_NAME = 'author';

    // Méthode renvoyant UN UNIQUE champ d'une table dont le mail est donné
    public static function getOneByEmail($email)
    {
        $sql = 'SELECT * FROM '. static:: TABLE_NAME.'
        WHERE email = :email';

        $pdoStatement = Database::getPDO()->prepare($sql);
        $pdoStatement->bindValue(':email', $email, PDO::PARAM_STR);
        $pdoStatement->execute();
        
        return $pdoStatement->fetchObject(static::class);
    }

    // Méthode permettant d'ajouter un auteur dans la bdd d'après un model reçu en paramètre
    // je ne précise pas le status car par défaut à 1 dans ma bdd
    public function insert()
    {
        $sql = 'INSERT INTO '.self::TABLE_NAME.' (name, password, email, token) VALUES (:insertName, :insertPassword, :insertEmail, :insertToken);';
        $pdoStatement = Database::getPDO()->prepare($sql);

        $pdoStatement->bindValue(':insertName',  $this->getName(), PDO::PARAM_STR);
        $pdoStatement->bindValue(':insertPassword', $this->getPassword(), PDO::PARAM_STR);
        $pdoStatement->bindValue(':insertEmail', $this->getEmail(), PDO::PARAM_STR);
        $pdoStatement->bindValue(':insertToken', $this->getToken(), PDO::PARAM_STR);

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

    public static function insertToken($email, $token) {
        $sql = 'UPDATE '.self::TABLE_NAME.' SET 
        token = :tokenToInsert
        WHERE email = :email;';
        $pdoStatement = Database::getPDO()->prepare($sql);
        $pdoStatement->bindValue(':email', $email, PDO::PARAM_STR);
        $pdoStatement->bindValue(':tokenToInsert', $token, PDO::PARAM_STR);

        if ($pdoStatement->execute()) 
        {
            return $pdoStatement->rowCount() > 0;
        } 
        else 
        {
             return false;
        }
    }

    public static function activate($id) {
        $sql = 'UPDATE '.self::TABLE_NAME.' SET 
        status = 1
        WHERE id = :id;';
        $pdoStatement = Database::getPDO()->prepare($sql);
        $pdoStatement->bindValue(':id', $id, PDO::PARAM_INT);

        if ($pdoStatement->execute()) 
        {
            return $pdoStatement->rowCount() > 0;
        } 
        else 
        {
             return false;
        }
    }

    // Méthode permettant de modifier le mdp d'un auteur
    public static function updatePassword($id, $newPass)
    {
        $sql = 'UPDATE '.self::TABLE_NAME.' SET 
        password = :newPassword, 
        updated_at = NOW()
        WHERE id = :id;';
        $pdoStatement = Database::getPDO()->prepare($sql);

        $pdoStatement->bindValue(':newPassword', $newPass, PDO::PARAM_STR);
        $pdoStatement->bindValue(':id', $id, PDO::PARAM_INT);

        if ($pdoStatement->execute()) 
        {
            return $pdoStatement->rowCount() > 0;
        } 
        else 
        {
             return false;
        }
    }

    public static function desactivate($id)
    {
        $sql = 'UPDATE '.self::TABLE_NAME.' SET 
        status = 0
        WHERE id = :insertId;';
        $pdoStatement = Database::getPDO()->prepare($sql);

        $pdoStatement->bindValue(':insertId', $id, PDO::PARAM_INT);

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

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($pswd)
    {
        $this->password = $pswd;

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

    public function getStatus()
    {
        return $this->status;
    }
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function getToken()
    {
        return $this->token;
    }
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }
}