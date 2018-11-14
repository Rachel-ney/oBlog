<?php
namespace oBlog\Controllers;

class MainController extends CoreController
{
    // j'appel show pour afficher la home
    public function home()
    {
        $this->show('home');
    }

    // j'appel show pour afficher la page d'inscription / connexion
    public function signIn()
    {
        $this->oTemplator->setVar('js', 'signIn');
        $this->show('signIn');
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