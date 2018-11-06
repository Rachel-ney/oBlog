<?php
namespace oBlog\Models;

class Author extends CoreModel
{
    private $name;
    private $image;
    private $email;
    
    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of image
     */ 
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */ 
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of author_id
     */ 
    public function getAuthorId()
    {
        return $this->author_id;
    }

    /**
     * Set the value of author_id
     *
     * @return  self
     */ 
    public function setAuthorId($author_id)
    {
        $this->author_id = $author_id;

        return $this;
    }
}