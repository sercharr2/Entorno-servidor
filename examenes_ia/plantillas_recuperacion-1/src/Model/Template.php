<?php

namespace App\Model;

class Template
{
    private $id;
    private $name;
    private $content;

    public function __construct($id, $name, $content)
    {
        $this->id = $id;
        $this->name = $name;
        $this->content = $content;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }
}