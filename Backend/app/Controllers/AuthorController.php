<?php
namespace oBlogApi\Controllers;
use oBlogApi\Models\Post;
use oBlogApi\Models\Author;

class AuthorController extends CoreController
{
    // Méthode pour récuperer TOUT les auteurs et les envoyer en json
    public function all() 
    {
        // je récupère tout les posts de ma bdd sous forme d'objet
        $allAuthor = Author::getAll();

        // si la bdd ne m'a rien renvoyé
        if(empty($allAuthor)) 
        {
            //  message d'erreur , fin du programme
            $array_json['msg'] = 'La bdd n\'a retourné aucun résultat';
            $this->showJson($array_json);
            die();
        }

        // je déclare le tableau qui contiendra touts les posts
        $allAuthorForJson = array();
        // je rempli le tableau : 
        foreach( $allAuthor as $index => $currentObject) 
        {
            $allAuthorForJson[$index] = [
                'id'            => $currentObject->getId(),
                'name'         => $currentObject->getName(),
                'email'        => $currentObject->getEmail(),
                'created_at'    => $currentObject->getCreatedAt(),
                'updated_at'    => $currentObject->getUpdatedAt(),
            ];
        }
        // j'ajoute le tableau à ma réponse json : 
        $array_json = [
            'allAuthor' => $allAuthorForJson,
            'success' => true,
        ];
        // j'envoi le tableau à showJson
        $this->showJson($array_json);
    }
    
    // Méthode pour ajouter / modifier un auteur en bdd
    public function addOrUpdate() 
    {
        // je récupère la variable qui détermine si l'action sera de type add ou de type update
        $insertOrUpdate = isset($_POST['insertOrUpdate']) ? strip_tags(trim($_POST['insertOrUpdate'])) : '';
        // si vide
        if(empty($insertOrUpdate)) 
        {
            // message d'erreur, fin du programme
            $array_json['msg'] = 'Merci de préciser la méthode : insert pour créer un article / update pour modifier un article';
            $this->showJson($array_json);
            die();
        }
        // si la méthode renseigné n'est pas update ou insert
        if ($insertOrUpdate !== 'update' && $insertOrUpdate !== 'insert') {
            // message d'erreur, fin du programme
            $array_json['msg'] = 'Erreur syntaxe : insert pour créer un article / update pour modifier un article';
            $this->showJson($array_json);
            die();
        }
        // si la méthode choisi est update 
        if ($insertOrUpdate === 'update') 
        {
            // je récupère l'id de l'auteur à modifier
            $idAuthorToUpdate = isset($_POST['idToUpdate']) ? strip_tags(trim($_POST['idToUpdate'])) : '';
            // si id vide
            if(empty($idAuthorToUpdate)) 
            {
                // message d'erreur, fin du programme
                $array_json['msg'] = 'Veuillez préciser l\'identifiant de l\'auteur à modifier';
                $this->showJson($array_json);
                die();
            }
        }
        // je récupère les data
        // j'elimine les espaces (trim) et les balises(strip_tags)
        $datas = [
            'Name'  => isset($_POST['name'])  ? strip_tags(trim($_POST['name']))  : '',
            'Image' => isset($_POST['image']) ? strip_tags(trim($_POST['image'])) : '',
            'Email' => isset($_POST['email']) ? strip_tags(trim($_POST['email'])) : '',
        ];
        // je vérifie que les data reçu ne sont pas vide
        foreach ($datas as $dataName => $dataValue) 
        {
            // si vide
            if(empty($dataValue)) 
            {
                // message d'erreur, fin du programme
                $array_json['msg'] = 'Le champ ' . $dataName . ' est vide.';
                $this->showJson($array_json);
                die();
            }
        }
        // Je créer une instance de auteur
        $author = new AuthorModel();
        // je lui donne les data à ajouter : 
        foreach ($datas as $dataName => $dataValue) 
        {
            $setterName = 'set'.$dataName;
            $author->$setterName($dataValue);
        }
        // si la méthode choisi est update 
        if ($insertOrUpdate === 'update') 
        {
            // je lui donne aussi l'id
            $author->setId($idAuthorToUpdate);
        }
        
        // je test l'insertion ou la modification en bdd
        if ($author->$insertOrUpdate()) 
        {
            // si insertion / update ok j'ajoute une clef true à transmettre
            $array_json['success'] = true;
        } 
        else 
        {
            // sinon la clef = false + message d'erreur, fin du programme
            $array_json['success'] = false;
            $array_json['msg'] = 'Une erreur est survenue lors de l\''.$insertOrUpdate.'.';
            $this->showJson($array_json);
            die();
        }
        // je rempli mon tableau de réponse : 
        $array_json['post'] = [
            'id'            => $currentObject->getId(),
            'name'         => $currentObject->getName(),
            'email'        => $currentObject->getEmail(),
            'created_at'    => $currentObject->getCreatedAt(),
            'updated_at'    => $currentObject->getUpdatedAt(),
        ];
        // j'envoi le tableau à showJson
        $this->showJson($array_json);
    }
}