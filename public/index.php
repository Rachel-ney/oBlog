<?php 
// Inclusion autoload de Composer
require __DIR__.'/../vendor/autoload.php';

//Inclusion de DBData

// Inclusion des controllers
require __DIR__.'/../app/controllers/CoreController.php';
require __DIR__.'/../app/controllers/MainController.php';
require __DIR__.'/../app/controllers/BlogController.php';

// Inclusion des models
require __DIR__.'/../app/models/Article.php';

// Inclusion des fichiers utils
require __DIR__.'/../app/utils/Templator.php';
require __DIR__.'/../app/utils/data.php';

// Instanciation altorouter
$router = new AltoRouter();

// Récupèration du chemin de base vers le dossier public 
$baseUrl = isset($_SERVER['BASE_URI']) ? $_SERVER['BASE_URI'] : '';

// on donne ce chemin à $router pour qu'il puisse travailler avec
$router->setBasePath($baseUrl);

// mapping des route
$router->map('GET', '/', 'MainController#home', 'home');
$router->map('GET', '/connexion-inscription', 'MainController#signIn', 'signIn');
$router->map('GET', '/me-contacter', 'MainController#contact', 'contact');
$router->map('GET', '/qui-suis-je', 'MainController#aboutUs', 'aboutUs');
$router->map('GET', '/mentions-legales', 'MainController#legalMention', 'legalMention');
$router->map('GET', '/le-blog', 'BlogController#blog', 'blog');
$router->map('GET', '/categorie/[i:id]', 'BlogController#category', 'category');
$router->map('GET', '/auteur/[i:id]', 'BlogController#author', 'author');


// si la route demandé existe dans le mapping, match() renvoi un tableau
// sinon match() renvoi false
$match = $router->match();

// si match n'a pas renvoyé false
if ($match) 
{
    // explode('p1', 'p2') renvoi un tableau
    $dispatcher = explode('#', $match['target']);

    // on récupère le contenu du premier index de dispatcher
    $controllerName = $dispatcher[0];

    // on récupère le contenu du deuxieme index de dispatcher
    $methodName = $dispatcher[1];

    // Instanciation du bon controller
    $controller = new $controllerName($router, $articlesList, $authorsList, $categoriesList);

    // Appel de la bonne méthode, envoi des éventuels paramètres
    $controller->$methodName($match['params']);
}
else 
{
    // Page non trouvée 404
    // On modifie l'entête de réponse pour avoir un statut 404
    header("HTTP/1.0 404 Not Found");

    // on instancie MainController en dur
    $controller = new MainController($router, $articlesList, $authorsList, $categoriesList);
    // on appel error404 pour afficher la page d'erreur
    $controller->error404();
}

