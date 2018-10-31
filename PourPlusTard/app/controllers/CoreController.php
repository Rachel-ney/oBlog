<?php

// classe parente des controller
// abstract pour ne pas pouvoir l'instancier directement mais seulement par le biais des enfants
abstract class CoreController 
{
    // protected pour pouvoir y acceder dans les enfants
    protected $router;
    protected $dbdata;

    public function __construct($router)
    {
        // je récupère le router et instancie dbdata pour plus tard
        $this->router = $router;
        $this->dbdata = new DBData();
    }
    // assemble le template
    protected function show($viewName, $modelInfos = '')
    {
        // dump($this->router);
        include __DIR__.'/../views/header.tpl.php';
        include __DIR__.'/../views/'. $viewName .'.tpl.php';
        include __DIR__.'/../views/footer.tpl.php';
    }
}