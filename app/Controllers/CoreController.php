<?php
namespace oBlog\Controllers;
use PDO;
use oBlog\Utils\Database;
use oBlog\Utils\Templator;
use oBlog\Models\Post;
use oBlog\Models\Author;
use oBlog\Models\Category;


// classe parente des controller
abstract class CoreController 
{
    // contient l'instance du templator
    protected $oTemplator;

    public function __construct($router)
    {
        // j'envoi le router + le chemin absolu vers views en instanciant templator
        $this->oTemplator = new Templator(__DIR__.'/../views', $router);
    }
    // transmet les variables essentiel à templator 
    // appel templator pour assembler le template voulu
    protected function show($viewName, $params = array())
    {
        $this->oTemplator->setVar('params', $params);
        $this->oTemplator->setVar('allAuthor', Author::getAll());
        $this->oTemplator->setVar('allCategory', Category::getAll());
        $this->oTemplator->display($viewName);
    }
}