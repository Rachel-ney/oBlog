<?php
namespace oBlog;

class Application 
{
    private $router;

    public function __construct() 
    {
        // Lancer AltoRouter
        $this->router = new \AltoRouter();
        // Récuperation de BASE_URI
        $baseUrl = isset($_SERVER['BASE_URI']) ? trim($_SERVER['BASE_URI']) : '/';
        // Définition de la BASE_URI pour AltoRouter
        $this->router->setBasePath($baseUrl);
        // Appel de la fonction pour générer les routes
        $this->defineRoutes();
    }

    public function run()
    {
        // Recherche d'une correspondance avec l'url appelé
        $match = $this->router->match();

        if ($match)
        {
            list($controllerName, $methodName) = explode('#', $match['target']);
            $params = $match['params'];
        }
        else 
        {
            $controllerName = 'MainController';
            $methodName = 'Error404';
            $params = array();
        }

        // redefinition du nom du controller avec le namespace
        // on parle alors de FQCN (= Fully Qualified Class Name)
        $controllerName = '\oBlog\Controllers\\'.$controllerName;
        // on instancie le controller
        $myController = new $controllerName($this->router);
        // on appelle la méthode
        $myController->$methodName($params);
    }

    private function defineRoutes()
    {
        // mapping des route
        $this->router->map('GET', '/', 'MainController#home', 'home');
        $this->router->map('GET', '/connexion-inscription', 'MainController#signIn', 'signIn');
        $this->router->map('GET', '/me-contacter', 'MainController#contact', 'contact');
        $this->router->map('GET', '/qui-suis-je', 'MainController#aboutUs', 'aboutUs');
        $this->router->map('GET', '/mentions-legales', 'MainController#legalMention', 'legalMention');
        $this->router->map('GET', '/le-blog', 'BlogController#blog', 'blog');
        $this->router->map('GET', '/article/[i:id]', 'BlogController#post', 'post');
        $this->router->map('GET', '/categorie/[i:id]', 'BlogController#category', 'category');
        $this->router->map('GET', '/auteur/[i:id]', 'BlogController#author', 'author');        
    }
}