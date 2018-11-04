<?php

class BlogController extends CoreController
{
    // j'appel show pour afficher la page blog
    public function blog()
    {
        $this->oTemplator->setVar('allPost', $this->dbdata->getAllPost());
        $this->show('blog');
    }

     // j'appel show pour afficher la page d'une catégorie
    public function category($params = array()) 
    {
        $listPost = $this->dbdata->getAllPostFromCategory($params['id']);
        if(!empty($listPost)) 
        {
            $this->oTemplator->setVar('postFromCategory', $listPost);
        }
        //$this->oTemplator->setVar('postFromCategory', $this->dbdata->getAllPostFromCategory($params['id']));
        $this->show('category', $params);
    }

     // j'appel show pour afficher la page d'un auteur
    public function author($params = array()) 
    {
        $listPost = $this->dbdata->getAllPostFromAuthor($params['id']);
        if(!empty($listPost)) 
        {
            $this->oTemplator->setVar('postFromAuthor', $listPost);
        }
        $this->show('author', $params);
    }
}