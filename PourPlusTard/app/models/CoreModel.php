<?php 
// class parente des models
// abstract pour ne pas pouvoir l'instancier directement mais seulement par le biais des enfants
// je n'ai mis que ce que j'utilise ( les variables non créé le seront lors du FETCH_CLASS)
abstract class CoreModel
{
    protected $id;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

}