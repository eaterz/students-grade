<?php

require_once './Models/SubjectModel.php';

class AddSubjectController
{
    private $subjectModel;

    public function __construct()
    {
        $this->subjectModel = new SubjectModel();
    }

    // Display all subjects
    public function index()
    {
        $subjects = $this->subjectModel->getAll();
        include './view/teacher/AddSubjects/index.view.php';
    }

    // Show the form to create a new subject
    public function create()
    {
        include './view/teacher/AddSubjects/create.view.php';
    }

    
public function store()
{
    $subjectName = trim($_POST['subject_name'] ?? '');
    if (empty($subjectName)) {
        die('Subject name is required.');
    }

    $this->subjectModel->save($subjectName);

    // Redirect to the subjects list
    header('Location: /subjects');
    exit;
}

public function delete()
{
    $subjectId = intval($_POST['subject_id'] ?? 0); // Get the subject ID from the POST request
    if ($subjectId <= 0) {
        die('Invalid subject ID.');
    }

    $this->subjectModel->delete($subjectId);

    // Redirect to the subjects list
    header('Location: /subjects');
    exit;
}

}