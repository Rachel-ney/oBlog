<?php

// classe parente des controller
// abstract pour ne pas pouvoir l'instancier directement mais seulement par le biais des enfants
abstract class CoreController 
{
    // protected pour pouvoir y acceder dans les enfants
    protected $data = array();
    protected $oTemplator;

    public function __construct($router, $articlesList, $authorsList, $categoriesList)
    {
        // je récupère le router et instancie dbdata pour plus tard
        $this->data['authors'] = $authorsList;
        $this->data['categories'] = $categoriesList;
        $this->data['articles'] = $articlesList;
        $this->oTemplator = new Templator(__DIR__.'/../views', $router);
    }
    // assemble le template
    protected function show($viewName, $params = array())
    {
        $this->oTemplator->setVar('categories', $this->data['categories']);
        $this->oTemplator->setVar('params', $params);
        $this->oTemplator->display($viewName);
    }
}