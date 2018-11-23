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
    
    // Méthode pour récuperer UN auteur et renvoyer ses info
    public function one($param) 
    {
        // je récupère tout les posts de ma bdd sous forme d'objet
        $oneAuthor = Author::getOneById($param['id']);

        // si la bdd ne m'a rien renvoyé
        if(empty($oneAuthor)) 
        {
            //  message d'erreur , fin du programme
            $array_json['success'] = false;
            $array_json['msg'] = 'La bdd n\'a retourné aucun résultat';
            $this->showJson($array_json);
            die();
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

    // Méthode pour ajouter / modifier un auteur en bdd
    public function add() 
    {
        // je récupère les data
        // j'elimine les espaces (trim) et les balises(strip_tags)
        $datas = [
            'Name'  => isset($_POST['name'])  ? strip_tags(trim($_POST['name']))  : '',
            'Password' => isset($_POST['password']) ? trim($_POST['password']) : '',
            'Pass_confirm' => isset($_POST['pass_confirm']) ? trim($_POST['pass_confirm']) : '',
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
            $array_json['msg'] = 'Cette adresse mail est déjà enregistré';
            $this->showJson($array_json);
            die();
        }

        // je vérifie que le mdp et la confirmation du mdp soient identiques
        if ($datas['Password'] !== $datas['Pass_confirm']) 
        {
            // message d'erreur, fin du programme
            $array_json['success'] = false;
            $array_json['msg'] = 'Les mots de passe doivent êtres identiques';
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
        // je rajoute un salt au mdp
        $salt = 'My.Favorite.Pony.Is:Pinkie-Pie!';
        $datas['Password'] .= $salt;
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
            // et j'active ma session en stockant l'id du nouvel auteur
            $array_json['success'] = true;
            $idAuthor = $author->getId();
            $_SESSION['user'] = $author->getId();
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
            'Id' => isset($_SESSION['user'])  ? strip_tags(trim($_SESSION['user']))  : '',
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

    public function connexion() {
        // je récupère les data
        // j'elimine les espaces (trim)
        $datas = [
            'Password' => isset($_GET['password']) ? trim($_GET['password']) : '',
            'Email' => isset($_GET['email']) ? trim($_GET['email']) : '',
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

        // je cherche l'auteur par son mail
        $authorFind = Author::getOneByEmail($datas['Email']);
        // si je ne le trouve pas
        if (!$authorFind)
        {
            // message d'erreur, fin du programme
            $array_json['success'] = false;
            $array_json['msg'] = 'Identifiant ou mot de passe invalide';
            $this->showJson($array_json);
            die();
        }
        // si j'en trouve un
        else 
        {
            $status = $authorFind->getStatus();

            if ($status !== '1') 
            {
                // message d'erreur, fin du programme
                $array_json['success'] = false;
                $array_json['msg'] = 'Identifiant ou mot de passe invalide';
                $this->showJson($array_json);
                die();
            }
            // je rajoute le salt que j'avais défini à l'inscription
            $salt = 'My.Favorite.Pony.Is:Pinkie-Pie!';
            $datas['Password'] .= $salt;
            $hash = $authorFind->getPassword();
            // si le mdp donné correspond à celui stocké en bdd
            if (password_verify($datas['Password'], $hash)) 
            {
                // j'active la session et enregistre son id
                $array_json['success'] = true;
                $_SESSION['user'] = [
                    'id' => $authorFind->getId(),
                    'name' => $authorFind->getName(),
                    'email' => $authorFind->getEmail()
                ];
                $allPost = Post::getAllPostBy('author', $_SESSION['user']['id']);

                if(!empty($allPost))
                {
                    foreach($allPost as $post)
                    {
                        $_SESSION['user']['posts'][] = [
                            'id'         => $post->getId(),
                            'title'      => $post->getTitle(),
                            'resume'     => $post->getResume(),
                            'content'    => $post->getContent(),
                            'category'   => $post->getCategoryName(),
                            'created_at' => $post->getCreatedAt(),
                            'updated_at' => $post->getUpdatedAt()
                        ];
                    }
                }
            }
            // si les mot de passes sont différents
            else 
            {
                // message d'erreur, fin du programme
                $array_json['success'] = false;
                $array_json['msg'] = 'Identifiant ou mot de passe invalide';
                $this->showJson($array_json);
                die();
            }
        }
        
        // je rempli mon tableau de réponse : 
        $array_json['author'] = [
            'id'            => $authorFind->getId(),
            'name'          => $authorFind->getName(),
            'email'         => $authorFind->getEmail(),
            'created_at'    => $authorFind->getCreatedAt(),
            'updated_at'    => $authorFind->getUpdatedAt(),
        ];
        // j'envoi le tableau à showJson
        $this->showJson($array_json);
    }

    public function desactivate() {

        $password = isset($_GET['password']) ? trim($_GET['password']) : '';
        $id = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : '';

        if(empty($password) || empty($id)) 
        {
            // message d'erreur, fin du programme
            $array_json['success'] = false;
            $_SESSION['error'] = 'Une erreur est survenue';
            $this->showJson($array_json);
            die();
        }

        $authorFind = Author::getOneById($id);

        if(empty($authorFind))
        {
            // message d'erreur, fin du programme
            $array_json['success'] = false;
            $_SESSION['error'] = 'Une erreur est survenue';
            $this->showJson($array_json);
            die();
        }

        $hash = $authorFind->getPassword();
        $salt = 'My.Favorite.Pony.Is:Pinkie-Pie!';
        $password.= $salt;
        
        // si le mdp donné correspond à celui stocké en bdd
        if (!password_verify($password, $hash))
        {
            // message d'erreur, fin du programme
            $array_json['success'] = false;
            $_SESSION['error'] = 'Mot de passe incorrect';
            $this->showJson($array_json);
            die();
        }

        $desactivate = Author:: desactivate($id);

        if($desactivate)
        {
            // message d'erreur, fin du programme
            $array_json['success'] = true;
            session_unset();
            $this->showJson($array_json);
        }
        else 
        {
            // message d'erreur, fin du programme
            $array_json['success'] = false;
            $_SESSION['error'] = 'Une erreur est survenue';
            $this->showJson($array_json);
            die();
        }





    }
}