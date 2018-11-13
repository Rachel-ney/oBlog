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
        /* à tester : */
        $this->router->map('POST', '/add-update-post', 'PostController#addOrUpdate', 'addPost');
        /* méthode à créer : */
        //$this->router->map('POST', '/delete-post', 'PostController#delete', 'deletePost');
        
        // CategoryController
        $this->router->map('GET', '/all-category', 'CategoryController#all', 'allCategory');
        /* méthode à créer : */
        //$this->router->map('POST', '/add-update-category', 'CategoryController#addOrUpdate', 'addCategory');
        //$this->router->map('POST', '/delete-category', 'CategoryController#delete', 'deleteCategory');
        
        // AuthorController
        $this->router->map('GET', '/all-author', 'AuthorController#all', 'allAuthor');
        /* à tester : */
        $this->router->map('POST', '/add-author', 'AuthorController#add', 'addAuthor');
        $this->router->map('POST', '/update-author', 'AuthorController#update', 'updateAuthor');
        /* méthode à créer : */
        //$this->router->map('POST', '/delete-author', 'AuthorController#delete', 'deleteAuthor');
    }
}