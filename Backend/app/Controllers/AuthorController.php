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
    public function add() 
    {
        // je récupère les data
        // j'elimine les espaces (trim) et les balises(strip_tags)
        $datas = [
            'Name'  => isset($_POST['name'])  ? strip_tags(trim($_POST['name']))  : '',
            'Password' => isset($_POST['password']) ? trim($_POST['password']) : '',
            'Email' => isset($_POST['email']) ? strip_tags(trim($_POST['email'])) : '',
        ];
        // je vérifie que les data reçu ne sont pas vide
        foreach ($datas as $dataName => $dataValue) 
        {
            // si vide
            if(empty($dataValue)) 
            {
                // message d'erreur, fin du programme
                $array_json['success'] = false;
                $array_json['msg'] = 'Le champ ' . $dataName . ' est vide.';
                $this->showJson($array_json);
                die();
            }
        }
        // je vérifie que le pseudo ne comporte que des lettres et des chiffres
        $regexName = '/^[a-zA-Z0-9_]{3,16}$/';
        if(!preg_match($regexName, $datas['Name'])) 
        {
            // message d'erreur, fin du programme
            $array_json['success'] = false;
            $array_json['msg'] = 'Le nom ne doit pas contenir d\'espace ou de caractère spéciaux';
            $this->showJson($array_json);
            die();
        }
        // je vérifie que l'adresse mail soit valide
        if (!filter_var($datas['Email'], FILTER_VALIDATE_EMAIL))  
        {
            // message d'erreur, fin du programme
            $array_json['success'] = false;
            $array_json['msg'] = 'Email invalide.';
            $this->showJson($array_json);
            die();
        }
        // je vérifie que l'adresse mail ne soit pas déjà en bdd 
        $alreadyExist = Author::getOneByEmail($datas['Email']);
        if ($alreadyExist)
        {
            // message d'erreur, fin du programme
            $array_json['success'] = false;
            $array_json['msg'] = 'Cette adresse mail est déjà enregistré pour un compte';
            $this->showJson($array_json);
            die();
        }
        // je vérifie que mon mot de passe fasse bien 8 caractère ou plus
        if(strlen($datas['Password']) < 8 )
        {
            // message d'erreur, fin du programme
            $array_json['success'] = false;
            $array_json['msg'] = 'Le mot de passe doit contenir au moins 8 caractères';
            $this->showJson($array_json);
            die();
        }
        // je vérifie que le mot de passe contienne bien maj, min, chiffre et . ou ? ou ! ou _ (1x ou plus)
        $regexPass = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[.?!_])/';
        if(!preg_match($regexPass, $datas['Password'])) 
        {
            // message d'erreur, fin du programme
            $array_json['success'] = false;
            $array_json['msg'] = 'Le mot de passe doit contenir au moins 8 caractères dont une majuscule, une minuscule, un chiffre et l\'un des caractère suivant _ ? . !  ';
            $this->showJson($array_json);
            die();
        }
        // je hash le mdp
        $datas['Password'] = password_hash($datas['Password'], PASSWORD_DEFAULT);
        // Je créer une instance de auteur
        $author = new Author();
        // je lui donne les data à ajouter : 
        foreach ($datas as $dataName => $dataValue) 
        {
            $setterName = 'set'.$dataName;
            $author->$setterName($dataValue);
        }
        // je test l'insertion en bdd
        if ($author->insert()) 
        {
            // si insertion ok j'ajoute une clef true à transmettre
            // et j'active ma session en stockant l'id du nouvel auteur
            $array_json['success'] = true;
            session_start();
            $idAuthor = $author->getId();
            $_SESSION['idUser'] = $author->getId();
        } 
        else 
        {
            // sinon la clef = false + message d'erreur, fin du programme
            $array_json['success'] = false;
            $array_json['msg'] = 'Une erreur est survenue lors de l\'inscription, veuillez recommencer.';
            $this->showJson($array_json);
            die();
        }
        // je rempli mon tableau de réponse : 
        $array_json['post'] = [
            'id'            => $author->getId(),
            'name'          => $author->getName(),
            'email'         => $author->getEmail(),
            'created_at'    => $author->getCreatedAt(),
            'updated_at'    => $author->getUpdatedAt(),
        ];
        // j'envoi le tableau à showJson
        $this->showJson($array_json);
    }

        // Méthode pour ajouter / modifier un auteur en bdd
        public function update() 
        {
            // je récupère les data
            // j'elimine les espaces (trim) et les balises(strip_tags)
            // je hash le mot de passe
            $datas = [
                'Id' => isset($_SESSION['idUser'])  ? strip_tags(trim($_SESSION['idUser']))  : '',
                'Name'  => isset($_POST['name'])  ? strip_tags(trim($_POST['name']))  : '',
                'Password' => isset($_POST['password']) ? sha1(trim($_POST['password'])) : '',
                'Email' => isset($_POST['email']) ? strip_tags(trim($_POST['email'])) : '',
            ];
            // je vérifie que les data reçu ne sont pas vide
            foreach ($datas as $dataName => $dataValue) 
            {
                // si vide
                if(empty($dataValue)) 
                {
                    // message d'erreur, fin du programme
                    $array_json['success'] = false;
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
            
            // je test la modification en bdd
            if ($author->update()) 
            {
                // si update ok j'ajoute une clef true à transmettre
                $array_json['success'] = true;
            } 
            else 
            {
                // sinon la clef = false + message d'erreur, fin du programme
                $array_json['success'] = false;
                $array_json['msg'] = 'Une erreur est survenue lors de la modification.';
                $this->showJson($array_json);
                die();
            }
            // je rempli mon tableau de réponse : 
            $array_json['post'] = [
                'id'            => $author->getId(),
                'name'          => $author->getName(),
                'email'         => $author->getEmail(),
                'created_at'    => $author->getCreatedAt(),
                'updated_at'    => $author->getUpdatedAt(),
            ];
            // j'envoi le tableau à showJson
            $this->showJson($array_json);
        }
}