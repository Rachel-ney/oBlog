<?php
namespace oBlogApi\Controllers;

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
            $this->sendError('La bdd n\'a retourné aucun résultat');
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


    // Méthode pour récuperer UN auteur et renvoyer ses info
    public function one($param) 
    {
        // je récupère tout les posts de ma bdd sous forme d'objet
        $oneAuthor = Author::getOne($param['id']);
        // si la bdd ne m'a rien renvoyé
        if(empty($oneAuthor)) 
        {
            $this->sendError('La bdd n\'a retourné aucun résultat');
        }
        // je déclare le tableau qui contiendra touts les posts
        $authorForJson = array();
        // je rempli le tableau : 
        $authorForJson = [
            'id'            => $oneAuthor->getId(),
            'name'          => $oneAuthor->getName(),
            'email'         => $oneAuthor->getEmail(),
            'created_at'    => $oneAuthor->getCreatedAt(),
            'updated_at'    => $oneAuthor->getUpdatedAt(),
        ];
        // j'ajoute le tableau à ma réponse json : 
        $array_json = [
            'author' => $authorForJson,
            'success' => true,
        ];
        // j'envoi le tableau à showJson
        $this->showJson($array_json);
    }


    // Méthode pour ajouter un auteur en bdd
    public function add() 
    {
        // je récupère les data
        // j'elimine les espaces (trim) et les balises(strip_tags)
        $datas = [
            'Name'         => isset($_POST['name'])         ? strip_tags(trim($_POST['name']))  : '',
            'Password'     => isset($_POST['password'])     ? trim($_POST['password'])          : '',
            'Pass_confirm' => isset($_POST['pass_confirm']) ? trim($_POST['pass_confirm'])      : '',
            'Email'        => isset($_POST['email'])        ? strip_tags(trim($_POST['email'])) : '',
        ];
        // je vérifie que les datas ne sont pas vide
        $this->notEmptyDatas($datas);

        // je vérifie que le pseudo ne comporte que des lettres et des chiffres
        $regexName = '/^[a-zA-Z0-9_]{1,25}$/';
        if(!preg_match($regexName, $datas['Name'])) 
        {
            $this->sendError('Le nom ne doit pas contenir d\'espace ou de caractère spéciaux');
        }
        // je vérifie que l'adresse mail soit valide
        if (!filter_var($datas['Email'], FILTER_VALIDATE_EMAIL))  
        {
            $this->sendError('Email invalide.');
        }
        // je vérifie que l'adresse mail ne soit pas déjà en bdd 
        $alreadyExist = Author::getOneByEmail($datas['Email']);
        if ($alreadyExist)
        {
            $this->sendError('Cette adresse mail est déjà enregistré');
        }

        // je test le mot de passe
        $this->passwordIntegrity($datas['Password'], $datas['Pass_confirm']);

        // je rajoute un salt au mdp
        $datas['Password'] .= $this->salt;
        // je hash le mdp
        $datas['Password'] = password_hash($datas['Password'], PASSWORD_DEFAULT);
        // Je créer une instance de auteur
        $author = new Author();
        // je lui donne les data à ajouter : 
        foreach ($datas as $dataName => $dataValue) 
        {
            if ($dataName !== 'Pass_confirm')
            {
                $setterName = 'set'.$dataName;
                $author->$setterName($dataValue);    
            }
        }
        // je test l'insertion en bdd
        if ($author->insert()) 
        {
            // si insertion ok j'ajoute une clef true à transmettre
            $array_json['success'] = true;
            // et j'active ma session 
            $this->addUserInSession($author);
            // Pour pouvoir les afficher dans la page mon compte sans avoir à faire de requêtes
            // je récupère les catégories
            $this->addCategoryInSession();
        } 
        else 
        {
            // sinon la clef = false + message d'erreur, fin du programme
            $this->sendError('Une erreur est survenue lors de l\'inscription, veuillez recommencer.');
        }
        // j'envoi le tableau à showJson
        $this->showJson($array_json);
    }

    public function connexion() {
        // je récupère les data
        // j'elimine les espaces (trim)
        $datas = [
            'Password' => isset($_POST['password']) ? trim(strip_tags($_POST['password'])) : '',
            'Email'    => isset($_POST['email'])    ? trim(strip_tags($_POST['email']))    : '',
        ];
        // je vérifie que les data reçu ne sont pas vide
        $this->notEmptyDatas($datas);

        // je cherche l'auteur par son mail
        $authorFind = Author::getOneByEmail($datas['Email']);
        // si je ne le trouve pas
        if (!$authorFind)
        {
            // message d'erreur, fin du programme
            $this->sendError('Auteur inexistant');
        }
        // je vérifie que son status sois actif (1)
        $status = $authorFind->getStatus();
        if ($status !== '1') 
        {
            // message d'erreur, fin du programme
            $this->sendError('Le compte a été desactivé');
        }
        // je rajoute le salt que j'avais défini à l'inscription
        $datas['Password'] .= $this->salt;
        $hash = $authorFind->getPassword();
        // si le mdp donné ne correspond pas à celui stocké en bdd
        if (!password_verify($datas['Password'], $hash)) 
        {
            // message d'erreur, fin du programme
            $this->sendError('Mot de passe incorrect', true);
            $this->showJson($array_json);
            die();
        }
        // j'enregistre ses info en session
        $this->addUserInSession($authorFind);
        // ainsi que ses articles
        $this->addPostAuthorInSession();
        // Pour pouvoir les afficher dans la page mon compte sans avoir à faire de requêtes
        // je récupère les catégories en session directement à la connexion
        $this->addCategoryInSession();
        // j'envoi mon retour comme positif
        $array_json['success'] = true;
        // j'envoi le tableau à showJson
        $this->showJson($array_json);
    }

    // Méthode pour changer le mdp de l'auteur
    public function changePass() 
    {
        // je récupère les data
        // j'elimine les espaces (trim) et les balises(strip_tags)
        $datas = [
            'id'             => isset($_SESSION['user']['id'])  ? $_SESSION['user']['id']        : '',
            'oldPass'        => isset($_POST['oldPass'])        ? trim($_POST['oldPass'])        : '',
            'newPass'        => isset($_POST['newPass'])        ? trim($_POST['newPass'])        : '',
            'newPassConfirm' => isset($_POST['newPassConfirm']) ? trim($_POST['newPassConfirm']) : '',
        ];
        // je vérifie que les datas ne soient pas vide
        $this->notEmptyDatas($datas);
        // Je cherche si l'auteur existe bien 
        $authorFind = Author::getOne($datas['id']);
        if (!$authorFind)
        {
            $this->sendError('Une erreur est survenue');
        }
        // si trouvé je vérifie son mot de passe 
        // je rajoute le salt 
        $datas['oldPass'] .= $this->salt;

        $hash = $authorFind->getPassword();
        // si le mdp donné ne correspond pas à celui stocké en bdd
        if (!password_verify($datas['oldPass'], $hash)) 
        {
            $this->sendError('Mot de passe incorrect');
        }
        // je test le nouveau mot de passe
        $this->passwordIntegrity($datas['newPass'], $datas['newPassConfirm']);
        // j'ajoute le salt + hash le nouveau mdp
        $datas['newPass'] .= $this->salt;
        $datas['newPass'] = password_hash($datas['newPass'], PASSWORD_DEFAULT);

        // Je test la modification en bdd
        if (Author::updatePassword($datas['id'], $datas['newPass'])) 
        {
            // si update ok j'ajoute une clef true à transmettre
            $_SESSION['success']['changePass'] = 'Votre mot de passe a bien été modifié';
            $array_json['success'] = true;
            $this->showJson($array_json);
        } 
        else 
        {
            $this->sendError('Une erreur est survenue');
        }
    }

    public function desactivate() {

        $password = isset($_POST['password'])      ? trim(strip_tags($_POST['password'])) : '';
        $id       = isset($_SESSION['user']['id']) ? $_SESSION['user']['id']              : '';

        if(empty($password) || empty($id)) 
        {
            $this->sendError('Vous ne pouvez pas laisser de champs vide');
        }

        $authorFind = Author::getOne($id);

        if(empty($authorFind))
        {
            $this->sendError('Une erreur est survenue');
        }

        $hash = $authorFind->getPassword();
        $password.= $this->salt;
        
        // si le mdp donné correspond à celui stocké en bdd
        if (!password_verify($password, $hash))
        {
            $this->sendError('Mot de passe incorrect');
        }

        $desactivate = Author::desactivate($id);

        if($desactivate)
        {
            $array_json['success'] = true;
            session_unset();
            $this->showJson($array_json);
        }
        else 
        {
            $this->sendError('Une erreur est survenue');
        }
    }
}