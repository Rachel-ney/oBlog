<?php

// 1- Chargement des fichiers définissants les classes
// TODO
require __DIR__.'/inc/classes/Article.php';
require __DIR__.'/inc/classes/Templator.php';

// 2- Chargement des données
// __DIR__ = constante "magique" contenant le chemin absolu jusqu'au dossier du fichier dans lequel il est écrit
require __DIR__.'/inc/data.php';

// 3- Instanciation de classe de Templating
$oTemplator = new Templator(__DIR__.'/inc/views');

// 4- Transmission des données au système de Templates
$oTemplator->setVar('articles', $articlesList);
$oTemplator->setVar('categories', $categoriesList);
$oTemplator->setVar('authors', $authorsList);

// 5- Afficher la template de la home
$oTemplator->display('home');