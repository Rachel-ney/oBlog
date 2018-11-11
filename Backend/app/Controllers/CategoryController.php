<?php
namespace oBlogApi\Controllers;
use oBlogApi\Models\Post;
use oBlogApi\Models\Category;

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
                'name'         => $currentObject->getName(),
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
}