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
    public function category() 
    {
        $this->oTemplator->setVar('js', 'category');
        $this->show('category');
    }

     // j'appel show pour afficher la page d'un auteur
    public function author() 
    {
        $this->oTemplator->setVar('js', 'author');
        $this->show('author');
    }

    // j'appel show pour afficher la page d'un article
    public function post()
    {
        $this->oTemplator->setVar('js', 'post');
        $this->show('post');
    }
}