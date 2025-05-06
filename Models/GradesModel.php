<?php
require_once './Models/Model.php';

class GradesModel extends Model
{

    public $db;

    public function __construct()
    {
        $this->db = new DbConnect();
    }

    public function getAllStudents() {
        $query = "SELECT id, first_name, last_name, personal_code 
              FROM user 
              WHERE role = 'student' 
              ORDER BY last_name, first_name";

        return $this->db->query($query);
    }

    /**
     * Get all subjects
     */
    public function getAllSubjects() {
        $query = "SELECT id, subject_name FROM subject ORDER BY subject_name";

        return $this->db->query($query);
    }

    /**
     * Add a new grade
     */
    public function addGrade($studentId, $subjectId, $grade) {
        $query = "INSERT INTO grades (user_id, subject_id, grade) 
              VALUES (?, ?, ?)";

        return $this->db->execute($query, [$studentId, $subjectId, $grade]);
    }

    /**
     * Get recent grades with student and subject information
     */





}