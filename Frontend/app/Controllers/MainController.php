<?php
namespace oBlog\Controllers;

class MainController extends CoreController
{
    // j'appel show pour afficher la home
    public function home()
    {
        $this->oTemplator->setVar('js', ['aside']);
        $this->show('/main/home');
    }

    // j'appel show pour les contact
    public function contact()
    {
        $this->oTemplator->setVar('js', ['aside']);
        $this->show('/main/contact');
    }

    // j'appel show pour la page qui suis-je ?
    public function aboutUs()
    {
        $this->oTemplator->setVar('js', ['aside']);
        $this->show('/main/aboutUs');
    }

    // j'appel show pour la page mention légales
    public function legalMention()
    {
        $this->oTemplator->setVar('js', ['aside']);
        $this->show('/main/legalMention');
    }

}