<?php
namespace oBlog\Controllers;

class BlogController extends CoreController
{
    // j'appel show pour afficher la page blog (qui contient tout les articles)
    public function blog()
    {
        $this->oTemplator->setVar('js', 'blog');
        $this->show('blog');
    }

     // j'appel show pour afficher la page d'une catégorie
    public function category($params) 
    {
        $this->oTemplator->setVar('js', 'category');
        $this->oTemplator->setVar('categoryId', $params['id']);
        $this->show('category');
    }

     // j'appel show pour afficher la page d'un auteur
    public function author($params) 
    {
        $this->oTemplator->setVar('js', 'author');
        $this->oTemplator->setVar('authorId', $params['id']);
        $this->show('author');
    }

    // j'appel show pour afficher la page d'un article
    public function post($params)
    {
        $this->oTemplator->setVar('js', 'post');
        $this->oTemplator->setVar('postId', $params['id']);
        $this->show('post');
    }
}