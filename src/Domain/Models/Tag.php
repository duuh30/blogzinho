<?php

namespace BLOG\Domain\Models;
use Doctrine\Common\Collections\ArrayCollection;

class Tag
{
    public $id;
    public $name;
    public $posts;


    /**
     * Tag constructor.
     */
    public function __construct() {
        $this->posts = new ArrayCollection();
    }

    /**
     * @param Post $post
     */
    public function addPost(Post $post)
    {
        $this->posts[] = $post;
    }

    /**
     * @param $data
     * @return $this
     */
    public function parse ($data)
    {
        $this->name      = $data["name"];
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
