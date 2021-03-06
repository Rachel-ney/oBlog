<?php
namespace oBlogApi\Controllers;

use oBlogApi\Models\Author;
use PHPMailer\PHPMailer\Exception;

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
            $this->sendError('La bdd n\'a retournée aucun résultat');
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
            $this->sendError('La bdd n\'a retournée aucun résultat');
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
        $asError = $this->notEmptyDatas($datas);

        if (!$asError) 
        {
            // je vérifie que le pseudo ne comporte que des lettres et des chiffres
            $regexName = '/^[a-zA-Z0-9_]{1,25}$/';
            if(!preg_match($regexName, $datas['Name'])) 
            {
                $this->sendError('Le nom ne doit pas contenir d\'espaces ou de caractères spéciaux');
                $asError = true;
            }
        }

        if (!$asError) 
        {
            // je vérifie que l'adresse mail soit valide
            if (!filter_var($datas['Email'], FILTER_VALIDATE_EMAIL))  
            {
                $this->sendError('Email invalide.');
                $asError = true;
            }
        }

        if (!$asError) 
        {
            // je vérifie que l'adresse mail ne soit pas déjà en bdd 
            $alreadyExist = Author::getOneByEmail($datas['Email']);
            if ($alreadyExist)
            {
                $this->sendError('Cette adresse mail est déjà enregistrée');
                $asError = true;
            }
        }

        if (!$asError) 
        {
            // je test le mot de passe
            $asError = $this->passwordIntegrity($datas['Password'], $datas['Pass_confirm']);
        }

        if (!$asError) 
        {
            // je rajoute un salt au mdp
            $datas['Password'] .= $this->salt;
            // je hash le mdp
            $datas['Password'] = password_hash($datas['Password'], PASSWORD_DEFAULT);
            // création token et ajout au tableau de data 
            $token = bin2hex(random_bytes(32));
            $datas['Token'] = $token;
            
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
            if (!$author->insert()) 
            {
                //message d'erreur
                $this->sendError('Une erreur est survenue lors de l\'inscription');
                $asError = true;
            }
        }

        if (!$asError) 
        {
            $asError = $this->sendMail($author, 'validate');
        }

        if (!$asError) 
        {
            $array_json['success']['mail'] = true;
            $this->showJson($array_json);
        }
        
    }

    public function validateAccount() {
        $datas = [
            'id'    => isset($_GET['id'])    ? trim(strip_tags((int)$_GET['id'])) : '',
            'token' => isset($_GET['token']) ? trim(strip_tags($_GET['token']))   : '',
        ];
        // je vérifie que les data reçu ne soient pas vide
        $asError = $this->notEmptyDatas($datas);

        if (!$asError) 
        {
            // je cherche l'auteur par son id
            $authorFind = Author::getOne($datas['id']);
            // si je ne le trouve pas
            if (!$authorFind)
            {
                $this->sendError('Compte inexistant');
                $asError = true;
            }
        }
         
        if (!$asError) 
        {
            // vérification token
            if ($datas['token'] !== $authorFind->getToken()) 
            {
                $this->sendError('Une erreur est survenue');
                $asError = true;
            }
        }

        if (!$asError) 
        {
            // vérification status : 0 = inactif, 1 = actif
            if ($authorFind->getStatus() === '1') 
            {
                $this->sendError('Le compte a déjà été activé');
                $asError = true;
            }
        }

        if (!$asError) 
        {
            if(!Author::activate($datas['id']))
            {
                $this->sendError('Une erreur est survenue');
                $asError = true;
            }
        }

        if (!$asError) 
        {
            $array_json['success'] = true;
            $this->showJson($array_json);
        }
        
    }

    public function connexion() {
        // je récupère les data
        // j'elimine les espaces (trim)
        $datas = [
            'Password' => isset($_POST['password']) ? trim(strip_tags($_POST['password'])) : '',
            'Email'    => isset($_POST['email'])    ? trim(strip_tags($_POST['email']))    : '',
        ];
        // je vérifie que les data reçu ne sont pas vide
        $asError = $this->notEmptyDatas($datas);

        if (!$asError) 
        {
            // je cherche l'auteur par son mail
            $authorFind = Author::getOneByEmail($datas['Email']);
            // si je ne le trouve pas
            if (!$authorFind)
            {
                // message d'erreur, fin du programme
                $this->sendError('Compte inexistant');
                $asError = true;
            }
        }

        if (!$asError) 
        {
            // je vérifie que son status sois actif (1)
            $status = $authorFind->getStatus();
            if ($status !== '1') 
            {
                // message d'erreur, fin du programme
                $this->sendError('Le compte n\'est pas actif');
                $asError = true;
            }
        }

        if (!$asError) 
        {
            // je rajoute le salt que j'avais défini à l'inscription
            $datas['Password'] .= $this->salt;
            $hash = $authorFind->getPassword();
            // si le mdp donné ne correspond pas à celui stocké en bdd
            if (!password_verify($datas['Password'], $hash)) 
            {
                // message d'erreur, fin du programme
                $this->sendError('Mot de passe incorrect', true);
                $asError = true;
            }
        }

        if (!$asError) 
        {
            // j'enregistre ses info en session
            $this->addUserInSession($authorFind);
            // ainsi que ses articles
            $this->addPostAuthorInSession();
            // Pour pouvoir les afficher dans la page mon compte sans avoir à faire de requêtes
            // je récupère les catégories en session directement à la connexion
            $this->addCategoryInSession();
            // j'envoi mon retour comme positif
            $array_json['success'] = true;
        
            $array_json['sess'] = $_SESSION;
            $array_json['sess_param'] = session_get_cookie_params();
            // j'envoi le tableau à showJson
            $this->showJson($array_json);
        }
    }

    public function lostPass() {
        $data['email'] = isset($_GET['email']) ? trim(strip_tags($_GET['email'])) : '';
        // je vérifie que les data reçu ne sont pas vide
        $asError = $this->notEmptyDatas($data);

        if (!$asError) 
        {
            // je cherche l'auteur par son mail
            $authorFind = Author::getOneByEmail($data['email']);

            // si je ne le trouve pas
            if (!$authorFind)
            {
                $this->sendError('Compte inexistant');
                $asError = true;
            }
        }
        
        if (!$asError) 
        {
            // je vérifie que son status sois actif (1)
            $status = $authorFind->getStatus();
            if ($status !== '1') 
            {
                $this->sendError('Le compte a été desactivé');
                $asError = true;
            }
        }
        
        if (!$asError) 
        {
            // création token et ajout au tableau de data 
            $token = bin2hex(random_bytes(32));
            // je test l'insertion du token en bdd
            if (!Author::insertToken($data['email'], $token)) 
            { 
                $this->sendError('Une erreur est survenue lors de l\'inscription, veuillez recommencer.');
                $asError = true;
            }
            else 
            {
                $authorFind->setToken($token);
            }
        }

        if (!$asError) 
        {
            $asError = $this->sendMail($authorFind, 'lostPass');
        }

        if (!$asError) 
        {
            $array_json['success'] = true;
            $this->showJson($array_json);
        }

    }

    public function resetPass() {
        $datas = [
            'id'          => isset($_POST['id'])              ? trim(strip_tags((int)$_POST['id'])) : '',
            'token'       => isset($_POST['token'])           ? trim($_POST['token'])               : '',
            'password'    => isset($_POST['password'])        ? trim($_POST['password'])            : '',
            'passConfirm' => isset($_POST['passwordConfirm']) ? trim($_POST['passwordConfirm'])     : '',
        ];
        //var_dump($datas);
        // je vérifie que les datas ne soient pas vide
        $asError = $this->notEmptyDatas($datas);

        if (!$asError) 
        {
            // je récupère l'auteur
            $authorFind = Author::getOne($datas['id']);
            if (!$authorFind)
            {
                $this->sendError('Compte inexistant');
                $asError = true;
            }
        }

        if (!$asError) 
        {
            // je test le token
            $tokenAuthor = $authorFind->getToken();
            if($tokenAuthor !== $datas['token']) 
            {
                $this->sendError('Une erreur est survenue - token');
                $asError = true;
            }
        }
        
        if (!$asError) 
        {
            // je test l'intégrité du mdp
            $asError = $this->passwordIntegrity($datas['password'], $datas['passConfirm']);
        }
        
        if (!$asError) 
        {
            // je rajoute un salt au mdp
            $datas['password'] .= $this->salt;
            // je hash le mdp
            $datas['password'] = password_hash($datas['password'], PASSWORD_DEFAULT);
            // j'enregistre le nouveau mdp dans la bdd
            if(!Author::updatePassword($datas['id'], $datas['password']))
            {
                $this->sendError('Une erreur est survenue - password');
                $asError = true;
            }
        }

        if (!$asError) 
        {
            // je supprime le token
            Author::insertToken($authorFind->getEmail(), '0');
            $array_json['success'] = true;
            $this->showJson($array_json);
        }
        
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
        $asError = $this->notEmptyDatas($datas);

        if (!$asError) 
        {
            // Je cherche si l'auteur existe bien 
            $authorFind = Author::getOne($datas['id']);
            if (!$authorFind)
            {
                $this->sendError('Une erreur est survenue');
                $asError = true;
            }
        }

        if (!$asError) 
        {
            // si trouvé je vérifie son mot de passe 
            // je rajoute le salt 
            $datas['oldPass'] .= $this->salt;

            $hash = $authorFind->getPassword();
            // si le mdp donné ne correspond pas à celui stocké en bdd
            if (!password_verify($datas['oldPass'], $hash)) 
            {
                $this->sendError('Mot de passe incorrect');
                $asError = true;
            }
        }
        
        if (!$asError) 
        {
            // je test le nouveau mot de passe
            $asError = $this->passwordIntegrity($datas['newPass'], $datas['newPassConfirm']);
        }
        
        if (!$asError) 
        {
            // j'ajoute le salt + hash le nouveau mdp
            $datas['newPass'] .= $this->salt;
            $datas['newPass'] = password_hash($datas['newPass'], PASSWORD_DEFAULT);

            // Je test la modification en bdd
            if (!Author::updatePassword($datas['id'], $datas['newPass'])) 
            {
                $this->sendError('Une erreur est survenue');
                $asError = true;
            } 
        }

        if (!$asError) 
        {
            // si update ok j'ajoute une clef true à transmettre
            $_SESSION['success']['changePass'] = 'Votre mot de passe a bien été modifié';
            $array_json['success'] = true;
            $this->showJson($array_json);
        }
        
    }

    public function desactivate() {
        $asError = false;

        $password = isset($_POST['password'])      ? trim(strip_tags($_POST['password'])) : '';
        $id       = isset($_SESSION['user']['id']) ? $_SESSION['user']['id']              : '';

        if(empty($password) || empty($id)) 
        {
            $this->sendError('Vous ne pouvez pas laisser de champs vide');
            $asError = true;
        }

        if (!$asError) 
        {
            $authorFind = Author::getOne($id);

            if(empty($authorFind))
            {
                $this->sendError('Une erreur est survenue');
                $asError = true;
            }
        }
        
        if (!$asError) 
        {
            $hash = $authorFind->getPassword();
            $password.= $this->salt;
            
            // si le mdp donné correspond à celui stocké en bdd
            if (!password_verify($password, $hash))
            {
                $this->sendError('Mot de passe incorrect');
                $asError = true;
            }
        }
        
        if (!$asError) 
        {
            $desactivate = Author::desactivate($id);

            if(!$desactivate)
            {
               $this->sendError('Une erreur est survenue');
               $asError = true;
            }
        }

        if (!$asError) 
        {
            $array_json['success'] = true;
            $_SESSION['user'] = null;
            $this->showJson($array_json);
        }
        
    }
}