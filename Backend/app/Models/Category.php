<?php
namespace oBlogApi\Models;
use PDO;
use oBlog\Utils\Database;

class Category extends CoreModel
{
    private $name;
    const TABLE_NAME = 'category';

    // Méthode permettant d'ajouter une catégorie dans la table category d'après un model reçu en paramètre
    public static function insert($model)
    {
        // Pour l'instant pas de création de catégory 
    }

    // Méthode permettant de modifier une catégorie dans la table category d'après un model reçu en paramètre + son id
    public static function update($model, $id)
    {
        // Donc pas d'update non plus... *genius*
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
}