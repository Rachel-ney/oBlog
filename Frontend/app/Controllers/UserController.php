<?php
namespace oBlog\Controllers;

class UserController extends CoreController
{

    public function account() {
        if (!empty($_SESSION['userId']))
        {
            $this->show('account');
        }
        else 
        {
            $this->oTemplator->setVar('js', 'signIn');
            $this->show('signIn');
        }
    }

    // j'appel show pour afficher la page d'inscription / connexion
    public function signIn()
    {
        if (!empty($_SESSION['userId']))
        {
            $this->show('account');
        }
        else 
        {
            $this->oTemplator->setVar('js', 'signIn');
            $this->show('signIn');
        }
    }
}