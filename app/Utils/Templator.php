<?php

class Templator {
    private $cheminAbsolut;
    private $var = [];
    private $router;

    public function __construct ($cheminQuiMeneAuDossierViews, $router) {
        // je stock le chemin reçu en paramètre dans la propriétée $cheminAbsolut
        $this->cheminAbsolut = $cheminQuiMeneAuDossierViews;
        $this->router = $router;
    }

    public function setVar($nomVar, $contenuVar) {
        // on stock la valeur contenu dans $nomVar comme étant un index de notre tableau var[]
        // et on assigne à cet index la valeur présente dans $contenuVar
        $this->var[$nomVar] = $contenuVar;
    }

    // cette méthode permet d'afficher TOUT les templates, avec comme contenu principal: le nom du template donné en parametre
    public function display ($template) {
        //dump($this->var);
        // dans $verify je stock le chemin de fichier complet qui mène au nom du template donné en paramètre
        $verify = $this->cheminAbsolut. '/'.$template.'.tpl.php';
        // je vérifie si le fichier donné en paramètre existe bien en donnant son chemin de fichier à la fonction file_exists()
        // si le fichier existe, je fais tout mes includes.
        if (file_exists($verify)) {
            include $this->cheminAbsolut. '/header.tpl.php';
            include $verify; // $verify contient le chemin complet jusqu'au template donné en paramètre
            include $this->cheminAbsolut. '/footer.tpl.php';
        }
        else {
            header("HTTP/1.0 404 Not Found");
            include $this->cheminAbsolut. '/header.tpl.php';
            include $this->cheminAbsolut. '/error404.tpl.php';
            include $this->cheminAbsolut. '/footer.tpl.php';
        }
    }

    // cette méthode permet d'inclure UN template bien préci dont le nom est donné en paramètre
    public function include($template) {
        include $this->cheminAbsolut. '/'.$template.'.tpl.php';
    }

    // cette méthode permet de retourner le contenu d'un index du tableau $var[] 
    public function getVar($nomVar) {
        // si la valeur donnée en paramètre (et stocké dans $nomVar) est bel et bien un index de mon tableau $var(donc si l'index existe)
        // on renvoi le contenu de cet index
        if(isset($this->var[$nomVar])) {
            return $this->var[$nomVar];
        }
    }
}
