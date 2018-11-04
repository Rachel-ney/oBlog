<?php

class Category extends CoreModel
{
    private $name;
    private $id_category;

    public function getName()
    {
        return $this->name;
    }

    public function getIdCategory()
    {
        return $this->id_category;
    }

}