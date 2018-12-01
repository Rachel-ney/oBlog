<?php
namespace oBlogApi;

class Application 
{
    private $router;

    public function __construct() 
    {
        session_start();
        // Lancer AltoRouter
        $this->router = new \AltoRouter();
        // Récuperation de BASE_URI
        $baseUrl = isset($_SERVER['BASE_URI']) ? trim($_SERVER['BASE_URI']) : '';
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
            $controllerName = 'ErrorController';
            $methodName = 'error404';
            $params = array();
        }

        // redefinition du nom du controller avec le namespace
        // on parle alors de FQCN (= Fully Qualified Class Name)
        $controllerName = '\oBlogApi\Controllers\\'.$controllerName;
        // on instancie le controller
        $myController = new $controllerName($this->router);
        // on appelle la méthode
        $myController->$methodName($params);
    }
    // mapping des route
    private function defineRoutes()
    {
        // PostController
        $this->router->map('GET', '/all-post', 'PostController#all', 'allPost');
        $this->router->map('GET', '/one-post/[i:id]', 'PostController#one', 'onePost');
        $this->router->map('GET', '/all-post-by/[a:action]/[i:id]', 'PostController#allPostBy', 'allPostBy'); // action = author ou category
        $this->router->map('POST', '/add-update-post', 'PostController#addOrUpdate', 'addPost');
        $this->router->map('POST', '/delete-post', 'PostController#delete', 'deletePost');
        
        // CategoryController
        $this->router->map('GET', '/all-category', 'CategoryController#all', 'allCategory');
        
        // AuthorController
        $this->router->map('GET', '/all-author', 'AuthorController#all', 'allAuthor');
        $this->router->map('GET', '/one-author-by-id/[i:id]', 'AuthorController#one', 'oneAuthor');
        $this->router->map('POST', '/add-author', 'AuthorController#add', 'addAuthor');
        $this->router->map('GET', '/validate-account', 'AuthorController#validateAccount', 'validateAccount');
        $this->router->map('POST', '/connexion', 'AuthorController#connexion', 'connexion');
        $this->router->map('POST', '/change-pass', 'AuthorController#changePass', 'changePass');
        $this->router->map('POST', '/desactivate', 'AuthorController#desactivate', 'desactivateAuthor');
    }
}