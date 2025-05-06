<?php

require './Models/GradesModel.php';
class AddGradesController
{

    public function create()
    {
        if (!Validator::Role('teacher')) {
            header("Location: /");
            exit();
        }
        include './view/teacher/AddGrades/create.view.php';
    }

    public function store()
    {
        $model= new GradesModel();
        // Check if the form was submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and sanitize inputs
            $studentId = isset($_POST['student_id']) ? (int)$_POST['student_id'] : 0;
            $subjectId = isset($_POST['subject_id']) ? (int)$_POST['subject_id'] : 0;
            $grade = isset($_POST['grade']) ? (int)$_POST['grade'] : 0;

            // Validate data
            $errors = [];

            if ($studentId <= 0) {
                $errors[] = "Please select a valid student.";
            }

            if ($subjectId <= 0) {
                $errors[] = "Please select a valid subject.";
            }

            if ($grade < 1 || $grade > 10) {
                $errors[] = "Grade must be between 1 and 10.";
            }

            // If validation passed, save the grade
            if (empty($errors)) {
                $model->addGrade($studentId, $subjectId, $grade);
                $_SESSION['success_grade'] = 'Grade added successfully';
                header('Location: /grades');
                exit;

            } else {
                // Store errors in session
                $_SESSION['errors'] = $errors;
                $_SESSION['form_data'] = $_POST; // Store form data for repopulating the form
                header('Location: /grades');
                exit;
            }
        } else {
            // If not a POST request, redirect to the form
            header('Location: /grades');
            exit;
        }
    }
}