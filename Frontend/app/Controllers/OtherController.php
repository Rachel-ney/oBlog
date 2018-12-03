<?php
namespace oBlog\Controllers;

class OtherController extends CoreController
{
    // j'appel show pour afficher la home
    public function memory()
    {
        $this->oTemplator->setVar('js', ['memory']);
        $this->show('/memory/memory');
    }

}