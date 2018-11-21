<?php
namespace oBlog\Controllers;

class MainController extends CoreController
{
    // j'appel show pour afficher la home
    public function home()
    {
        $this->show('home');
    }

    // j'appel show pour les contact
    public function contact()
    {
        $this->show('contact');
    }

    // j'appel show pour la page qui suis-je ?
    public function aboutUs()
    {
        $this->show('aboutUs');
    }

    // j'appel show pour la page mention légales
    public function legalMention()
    {
        $this->show('legalMention');
    }

}