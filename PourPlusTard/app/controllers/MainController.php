<?php

class MainController extends CoreController
{
    // j'appel show pour afficher la home et lui transmet en paramètre la liste des perso récupéré dans la bdd
    public function home()
    {
        $characterList = $this->dbdata->getAllCharacters();
        $this->show('home', $characterList);
    }

    // j'appel show pour afficher la page des créateur et lui transmet en paramètre le tableau contenant les info de ceux-ci
    public function creator()
    {
        $creatorList = [
            0 => [
                'name'=> 'Hirokazu Yasuhara',
                'bio' => 'Hirokazu Yasuhara est un designer japonais de jeu vidéo. Ancien membre important du studio Sonic Team, il a occupé des fonctions artistiques chez Naughty Dog, et plus récemment pour Namco Bandai.',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi reprehenderit dignissimos illo iste error aperiam beatae maxime deserunt harum obcaecati. '
            ],
            1 => [
                'name'=> 'Yuji Naka',
                'bio' => "Alors qu'il est encore au lycée, il sait déjà qu'il veut travailler dans l'industrie des jeux vidéo. Il rentre chez Sega comme programmeur en 1984 ; son premier jeu, Girl's Garden, sort la même année. En 1991, il est à l'origine, avec Naoto Oshima et Hirokazu Yasuhara, de Sonic the Hedgehog sur Mega Drive qui va rapidement devenir culte, au même titre que Mario. Il fut à la tête de l'équipe de développement de jeux vidéo, la Sonic Team, jusqu'au 16 mars 2006 où il quitte Sega pour fonder le studio Prope. En Janvier 2018 il rejoint officiellement Square Enix.",
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi reprehenderit dignissimos illo iste error aperiam beatae maxime deserunt harum obcaecati. '
            ],
            2 => [
                'name'=> 'Naoto Ōshima',
                'bio' => "Naoto Ōshima (大島 直人?) est un designer japonais de jeu vidéo, ancien employé de Sega, principalement connu pour avoir modelé le design de Sonic et Eggman.
                Après avoir quitté Sonic Team, Ōshima fonde un studio de développement indépendant nommé Artoon.",
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi reprehenderit dignissimos illo iste error aperiam beatae maxime deserunt harum obcaecati. '
            ]
        ];
        $this->show('creator', $creatorList);
    }

    // j'appel show pour afficher la page 404
    public function error404()
    {
        $this->show('error404');
    }
}