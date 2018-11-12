<?php
namespace oBlog\Controllers;
use oBlog\Templator\Templator;

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
    protected function show($viewName)
    {
        $this->oTemplator->display($viewName);
    }
}