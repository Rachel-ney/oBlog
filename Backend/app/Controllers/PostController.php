<?php
namespace oBlogApi\Controllers;
use oBlog\Models\Post;

class PostController extends CoreController
{
    public function all() 
    {
        // je récupère tout les posts de ma bdd sous forme d'objet
        $allPost = Post::getAll();

        // si la bdd ne m'a rien renvoyé
        if(empty($allPost)) 
        {
            // j'envoi un message d'erreur et je stoppe tout
            $array_json['msg'] = 'La bdd n\'a retourné aucun résultat';
            $this->showJson($array_json);
            die();
        }

        // je déclare le tableau qui contiendra touts les posts
        $allPostForJson = array();
        // je rempli le tableau : 
        foreach( $allPost as $index => $object) 
        {
            $allPostForJson[$index] = [
                'id'            => $object->getId(),
                'title'         => $object->getTitle(),
                'resume'        => $object->getResume(),
                'content'       => $object->getContent(),
                'authorId'      => $object->getAuthorId(),
                'categoryId'    => $object->getCategoryId(),
                'authorName'    => $object->getAuthorName(),
                'categoryName'  => $object->getCategoryName(),
                'created_at'    => $object->getCreatedAt(),
                'updated_at'    => $object->getUpdatedAt(),
            ];
        }
        // j'ajoute le tableau à ma réponse json : 
        $array_json = [
            'allPost' => $allPostForJson,
            'success' => true,
        ];
        // j'envoi le tableau à showJson
        $this->showJson($array_json);
    }

    public function one($id) 
    {
        // je récupère mon post de la bdd sous forme d'objet
        $post = Post::getOne();

        // si la bdd ne m'a rien renvoyé
        if(empty($post)) 
        {
            $array_json['msg'] = 'L\'article demandé n\'existe pas';
            $this->showJson($array_json);
            die();
        }
        // je déclare mon tableau de réponse
        $array_json = array();
        // je rempli le tableau json : 
            $array_json = [
                'post' => [
                    'id'            => $postForJson->getId(),
                    'title'         => $postForJson->getTitle(),
                    'resume'        => $postForJson->getResume(),
                    'content'       => $postForJson->getContent(),
                    'authorId'      => $postForJson->getAuthorId(),
                    'categoryId'    => $postForJson->getCategoryId(),
                    'authorName'    => $postForJson->getAuthorName(),
                    'categoryName'  => $postForJson->getCategoryName(),
                    'created_at'    => $postForJson->getCreatedAt(),
                    'updated_at'    => $postForJson->getUpdatedAt(),
                ],
                'success' => true,
            ];
        // j'envoi le tableau à showJson
        $this->showJson($array_json);
    }

    public function add() 
    {

    }
    public function update($id) 
    {
        
    }
}