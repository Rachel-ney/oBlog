<?php
namespace oBlogApi\Controllers;

use oBlogApi\Models\Author;
use PHPMailer\PHPMailer\PHPMailer;
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
        if ($author->insert()) 
        {
            // j'assemble mon lien de redirection
            $urlValidate = 'http://localhost/Projet_perso/oBlog/Frontend/public/validation?id='.$author->getId().'&token='.$token;
            // Envoi d'un mail de confirmation
            $mail = new PHPMailer(true);// true active les exceptions
            //Server settings
            // debbug : 
            //$mail->SMTPDebug = 2; // 1 = Erreurs et messages, 2 = messages seulement
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true; // activer l'authentification
            $mail->Username = 'rachel.oblog@gmail.com';// mail hote
            $mail->Password = 'ki.gu?ru@mi';// mdp hote
            $mail->SMTPSecure = 'ssl'; // encryptage
            $mail->Port = 465;// 587 ou 465 (pour google 465 == sécurisé)
        
            //Recipients
            $mail->setFrom('rachel.oblog@gmail.com', 'oBlog');
            $mail->addAddress($author->getEmail(), $author->getName());
        
            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Validation de votre compte oBlog';
            $mail->Body    = 'Bonjour '.$author->getName().', et bienvenu sur oBlog ! <br/> Veuillez cliquer sur ce lien pour valider votre compte: <br/> <a href="'.$urlValidate.'"> Lien vers oBlog </a>';
        
            if(!$mail->Send()) {
                $this->sendError('Une erreur est survenue lors de l\'envoi du mail.');
                // debbug : 
                //echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            }
            else
            {
                $array_json['success']['mail'] = true;
                $this->showJson($array_json);
            }
        } 
        else 
        {
            // sinon la clef = false + message d'erreur, fin du programme
            $this->sendError('Une erreur est survenue lors de l\'inscription, veuillez recommencer.');
        }
    }

    public function validateAccount() {
        $datas = [
            'id'    => isset($_GET['id'])    ? trim(strip_tags((int)$_GET['id'])) : '',
            'token' => isset($_GET['token']) ? trim(strip_tags($_GET['token']))   : '',
        ];
        // je vérifie que les data reçu ne soient pas vide
        $this->notEmptyDatas($datas);

         // je cherche l'auteur par son id
        $authorFind = Author::getOne($datas['id']);
        // si je ne le trouve pas
        if (!$authorFind)
        {
            $this->sendError('Compte inexistant');
        }
        // vérification status : 0 = inactif, 1 = actif
        if ($authorFind->getStatus() !== '0') 
        {
            $this->sendError('Le compte a déjà été activé');
        }
        // vérification token
        if ($datas['token'] !== $authorFind->getToken()) 
        {
            $this->sendError('Une erreur est survenue');
        }
        if(!Author::activate($datas['id']))
        {
            $this->sendError('Une erreur est survenue');
        }

        // j'active ma session 
        $this->addUserInSession($authorFind);
        // je récupère les catégories
        $this->addCategoryInSession();

        $array_json['success'] = true;
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
            $this->sendError('Compte inexistant');
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

    public function lostPass() {
        $data['email'] = isset($_GET['email']) ? trim(strip_tags($_GET['email'])) : '';
        // je vérifie que les data reçu ne sont pas vide
        $this->notEmptyDatas($data);

        // je cherche l'auteur par son mail
        $authorFind = Author::getOneByEmail($data['email']);

        // si je ne le trouve pas
        if (!$authorFind)
        {
            $this->sendError('Compte inexistant');
        }
        // je vérifie que son status sois actif (1)
        $status = $authorFind->getStatus();
        if ($status !== '1') 
        {
            $this->sendError('Le compte a été desactivé');
        }
        // création token et ajout au tableau de data 
        $token = bin2hex(random_bytes(32));
        // je test l'insertion du token en bdd
        if (Author::insertToken($data['email'], $token)) 
        {
            // j'assemble mon lien de redirection
            $urlNewPass = 'http://localhost/Projet_perso/oBlog/Frontend/public/reinitialisation-mot-de-passe?id='.$authorFind->getId().'&token='.$token;
            // Envoi d'un mail de confirmation
            $mail = new PHPMailer(true);// true active les exceptions
            //Server settings
            // debbug : 
            //$mail->SMTPDebug = 2; // 1 = Erreurs et messages, 2 = messages seulement
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true; // activer l'authentification
            $mail->Username = 'rachel.oblog@gmail.com';// mail hote
            $mail->Password = 'ki.gu?ru@mi';// mdp hote
            $mail->SMTPSecure = 'ssl'; // encryptage
            $mail->Port = 465;// 587 ou 465 (pour google 465 == sécurisé)
        
            //Recipients
            $mail->setFrom('rachel.oblog@gmail.com', 'oBlog');
            $mail->addAddress($authorFind->getEmail(), $authorFind->getName());
        
            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Changer de mot de passe';
            $mail->Body    = 'Bonjour '.$authorFind->getName().'<br/> Veuillez cliquer sur ce lien pour changer votre mot de passe oBlog : <br/> <a href="'.$urlNewPass.'"> Lien vers oBlog </a>';
        
            if(!$mail->Send()) {
                $this->sendError('Une erreur est survenue lors de l\'envoi du mail.');
                // debbug : 
                //echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            }
            else
            {
                $array_json['success'] = true;
                $this->showJson($array_json);
            }
        } 
        else 
        {
            $this->sendError('Une erreur est survenue lors de l\'inscription, veuillez recommencer.');
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
        $this->notEmptyDatas($datas);
        // je récupère l'auteur
        $authorFind = Author::getOne($datas['id']);
        if (!$authorFind)
        {
            $this->sendError('Compte inexistant');
        }
        // je test le token
        $tokenAuthor = $authorFind->getToken();
        if($tokenAuthor !== $datas['token']) 
        {
            $this->sendError('Une erreur est survenue');
        }
        // je test l'intégrité du mdp
        $this->passwordIntegrity($datas['password'], $datas['passConfirm']);
        // je rajoute un salt au mdp
        $datas['password'] .= $this->salt;
        // je hash le mdp
        $datas['password'] = password_hash($datas['password'], PASSWORD_DEFAULT);
        // j'enregistre le nouveau mdp dans la bdd
        if(!Author::updatePassword($datas['id'], $datas['password']))
        {
            $this->sendError('Une erreur est survenue');
        }
        // je supprime le token
        Author::insertToken($authorFind->getEmail(), '0');

        $array_json['success'] = true;
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