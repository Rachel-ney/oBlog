<?php
namespace oBlog\Controllers;
use oBlog\Models\Post;
use oBlog\Models\Author;
use oBlog\Models\Category;

class MainController extends CoreController
{
    // j'appel show pour afficher la home
    public function home()
    {
        // test getAll();
        $allPost = Post::getAll();
        dump($allPost);
        $allAuthor = Author::getAll();
        dump($allAuthor);
        $allCategory = Category::getAll();
        dump($allCategory);

        // test getOne($id);
        $onePost = Post::getOne(1);
        dump($onePost);
        $oneAuthor = Author::getOne(4);
        dump($oneAuthor);
        $oneCategory = Category::getOne(3);
        dump($oneCategory);

        // test delete($id);
        $deletePost = Post::delete(5);
        dump($deletePost);
        $deleteAuthor = Author::delete(5);
        dump($deleteAuthor);
        $deleteCategory = Category::delete(4);
        dump($deleteCategory);

        // test getAll();
        $allPost = Post::getAll();
        dump($allPost);
        $allAuthor = Author::getAll();
        dump($allAuthor);
        $allCategory = Category::getAll();
        dump($allCategory);

        $this->show('home');
    }

    // j'appel show pour afficher la page d'inscription / connexion
    public function signIn()
    {
        $this->show('signIn');
    }

    // j'appel show pour les contact
    public function contact()
    {
        $this->show('contact');
    }

    // j'appel show pour la page qui suis-je ?
    public function aboutUs()
    {
        $this->show('aboutUs');
    }

    // j'appel show pour la page mention légales
    public function legalMention()
    {
        $this->show('legalMention');
    }

    // j'appel show pour la page error 404
    public function error404()
    {
        $this->show('error404');
    }

}