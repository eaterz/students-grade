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
    public function updateGrade($gradeId, $newGrade)
    {
        try {
            $sql = "UPDATE grades SET grade = :grade WHERE id = :id";
            $params = [
                ':grade' => $newGrade,
                ':id' => $gradeId
            ];

            $this->db->execute($sql, $params);
            return true;
        } catch (Exception $e) {
            // Log error
            return false;
        }
    }

    public function deleteGrade($gradeId)
    {
        try {
            $sql = "DELETE FROM grades WHERE id = :id";
            $params = [
                ':id' => $gradeId
            ];

            $this->db->execute($sql, $params);
            return true;
        } catch (Exception $e) {
            // Log error
            return false;
        }
    }

    public function getGradeById($gradeId)
    {
        if (!$gradeId) {
            return null;
        }

        try {
            // Fixed table name: 'subject' not 'subjects'
            // Fixed column name: 'user_id' not 'student_id'
            $sql = "SELECT g.*, s.subject_name, u.first_name, u.last_name 
                FROM grades g
                JOIN subject s ON g.subject_id = s.id
                JOIN user u ON g.user_id = u.id
                WHERE g.id = ?";

            $result = $this->db->execute($sql, [$gradeId]);

            // Handle PDOStatement if that's what your execute method returns
            if ($result instanceof PDOStatement) {
                $fetchedResult = $result->fetchAll(PDO::FETCH_ASSOC);
                return !empty($fetchedResult) ? $fetchedResult[0] : null;
            }

            return !empty($result) ? $result[0] : null;

        } catch (Exception $e) {
            return null;
        }
    }



}