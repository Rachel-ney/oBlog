<?php
namespace oBlog\Controllers;

class ErrorController extends CoreController
{
    // j'appel show pour la page error 404
    public function error404()
    {
        $this->show('error404');
    }
}