<?php

require_once './Models/AdminModel.php';

class AdminController
{
    public function show()
    {
        if (!Validator::Role('ADMIN')) {
            header("Location: /login");
            exit();
        }
        include './view/admin.php';
    }

   public function saveUser()
{
    if (!Validator::Role('ADMIN')) {
        header("Location: /login");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {


        $id = $_POST['id'] ?? null;
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? '';

        if (!$id || !$username || !$password || !$role) {
            die("Invalid input data.");
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $adminModel = new AdminModel();
        $updated = $adminModel->updateUser($id, $username, $hashedPassword, $role);

        if ($updated) {
            header("Location: /admin?success=1"); 
            exit();
        } else {
            header("Location: /admin?error=1"); 
            exit();
        }
    }
}

}
