<?php

class Post extends CoreModel
{
    private $title;
    private $resume;
    private $content;
    private $publish_date;
    private $view_count;
    private $author;
    private $category;
    private $category_name;
    private $author_name;

    public function getTitle()
    {
        return $this->title;
    }

    public function getResume()
    {
        return $this->resume;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getPublishDate()
    {
        return $this->publish_date;
    }

    public function getViewCount()
    {
        return $this->view_count;
    }

    public function getAuthor()
    {
        return $this->author;
    }
 
    public function getCategory()
    {
        return $this->category;
    }

    public function getCategoryName()
    {
        return $this->category_name;
    }

    public function getAuthorName()
    {
        return $this->author_name;
    }
}