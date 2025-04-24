<?php
require_once './Models/Model.php';

class TeacherModel extends Model
{
    public $db;

    public function __construct()
    {
        $this->db = new DbConnect();
    }

    // Get all users with role 'student'
    public function getAllUsers()
    {
        $sql = "SELECT * FROM user WHERE role = 'student'";
        return $this->db->execute($sql);
    }



}
