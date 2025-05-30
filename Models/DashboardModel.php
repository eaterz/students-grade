<?php
require_once './Models/Model.php';

class DashboardModel extends Model
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

    // Get all subjects
    public function getAllSubjects()
    {
        $sql = "SELECT * FROM subject ORDER BY subject_name";
        return $this->db->execute($sql);
    }

    // Get all grades with student and subject details
    public function getAllGradesWithDetails()
    {
        $sql = "SELECT g.*, u.first_name, u.last_name, sub.subject_name 
                FROM grades g
                JOIN user u ON g.user_id = u.id
                JOIN subject sub ON g.subject_id = sub.id
                ORDER BY u.last_name, u.first_name, sub.subject_name";
        return $this->db->execute($sql);
    }

    // Get grades for a specific student
    public function getStudentGrades($studentId)
    {
        $sql = "SELECT g.*, sub.subject_name 
                FROM grades g 
                JOIN subject sub ON g.subject_id = sub.id 
                WHERE g.user_id = ?";
        return $this->db->execute($sql, [$studentId]);
    }

    // Get a single student's (user's) info
    public function getStudentInfo($studentId)
    {
        $sql = "SELECT * FROM user WHERE id = ?";
        $result = $this->db->execute($sql, [$studentId]);
        return (!empty($result)) ? $result[0] : null;
    }

    // Debug helper - structure of grades table
    public function getGradesTableStructure()
    {
        $sql = "DESCRIBE grades";
        return $this->db->execute($sql);
    }
}