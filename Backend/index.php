<?php 

session_id('identifiantPasDuToutUnique');
ini_set('session.cookie_domain', '.rachel-michel.fr');
session_save_path('/var/www/tmp');

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