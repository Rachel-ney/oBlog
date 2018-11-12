<?php
namespace oBlog\Controllers;

class BlogController extends CoreController
{
    // j'appel show pour afficher la page de TOUT les articles
    public function blog()
    {
        $this->oTemplator->setVar('type', 'all');
        $this->oTemplator->setVar('js', 'post');
        $this->oTemplator->setVar('id', 0);
        $this->show('post');
    }
    // j'appel show pour afficher la page d'UN article
    public function post($params)
    {
        $this->oTemplator->setVar('type', 'one');
        $this->oTemplator->setVar('js', 'post');
        $this->oTemplator->setVar('id', $params['id']);
        $this->show('post');
    }
     // j'appel show pour afficher les articles d'une catégorie
    public function category($params) 
    {
        $this->oTemplator->setVar('type', 'category');
        $this->oTemplator->setVar('js', 'post');
        $this->oTemplator->setVar('id', $params['id']);
        $this->show('post');
    }

     // j'appel show pour afficher les articles d'un auteur
    public function author($params) 
    {
        $this->oTemplator->setVar('type', 'author');
        $this->oTemplator->setVar('js', 'post');
        $this->oTemplator->setVar('id', $params['id']);
        $this->show('post');
    }
}