<?php
namespace oBlog\Controllers;

class UserController extends CoreController
{
    public function account() {
        $this->show('account');
    }
}