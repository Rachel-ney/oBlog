<?php
namespace oBlogApi\Controllers;
use oBlogApi\Models\Post;
use oBlogApi\Models\Category;
use oBlogApi\Models\Author;

class PostController extends CoreController
{
    // Méthode pour récuperer UN post et l'envoyer en json
    public function one($params) 
    { 
        // je vérifie que l'id tramsmi n'est pas vide , j'elimine les espaces (trim) et les balises(strip_tags)
        // 
        //isset($_POST['id']) ? strip_tags(trim($_POST['id'])) : '';
        $postId = $params['id'];
        // si le nom est vide 
        if (empty($postId)) 
        {
            // message d'erreur, fin du programme
            $array_json['msg'] = 'Merci de renseigner un id';
            $this->showJson($array_json);
            die();
        }
        // je récupère mon post de la bdd sous forme d'objet
        $post = Post::getOne($postId);

        // si la bdd ne m'a rien renvoyé
        if(empty($post)) 
        {
            // message d'erreur, fin du programme
            $array_json['msg'] = 'L\'article demandé n\'existe pas';
            $this->showJson($array_json);
            die();
        }
        // je rempli mon tableau de réponse :
            $array_json = [
                'post' => [
                    'id'            => $post->getId(),
                    'title'         => $post->getTitle(),
                    'resume'        => $post->getResume(),
                    'content'       => $post->getContent(),
                    'authorId'      => $post->getAuthorId(),
                    'categoryId'    => $post->getCategoryId(),
                    'authorName'    => $post->getAuthorName(),
                    'categoryName'  => $post->getCategoryName(),
                    'created_at'    => $post->getCreatedAt(),
                    'updated_at'    => $post->getUpdatedAt(),
                ],
                'success' => true,
            ];
        // j'envoi le tableau à showJson
        $this->showJson($array_json);
    }

    // Méthode pour récuperer TOUT les post et les envoyer en json
    public function all() 
    {
        // je récupère tout les posts de ma bdd sous forme d'objet
        $allPost = Post::getAll();

        // si la bdd ne m'a rien renvoyé
        if(empty($allPost)) 
        {
            //  message d'erreur , fin du programme
            $array_json['msg'] = 'La bdd n\'a retourné aucun résultat';
            $this->showJson($array_json);
            die();
        }

        // je déclare le tableau qui contiendra touts les posts
        $allPostForJson = array();
        // je rempli le tableau : 
        foreach( $allPost as $index => $currentObject) 
        {
            $allPostForJson[$index] = [
                'id'            => $currentObject->getId(),
                'title'         => $currentObject->getTitle(),
                'resume'        => $currentObject->getResume(),
                'content'       => $currentObject->getContent(),
                'authorId'      => $currentObject->getAuthorId(),
                'categoryId'    => $currentObject->getCategoryId(),
                'authorName'    => $currentObject->getAuthorName(),
                'categoryName'  => $currentObject->getCategoryName(),
                'created_at'    => $currentObject->getCreatedAt(),
                'updated_at'    => $currentObject->getUpdatedAt(),
            ];
        }
        // j'ajoute le tableau à ma réponse json : 
        $array_json = [
            'post' => $allPostForJson,
            'success' => true,
        ];
        // j'envoi le tableau à showJson
        $this->showJson($array_json);
    }

