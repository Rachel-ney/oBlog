<?php
namespace oBlog\Controllers;

class UserController extends CoreController
{

    public function account() {
        if (!empty($_SESSION['user']))
        {
            $this->oTemplator->setVar('js', ['account']);
            $this->show('/user/account');
        }
        else 
        {
            $this->oTemplator->setVar('js', ['signIn']);
            $this->show('/user/signIn');
        }
    }

    // j'appel show pour afficher la page d'inscription / connexion
    public function signIn()
    {
        if (!empty($_SESSION['user']))
        {
            $this->oTemplator->setVar('js', ['account']);
            $this->show('/user/account');
        }
        else 
        {
            $this->oTemplator->setVar('js', ['signIn']);
            $this->show('/user/signIn');
        }
    }

    public function lostPass() {
        if (!empty($_SESSION['user']))
        {
            $this->oTemplator->setVar('js', ['account']);
            $this->show('/user/account');
        }
        else 
        {
            $this->oTemplator->setVar('js', ['lostPass']);
            $this->show('/user/lostPass');
        }
    }

    public function resetPass() {
        if (!empty($_SESSION['user']))
        {
            $this->oTemplator->setVar('js', ['account']);
            $this->show('/user/account');
        }
        else 
        {
            $this->oTemplator->setVar('js', ['resetPass']);
            $this->show('/user/resetPass');
        }
    }
}