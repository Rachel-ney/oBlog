<?php

class Article {
    public $title;
    public $content;
    public $date;
    public $author;
    public $category;

    public function __construct($title='', $content='', $auhtor='', $date='', $category='') {
        $this->title = $title;
        $this->content = $content;
        $this->auhtor = $auhtor;
        $this->date = $date;
        $this->category = $category;
    }

    public function getDateFr() {
        return date('d/m/Y', strtotime($this->date));
    }
}