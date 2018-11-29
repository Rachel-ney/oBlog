<?php
namespace oBlogApi\Controllers;
use PDO;
use oBlogApi\Utils\Database;
use oBlogApi\Models\Category;
use oBlogApi\Models\Post;

// classe parente des controller
abstract class CoreController 
{
    protected $router;
    protected $salt = 'My.Favorite.Pony.Is:Pinkie-Pie!';
    protected $msgPassword = '';

    public function __construc($router) {
        $this->router = $router;
    }
    // affiche la réponse en JSON
    protected function showJson($data)
    {
        // Autorise l'accès à la ressource depuis n'importe quel autre domaine
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Credentials: true');
        // Dit au navigateur que la réponse est au format JSON
        header('Content-Type: application/json');
        // La réponse en JSON est affichée
        echo json_encode($data);
    }

    protected function notEmptyDatas($array) {

        foreach ($array as $currentIndex) 
        {
            // si vide
            if(empty($currentIndex)) 
            {
                $this->sendError('Vous ne pouvez pas laisser de champs vide');
            }
        }
    }

    protected function passwordIntegrity($pass, $passConfirm) {
        // je vérifie que le mdp et la confirmation du mdp soient identiques
        if ($pass !== $passConfirm) 
        {
            $this->sendError('Le nouveau mot de passe et sa confirmation doivent êtres identiques', true);
        }
        // je vérifie que mon mot de passe fasse bien 8 caractère ou plus
        if (strlen($pass) < 8 )
        {
            $this->sendError('Le mot de passe doit contenir au moins 8 caractères', true);
        }
        // je vérifie que le mot de passe contienne bien maj, min, chiffre et . ou ? ou ! ou _ (1x ou plus)
        $regexPass = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[.?!_])/';
        if (!preg_match($regexPass, $pass))
        {
            $this->sendError('Le mot de passe doit contenir au moins 8 caractères dont une majuscule, une minuscule, un chiffre et un des caractère suivant _ ? . !', true);
        }
    }

    protected function addUserInSession($author) {
        $_SESSION['user'] = [
            'id' => $author->getId(),
            'name' => $author->getName(),
            'email' => $author->getEmail()
        ];
    }

    protected function addPostAuthorInSession() {
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
    }

    protected function addCategoryInSession() {
        $allCategory = Category::getAll();

        if(!empty($allCategory))
        {
            foreach($allCategory as $category)
            {
                $_SESSION['category'][$category->getId()] = $category->getName();
            }
        }
    }

    protected function sendError($message, $password = false) {

        if($password)
        {
            $array_json['msg']['pass'] = $message;
        }
        else 
        {
            $array_json['msg'] = $message;
        }
        $array_json['success'] = false;
        $this->showJson($array_json);
        die();
    }

}