<?php
namespace oBlogApi\Controllers;

class ErrorController extends CoreController
{
    public function error404() 
    {
        $this->showJson('url non existante');
    }
}