<?php
require_once './DbConnect.class.php';
abstract class Model
{
    protected $db;

    public function __construct()
    {
        $this->db = new DbConnect();
    }
}
