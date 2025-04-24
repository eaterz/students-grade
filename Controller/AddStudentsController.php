<?php

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
}