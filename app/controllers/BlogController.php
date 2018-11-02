<?php

class BlogController extends CoreController
{
    // j'appel show pour afficher la page blog
    public function blog()
    {
        // $characterList = $this->dbdata->getAllCharacters();
        $this->oTemplator->setVar('articles', $this->data['articles']);
        $this->oTemplator->setVar('authors', $this->data['authors']);
        $this->show('blog');
    }

     // j'appel show pour afficher la page d'une catégorie
    public function category($params = array()) 
    {
        $this->show('category', $params);
    }

     // j'appel show pour afficher la page d'un auteur
    public function author($params = array()) 
    {
        $this->oTemplator->setVar('authors', $this->data['authors']);
        $this->show('author', $params);
    }
}