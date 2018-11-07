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
        // test delete($id);
        // $deletePost = Post::delete(5);
        // dump($deletePost);
        // $deleteAuthor = Author::delete(5);
        // dump($deleteAuthor);
        // $deleteCategory = Category::delete(5);
        // dump($deleteCategory);

        // test insert() de la classe Author
        $user = new Author();
        $user->setName('User');
        $user->setImage('myPictureUser.jpg');
        $user->setEmail('user@email.fr');
        dump($user);
        //$addUser = Author::insert($user);

        // test insert() de la classe Post
        $post = new Post();
        $post->setTitle('Comment j\'ai ajouté un nouvel article');
        $post->setResume('C\'était un soir de pleine lune, en arrosant mes fleurs un rayon de lune m\'a frappé !');
        $post->setContent(' Lorem ipsum dolor sit amet consectetur, adipisicing elit. Odio possimus nesciunt non et sapiente numquam minus temporibus eum corrupti perferendis! ');
        $post->setAuthorId(3);
        $post->setCategoryId(2);
        dump($post);
        //$addPost = Post::insert($post);

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