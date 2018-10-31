<?php 

// Inclusion autoload de Composer
require __DIR__.'/../vendor/autoload.php';
//Inclusion de DBData
require __DIR__.'/../app/utils/DBData.php';
// Inclusion des controllers
require __DIR__.'/../app/controllers/CoreController.php';
require __DIR__.'/../app/controllers/MainController.php';

// // Inclusion des models
 require __DIR__.'/../app/models/CoreModel.php';
 require __DIR__.'/../app/models/Character.php';

// on instancie altorouter
$router = new AltoRouter();

// on récupère le chemin de base vers le dossier public 
// si $_SERVER['BASE_URI'] n'existe pas alors $baseUrl est vide
$baseUrl = isset($_SERVER['BASE_URI']) ? $_SERVER['BASE_URI'] : '';

// il faut donner ce chemin à $router pour qu'il puisse travailler avec
$router->setBasePath($baseUrl);

// mapping des route

// p1 = méthode 
// p2 = chemin à chercher, à 'matcher' ET chemin qui sera utilisé lors de l'appel de generate()
// p3 = texte à récupérer dans "target" s'il y a match
// p4 = id de la map, cet id sera utilisé pour générer un lien par exemple
$router->map('GET', '/', 'MainController#home', 'home');
$router->map('GET', '/les-createurs', 'MainController#creator', 'creator');

// si la route demandé existe dans le mapping, match() renvoi un tableau
// sinon match() renvoi false
$match = $router->match();

// si match n'a pas renvoyé false
if ($match) 
{
    // p1 = séparateur
    // p2 = chaine à découper
    // explode('p1', 'p2') renvoi un tableau
    $dispatcher = explode('#', $match['target']);

    // on récupère le contenu du premier index de dispatcher
    // ce contenu représente le nom du controller à utiliser
    $controllerName = $dispatcher[0];

    // on récupère le contenu du deuxieme index de dispatcher
    // ce contenu représente le nom de la méthode à appeler
    $methodName = $dispatcher[1];

    // maintenant que nous avont récupérer le nom de notre controller
    // nous pouvons l'instancier dynamiquement.
    // nous lui donnerons l'instance de AltoRouteur en paramètre 
    $controller = new $controllerName($router);

    // de même pour la méthode à laquelle nous donnerons en paramètre
    // le contenu de l'index params du tableau $match 
    // (params ne me sert pas actuellement mais je le laisse au cas ou)
    $controller->$methodName($match['params']);
}
else 
{
    // Page non trouvée 404
    // On modifie l'entête de réponse pour avoir un statut 404
    header("HTTP/1.0 404 Not Found");

    // on instancie MainController en dur
    // nous lui donnerons l'instance de AltoRouteur en paramètre 
    $controller = new MainController($router);
    // on appel error404 pour afficher la page d'erreur
    $controller->error404();
}