    // Méthode pour récuperer TOUT les POST d'un auteur OU d'une category
    public function allPostBy($params) 
    {
        // isset($_POST['idCategory']) ? strip_tags(trim($_POST['idCategory'])) : '';
        $id = $params['id'];
        // si id vide
        if(empty($id)) 
        {
            // message d'erreur, fin du programme
            $array_json['msg'] = 'Veuillez préciser l\'identifiant de la catégorie ou de l\'auteur choisi';
            $this->showJson($array_json);
            die();
        }
        $by = $params['action'];
        // si action vide
        if($by !== 'category' && $by !== 'author') 
        {
            // message d'erreur, fin du programme
            $array_json['msg'] = 'Erreur de syntaxe : /all-post-by/author/id ou /all-post-by/category/id. id étant un integer';
            $this->showJson($array_json);
            die();
        }
        // je récupère tout les posts de ma bdd sous forme d'objet
        $allPostBy = Post::getAllPostBy($by, $id);

        // si la bdd ne m'a rien renvoyé
        if(empty($allPostBy)) 
        {
            //  message d'erreur , fin du programme
            $array_json['msg'] = 'La bdd n\'a retourné aucun résultat';
            $this->showJson($array_json);
            die();
        }

        // je déclare le tableau qui contiendra tout les posts
        $forJson = array();
        // je rempli le tableau : 
        foreach( $allPostBy as $index => $currentObject) 
        {
            $forJson[$index] = [
                'id'            => $currentObject->getId(),
                'title'         => $currentObject->getTitle(),
                'resume'        => $currentObject->getResume(),
                'content'       => $currentObject->getContent(),
                'authorId'      => $currentObject->getAuthorId(),
                'categoryId'    => $currentObject->getCategoryId(),
                'authorName'    => $currentObject->getAuthorName(),
                'categoryName'  => $currentObject->getCategoryName(),
                'created_at'    => $currentObject->getCreatedAt(),
                'updated_at'    => $currentObject->getUpdatedAt(),
            ];
        }
        // j'ajoute le tableau à ma réponse json : 
        $array_json = [
            'post' => $forJson,
            'success' => true,
        ];
        // j'envoi le tableau à showJson
        $this->showJson($array_json);
    }

