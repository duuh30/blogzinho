<?php

namespace BLOG\Domain\Models;
use Doctrine\Common\Collections\ArrayCollection;

class Post
{
    public $id;
    public $title;
    public $slug;
    public $body;
    public $image;
    public $published;
    public $author;
    public $tags;

    /**
     * Post constructor.
     */
    public function __construct()
    {
       $this->tags = new ArrayCollection();
    }

    /**,
     * @param Tag $tag
     */
    public function addTag(Tag $tag)
    {
        $tag->addPost($this);
        $this->tags[] = $tag;
    }

    public function parse ($data,$author)
    {
        $this->title      = $data["title"];
        $this->slug       = $data["slug"];
        $this->body       = $data["body"];
        $this->image      = isset($data["image"]) ? $data["image"] : null;
        $this->published  = true;
        $this->author     = $author;
        return $this;
    }
    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->name;
        }
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->name = $value;
        }
    }

}
