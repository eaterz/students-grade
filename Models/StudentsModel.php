<?php
require_once './Models/Model.php';

class StudentsModel extends Model
{
    public $db;

    public function __construct()
    {
        $this->db = new DbConnect();
    }

    public function createStudent($data)
    {
        $personal_code = $data['personal_code'];
        $password = $data['password'];
        $first_name = $data['first_name'];
        $last_name = $data['last_name'];
        $role = $data['role'];

        $sql = "INSERT INTO user (personal_code, password, first_name, last_name, role) 
            VALUES (:personal_code, :password, :first_name, :last_name, :role)";

        $params = [
            ':personal_code' => $personal_code,
            ':password' => $password,
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':role' => $role
        ];

        $this->db->execute($sql, $params);
        $result = $this->db->execute("SELECT LAST_INSERT_ID()");
        return $result[0]['LAST_INSERT_ID()'];
    }

    public function deleteStudent($id)
    {
        $sql = "DELETE FROM user WHERE id = :id";
        $params = [
            ':id' => $id
        ];
        $this->db->execute($sql, $params);
    }

    public function personalCodeExists($personalCode) {
        $conn = $this->db->getConnection();  // Get the actual PDO object
        $stmt = $conn->prepare("SELECT COUNT(*) FROM user WHERE personal_code = ?");
        $stmt->execute([$personalCode]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function getUserById($id) {
        $sql = "SELECT id, personal_code, first_name, last_name, role FROM user WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }


    public function updateUser($id, $data) {
        try {
            $sql = "UPDATE user SET 
                first_name = :first_name,
                last_name = :last_name,
                personal_code = :personal_code
                WHERE id = :id";

            $stmt = $this->db->prepare($sql);

            $params = [
                ':first_name' => $data['first_name'],
                ':last_name' => $data['last_name'],
                ':personal_code' => $data['personal_code'],
                ':id' => $id
            ];

            return $stmt->execute($params);
        } catch (PDOException $e) {
            // Log error or handle exception
            return false;
        }
    }







}
