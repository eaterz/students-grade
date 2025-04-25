<?php
require_once './Models/Model.php';
require_once './DbConnect.class.php';

class SubjectModel extends Model
{
    public $db;

    public function __construct()
    {
        $this->db = new DbConnect(); // Initialize DbConnect
    }

    public function getAll()
    {
        $sql = "SELECT * FROM subject";
        return $this->db->execute($sql); // Use the execute method from DbConnect
    }

    public function save($subjectName)
    {
        $stmt = $this->db->dbconn->prepare("INSERT INTO subject (subject_name) VALUES (:subject_name)");
        $stmt->execute(['subject_name' => $subjectName]);
    }

    public function delete($subjectId)
    {
       
        $stmt = $this->db->dbconn->prepare("DELETE FROM grades WHERE subject_id = :id");
        $stmt->execute(['id' => $subjectId]);
    
        
        $stmt = $this->db->dbconn->prepare("DELETE FROM subject WHERE id = :id");
        $stmt->execute(['id' => $subjectId]);
    }
}