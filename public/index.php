<?php 

// Inclusion autoload de Composer
require __DIR__.'/../vendor/autoload.php';

// Inclusion des controllers
require __DIR__.'/../app/Controllers/CoreController.php';
require __DIR__.'/../app/Controllers/MainController.php';
require __DIR__.'/../app/Controllers/BlogController.php';

// Inclusion des models
require __DIR__.'/../app/Models/CoreModel.php';
require __DIR__.'/../app/Models/Author.php';
require __DIR__.'/../app/Models/Category.php';
require __DIR__.'/../app/Models/Post.php';

// Inclusion des fichiers utils
require __DIR__.'/../app/Utils/DBData.php';
require __DIR__.'/../app/Utils/Templator.php';

// Inclusion du Front Controller 
require __DIR__.'/../app/Application.php';

// Instance de Application
$application = new Application();

$application->run();
