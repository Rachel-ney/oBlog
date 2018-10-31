<?php 
// classe qui sera utilisé dans DBdata pour instancier les personnages de ma bdd
// je n'ai mis que ce que j'utilise ( les variables non créé le seront lors du FETCH_CLASS)
class Character extends CoreModel
{
    private $name;
    private $description;
    private $picture;

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the value of picture
     */ 
    public function getPicture()
    {
        return $this->picture;
    }
}