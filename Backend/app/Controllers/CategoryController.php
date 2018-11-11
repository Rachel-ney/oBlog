<?php
namespace oBlogApi\Controllers;
use oBlog\Models\Post;
use oBlog\Models\Category;

class CategoryController extends CoreController
{
    // Méthode pour récuperer TOUT les auteurs et les envoyer en json
    public function all() 
    {
        // je récupère tout les posts de ma bdd sous forme d'objet
        $allCategory = Category::getAll();

        // si la bdd ne m'a rien renvoyé
        if(empty($allCategory)) 
        {
            //  message d'erreur , fin du programme
            $array_json['msg'] = 'La bdd n\'a retourné aucun résultat';
            $this->showJson($array_json);
            die();
        }

        // je déclare le tableau qui contiendra touts les posts
        $allCategoryForJson = array();
        // je rempli le tableau : 
        foreach( $allCategory as $index => $currentObject) 
        {
            $allCategoryForJson[$index] = [
                'id'            => $currentObject->getId(),
                'name '         => $currentObject->getName(),
                'created_at'    => $currentObject->getCreatedAt(),
                'updated_at'    => $currentObject->getUpdatedAt(),
            ];
        }
        // j'ajoute le tableau à ma réponse json : 
        $array_json = [
            'allCategory' => $allCategoryForJson,
            'success' => true,
        ];
        // j'envoi le tableau à showJson
        $this->showJson($array_json);
    }

    // Méthode pour récuperer TOUT les POST d'UN auteur et les envoyer en json
    public function allPostByCategory() 
    {
        $idCategory = isset($_POST['idCategory']) ? strip_tags(trim($_POST['idCategory'])) : '';
            // si id vide
            if(empty($idCategory)) 
            {
                // message d'erreur, fin du programme
                $array_json['msg'] = 'Veuillez préciser l\'identifiant de la catégorie';
                $this->showJson($array_json);
                die();
            }
        // je récupère tout les posts de ma bdd sous forme d'objet
        $allPostByCategory = Post::getAllPostBy('category');

        // si la bdd ne m'a rien renvoyé
        if(empty($allPostByCategory)) 
        {
            //  message d'erreur , fin du programme
            $array_json['msg'] = 'La bdd n\'a retourné aucun résultat';
            $this->showJson($array_json);
            die();
        }

        // je déclare le tableau qui contiendra tout les posts
        $forJson = array();
        // je rempli le tableau : 
        foreach( $allPostByCategory as $index => $currentObject) 
        {
            $forJson[$index] = [
                'id'            => $currentObject->getId(),
                'name '         => $currentObject->getName(),
                'email '        => $currentObject->getEmail(),
                'created_at'    => $currentObject->getCreatedAt(),
                'updated_at'    => $currentObject->getUpdatedAt(),
            ];
        }
        // j'ajoute le tableau à ma réponse json : 
        $array_json = [
            'allPostByCategory' => $forJson,
            'success' => true,
        ];
        // j'envoi le tableau à showJson
        $this->showJson($array_json);
    }

}