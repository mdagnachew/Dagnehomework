<?php

namespace App;

class User
{
    private $id;
    private $type;

    public function __construct($id, $type)
    {
        $this->id = $id;
        $this->type = $type;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getType()
    {
        return $this->type;
    }
}
