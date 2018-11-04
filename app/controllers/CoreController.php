<?php

// classe parente des controller
// abstract pour ne pas pouvoir l'instancier directement mais seulement par le biais des enfants
abstract class CoreController 
{
    // protected pour pouvoir y acceder dans les enfants
    protected $oTemplator;
    protected $dbdata;

    public function __construct($router, $articlesList, $authorsList, $categoriesList)
    {
        // je récupère le router et instancie dbdata pour plus tard
        $this->dbdata = new DBData();
        $this->oTemplator = new Templator(__DIR__.'/../views', $router);

    }
    // assemble le template
    protected function show($viewName, $params = array())
    {
        $this->oTemplator->setVar('params', $params);
        $this->oTemplator->setVar('allAuthor', $this->dbdata->getAllAuthor());
        $this->oTemplator->setVar('allCategory', $this->dbdata->getAllCategory());
        $this->oTemplator->display($viewName);
    }
}