<?php 
// récupèration de l'id de session de mon Front 
// étant donné que le back se trouve dans un sous domaine,
// le navigateur vas générer un nouveau cookie et mes information ne transiterons pas
// pour y remedier, je récupère l'id de mon cookie via ma requête ajax
// ainsi, je donne l'id au nouveau cookie ( ce qui écrasera l'ancien ) 
/*
if (!empty($_GET['sess']))
{
    session_id($_GET['sess']);
}
else if (!empty($_POST['sess']))
{
    session_id($_POST['sess']);
}
// Configuration de mon cookie session
ini_set('session.cookie_domain', '.rachel-michel.fr');
session_save_path('/var/www/tmp');
*/
session_start();

use \oBlogApi\Application as App;
// Inclusion autoload de Composer
require __DIR__.'/vendor/autoload.php';
// ini_set change la valeur de l'option d'une configuration
// ici je souhaite modifier la configuration de ma session AVANT sa création
// plus précisément, le nom de domaine qu'elle possède lors de sa création : session.cookie_domain

// Instance de Application
$application = new App();

$application->run();