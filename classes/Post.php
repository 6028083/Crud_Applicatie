<?php
class Post
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }
}
