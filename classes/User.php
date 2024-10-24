<?php
class User
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }
}
