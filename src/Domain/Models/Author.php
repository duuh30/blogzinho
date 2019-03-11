<?php

namespace BLOG\Domain\Models;

class Author
{
    public $id;
    public $name;

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

    public function parse ($data)
    {
        $this->name = $data["author_name"];
        return $this;
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
