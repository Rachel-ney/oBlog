<?php 
// configuration de mon cookie session
//ini_set('session.cookie_domain', '.rachel-michel.fr');
//session_save_path('/var/www/tmp');
session_start();

if (!empty($_GET['acceptCookie']))
{
    if($_GET['acceptCookie'] === '1')
    {
        $_SESSION['acceptCookie'] = true;
    }
    
}

use \oBlog\Application as App;
// Inclusion autoload de Composer
require __DIR__.'/../vendor/autoload.php';

// Instance de Application
$application = new App();

$application->run();