    // Méthode pour ajouter / modifier un post en bdd
    public function addOrUpdate() 
    {
        // je récupère la variable qui détermine si l'action sera de type add ou de type update
        $insertOrUpdate = isset($_POST['action']) ? strip_tags(trim($_POST['action'])) : '';
        // si vide
        if(empty($insertOrUpdate)) 
        {
            // message d'erreur, fin du programme
            $array_json['success'] = false;
            $array_json['msg'] = 'Une erreur est survenue';
            $this->showJson($array_json);
            die();
        }
        // si la méthode renseigné n'est pas update ou insert
        if ($insertOrUpdate !== 'update' && $insertOrUpdate !== 'insert') {
            // message d'erreur, fin du programme
            $array_json['success'] = false;
            $array_json['msg'] = 'Une erreur est survenue';
            $this->showJson($array_json);
            die();
        }
        // si la méthode choisi est update 
        if ($insertOrUpdate === 'update') 
        {
            // je récupère l'id de l'article à modifier
            $idPostToUpdate = isset($_POST['post_id']) ? strip_tags(trim((int)$_POST['post_id'])) : '';
            // si id vide
            if(empty($idPostToUpdate)) 
            {
                // message d'erreur, fin du programme
                $array_json['success'] = false;
                $array_json['msg'] = 'Une erreur est survenue';
                $this->showJson($array_json);
                die();
            }
        }
        // je récupère les data
        // j'elimine les espaces (trim) et les balises(strip_tags)
        $datas = [
            'Title'      => isset($_POST['title'])         ? strip_tags(trim($_POST['title']))         : '',
            'Resume'     => isset($_POST['resume'])        ? strip_tags(trim($_POST['resume']))        : '',
            'Content'    => isset($_POST['content'])       ? strip_tags(trim($_POST['content']))       : '',
            'AuthorId'   => isset($_SESSION['user']['id']) ? strip_tags(trim($_SESSION['user']['id'])) : '',
            'CategoryId' => isset($_POST['category_id'])   ? strip_tags(trim((int)$_POST['category_id']))   : ''
        ];
        // je vérifie que les data reçu ne sont pas vide
        foreach ($datas as $dataName => $dataValue) 
        {
            // si vide
            if(empty($dataValue)) 
            {
                // message d'erreur, fin du programme
                $array_json['success'] = false;
                $array_json['msg'] = 'Vous ne pouvez pas laisser de champs vide';
                $this->showJson($array_json);
                die();
            }
        }
        // je vérifie que la catégorie reçu existe bien 
        $categoryExist = Category::getOne($datas['CategoryId']);

        if(!$categoryExist)
        {
            // message d'erreur, fin du programme
            $array_json['success'] = false;
            $array_json['msg'] = 'Cette categorie n\'existe pas';
            $this->showJson($array_json);
            die();
        }
        // Je créer une instance de post
        $post = new Post();
        // je lui donne les data à ajouter : 
        foreach ($datas as $dataName => $dataValue) 
        {
            $setterName = 'set'.$dataName;
            $post->$setterName($dataValue);
        }
        // si la méthode choisi est update 
        if ($insertOrUpdate === 'update') 
        {
            // je lui donne aussi l'id
            $post->setId($idPostToUpdate);
        }
        
        // je test l'insertion ou la modification en bdd
        if ($post->$insertOrUpdate()) 
        {
            // si insertion / update ok j'ajoute une clef true à transmettre
            $array_json['success'] = true;
            if ($insertOrUpdate === 'update') 
            {
                $_SESSION['success']['addPost'] = 'Votre article a bien été modifié';
            }
            else
            {
                $_SESSION['success']['addPost'] = 'Votre article a bien été ajouté';
            }
            // je met à jours la liste d'article de l'auteur contenu en session
            unset($_SESSION['user']['posts']);
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
                        'category'   => [
                            'id'=> $post->getCategoryId(),
                            'name' => $post->getCategoryName()
                        ],
                        'created_at' => $post->getCreatedAt(),
                        'updated_at' => $post->getUpdatedAt()
                    ];
                }
            }
            $this->showJson($array_json);
        } 
        else 
        {
            // sinon la clef = false + message d'erreur, fin du programme
            $array_json['success'] = false;
            $array_json['msg'] = 'Une erreur est survenue';
            $this->showJson($array_json);
            die();
        }
    }

    public function delete() {
        // je récupère les données
        $datas = [
            'idAuthor'   => isset($_SESSION['user']['id']) ? (int)$_SESSION['user']['id']             : '',
            'idPost'     => isset($_POST['post_id'])       ? strip_tags(trim((int)$_POST['post_id'])) : '',
            'password'   => isset($_POST['password'])      ? strip_tags(trim($_POST['password']))     : '',
        ];
    
        //je vérifie qu'elles ne soient pas vide
        foreach($datas as $value)
        {
            if (empty($value))
            {
                // sinon la clef = false + message d'erreur, fin du programme
                $array_json['success'] = false;
                $array_json['msg'] = 'Vous ne pouvez pas laisser de champs vide';
                $this->showJson($array_json);
                die();
            }
        }

        $authorExist = Author::getOne($datas['idAuthor']);
        if (!$authorExist)
        {
            // sinon la clef = false + message d'erreur, fin du programme
            $array_json['success'] = false;
            $array_json['msg'] = 'Une erreur est survenu';
            $this->showJson($array_json);
            die();
        }

        // et son mot de passe
        $hash = $authorExist->getPassword();
        $datas['password'].= $this->salt;
        // pour le comparer au mot de passe entré par l'utilisateur
        if (!password_verify($datas['password'], $hash))
        {
            // sinon la clef = false + message d'erreur, fin du programme
            $array_json['success'] = false;
            $array_json['msg']['pass'] = 'Mot de passe incorect';
            $this->showJson($array_json);
            die();
        }

        // je récupère le post d'après l'id du post ET l'id de l'auteur
        $postToAuthor = Post::getOnePostFromAuthor($datas['idPost'], $datas['idAuthor']);

        if (!$postToAuthor)
        {
            // sinon la clef = false + message d'erreur, fin du programme
            $array_json['success'] = false;
            $array_json['msg'] = 'Une erreur est survenu';
            $this->showJson($array_json);
            die();
        }

        // je supprime le post lié à l'auteur
        if(Post::delete($datas['idPost'], $datas['idAuthor']))
        {
            $array_json['success'] = true;
            $_SESSION['success']['deletePost'] = 'Votre article a bien été supprimé';
            // je met à jours la liste d'article de l'auteur contenu en session
            unset($_SESSION['user']['posts']);
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
                        'category'   => [
                            'id'=> $post->getCategoryId(),
                            'name' => $post->getCategoryName()
                        ],
                        'created_at' => $post->getCreatedAt(),
                        'updated_at' => $post->getUpdatedAt()
                    ];
                }
            }
            $this->showJson($array_json);
        }
        else 
        {
            // sinon la clef = false + message d'erreur, fin du programme
            $array_json['success'] = false;
            $array_json['msg'] = 'Une erreur est survenu';
            $this->showJson($array_json);
            die();
        }
    }
}// end class