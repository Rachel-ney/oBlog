<?php
namespace oBlog\Models;

class Category extends CoreModel
{
    private $name;
    const TABLE_NAME = 'category';
    
    // GETTERS & SETTERS
 
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}