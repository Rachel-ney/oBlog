<?php
namespace oBlog\Models;

class Post extends CoreModel
{
    private $title;
    private $resume;
    private $content;
    private $author_id;
    private $category_id;
    private $category_name;
    private $author_name;
    const TABLE_NAME = 'post';

    // GETTERS & SETTERS

    public function getTitle()
    {
        return $this->title;
    } 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }
 
    public function getResume()
    {
        return $this->resume;
    }
    public function setResume($resume)
    {
        $this->resume = $resume;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthorId()
    {
        return $this->author_id;
    }
    public function setAuthorId($author_id)
    {
        $this->author_id = $author_id;

        return $this;
    }

    public function getCategoryId()
    {
        return $this->category_id;
    }
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function getCategoryName()
    {
        return $this->category_name;
    }
    public function setCategoryName($category_name)
    {
        $this->category_name = $category_name;

        return $this;
    }

    public function getAuthorName()
    {
        return $this->author_name;
    }
    public function setAuthorName($author_name)
    {
        $this->author_name = $author_name;

        return $this;
    }
}