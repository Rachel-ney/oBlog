<?php
namespace oBlogApi;

class Application 
{
    private $router;

    public function __construct() 
    {
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
            $controllerName = 'MainController';
            $methodName = 'Error404';
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
        $this->router->map('POST', '/add-post', 'PostController#add', 'addPost');
        $this->router->map('POST', '/update-post', 'PostController#update', 'updatePost');
        // CategoryController
        $this->router->map('GET', '/all-category', 'CategoryController#all', 'allCategory');
        $this->router->map('GET', '/all-post-by-category/[i:id]', 'CategoryController#allPostByCategory', 'postByCategory');
        $this->router->map('POST', '/add-category', 'CategoryController#add', 'addCategory');
        $this->router->map('POST', '/update-category', 'CategoryController#update', 'updateCategory');
        // AuthorController
        $this->router->map('GET', '/all-author', 'AuthorController#all', 'allAuthor');
        $this->router->map('GET', '/all-post-by-author/[i:id]', 'AuthorController#allPostByAuthor', 'postByAuthor');
        $this->router->map('POST', '/add-author', 'AuthorController#add', 'addAuthor');
        $this->router->map('POST', '/update-author', 'AuthorController#update', 'updateAuthor');
    }
}