<?php

require './Models/StudentsModel.php';
class AddStudentsController
{

    public function index()
    {
        if (!Validator::Role('teacher')) {
            header("Location: /login");
            exit();
        }
        include './view/teacher/AddStudents/index.view.php';
    }

    public function create()
    {
        if (!Validator::Role('teacher')) {
            header("Location: /login");
            exit();
        }
        include './view/teacher/AddStudents/create.view.php';
    }

    public function store() {

        if (!Validator::Role('teacher')) {
            header("Location: /login");
            exit();
        }

        if (empty($_POST['personal_code']) || empty($_POST['first_name']) ||
            empty($_POST['last_name']) || empty($_POST['password'])) {
            header('Location: /students/create?error=All fields are required');
            exit;
        }

        if ($_POST['password'] !== $_POST['password_confirmation']) {
            header('Location: /students/create?error=Passwords do not match');
            exit;
        }

        // Check if personal code already exists
        $model = new StudentsModel();
        if ($model->personalCodeExists($_POST['personal_code'])) {
            header('Location: /students/create?error=Personal code already exists');
            exit;
        }

        $studentData = [
            'personal_code' => $_POST['personal_code'],
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'role' => 'student'
        ];

        $result = $model->createStudent($studentData);

        if ($result) {
            header('Location: /students?success=Student created successfully');
        } else {
            header('Location: /students/create?error=Failed to create student');
        }
        exit;
    }

    public function destroy()
    {
        if (!Validator::Role('teacher')) {
            header("Location: /login");
            exit();
        }

        if (isset($_POST['student_id'])) {
            $model = new StudentsModel();
            $model->deleteStudent($_POST['student_id']);
        }

        header('Location: /students');
    }


}