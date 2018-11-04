<?php

class Author extends CoreModel
{
    private $name;
    private $image;
    private $email;
    private $id_author;

    public function getName()
    {
        return $this->name;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getIdAuthor()
    {
        return $this->id_author;
    }
}