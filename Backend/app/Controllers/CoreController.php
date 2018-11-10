<?php
namespace oBlogApi\Controllers;
use PDO;
use oBlog\Utils\Database;

// classe parente des controller
abstract class CoreController 
{
    // affiche la réponse en JSON
    protected function showJson($data)
    {
        // Autorise l'accès à la ressource depuis n'importe quel autre domaine
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Credentials: true');
        // Dit au navigateur que la réponse est au format JSON
        header('Content-Type: application/json');
        // La réponse en JSON est affichée
        echo json_encode($data);
    }
}