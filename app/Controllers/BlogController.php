<?php
namespace oBlog\Controllers;
use oBlog\Models\Post;
use oBlog\Models\Author;
use oBlog\Models\Category;

class BlogController extends CoreController
{
    // j'appel show pour afficher la page blog
    public function blog()
    {
        // je transmet tout les articles à templator
        // pas de vérification il y aura toujours des articles *genius* 
        $this->oTemplator->setVar('allPost', Post::getAll());
        $this->show('blog');
    }

     // j'appel show pour afficher la page d'une catégorie
    public function category($params = array()) 
    {
        // je récupère tout les articles d'UNE CATEGORIE
        $listPost = Post::getAllPostBy('category',$params['id']);
        // si le retour de la requête n'est pas vide (ex: catégorie jamais utilisé )
        if(!empty($listPost)) 
        {
            // je transmet tout les articles de la catégorie à templator
            $this->oTemplator->setVar('postFromCategory', $listPost);
        }
        $this->show('category', $params);
    }

     // j'appel show pour afficher la page d'un auteur
    public function author($params = array()) 
    {
        // je récupère tout les articles d'UN AUTEUR
        $listPost = Post::getAllPostBy('author', $params['id']);
         // si le retour de la requête n'est pas vide ( ex: auteur qui n'a jamais écris d'article)
        if(!empty($listPost)) 
        {
            // je transmet tout les articles de l'auteur à templator
            $this->oTemplator->setVar('postFromAuthor', $listPost);
        }
        $this->show('author', $params);
    }

    // j'appel show pour afficher la page d'un article
    public function post($params = array())
    {
        // je transmet l'article en question à templator
        // ici pas de vérification, les articles visible sur le site sont généré dynamiquement
        // donc si l'article apparait sur le site c'est forcément qu'il existe <-- merci captain obvious
        $this->oTemplator->setVar('post', Post::getOne($params['id']));
        $this->show('post');
    }
}