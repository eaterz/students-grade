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

    public function edit() {
        if (!Validator::Role('teacher')) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
            exit();
        }

        include './view/teacher/AddGrades/edit.view.php';
    }

    public function update()
    {
        if (!Validator::Role('teacher')) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
            exit();
        }

        // Check if it's a POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $gradeId = isset($_POST['grade_id']) ? $_POST['grade_id'] : null;
            $newGrade = isset($_POST['grade']) ? $_POST['grade'] : null;

            // Validate input
            if (!$gradeId || !is_numeric($gradeId) || $newGrade === null || !is_numeric($newGrade)) {
                echo json_encode(['success' => false, 'message' => 'Invalid grade data provided']);
                exit();
            }

            // Validate grade range
            if ($newGrade < 0 || $newGrade > 10) {
                echo json_encode(['success' => false, 'message' => 'Grade must be between 0 and 10']);
                exit();
            }

            // Update grade
            $model = new GradesModel();
            $result = $model->updateGrade($gradeId, $newGrade);

            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update grade']);
            }
            exit();
        } else {
            // Display the grade form
            $gradeId = isset($_GET['id']) ? $_GET['id'] : null;

            if (!$gradeId) {
                header('Location: /dashboard');
                exit();
            }

            $model = new GradesModel();
            $grade = $model->getGradeById($gradeId);

            if (!$grade) {
                header('Location: /dashboard');
                exit();
            }

            include './view/teacher/AddGrades/edit_grade.view.php';
        }
    }

    public function delete()
    {
        if (!Validator::Role('teacher')) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
            exit();
        }

        $gradeId = isset($_POST['grade_id']) ? $_POST['grade_id'] : null;

        // Validate input
        if (!$gradeId || !is_numeric($gradeId)) {
            echo json_encode(['success' => false, 'message' => 'Invalid grade data provided']);
            exit();
        }

        // Delete grade
        $model = new GradesModel();
        $result = $model->deleteGrade($gradeId);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete grade']);
        }
        exit();
    }
}