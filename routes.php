<?php

require "session.php";
require "Controller/AuthController.php";
require "Controller/DashboardController.php";
require "Controller/AddStudentsController.php";
require "Controller/AddGradesController.php";
require "Controller/AddSubjectController.php";
require "Controller/ProfileController.php";
require "Controller/ExportGradesController.php";
require "Router.php";

$router = new Router();

$url = parse_url($_SERVER["REQUEST_URI"])["path"];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

$router->get('/', [AuthController::class, 'login']);
$router->post('/login/process', [AuthController::class, 'processLogin']);
$router->get('/logout', [AuthController::class, 'logout']);

$router->get('/dashboard', [DashboardController::class, 'dashboard']);


// Add student routes
$router->get('/students', [AddStudentsController::class, 'index']);
$router->get('/students/create', [AddStudentsController::class, 'create']);
$router->post('/students/create/store', [AddStudentsController::class, 'store']);
$router->get('/students/edit', [AddStudentsController::class, 'edit']);
$router->post('/students/edit', [AddStudentsController::class, 'update']);
$router->post('/students/delete', [AddStudentsController::class, 'destroy']);

//Add Grades
$router->get('/grades', [AddGradesController::class, 'create']);
$router->post('/grades/add', [AddGradesController::class, 'store']);
$router->get('/grades/edit', [AddGradesController::class, 'edit']);
$router->post('/grades/update', [AddGradesController::class, 'update']);
$router->post('/grades/delete', [AddGradesController::class, 'delete']);
$router->post('/grades/export', [ExportGradesController::class, 'generateReport']);


//Profile
$router->get('/profile', [ProfileController::class, 'index']);
$router->post('/profile/updateImage', [ProfileController::class, 'updateImage']);
$router->post('/profile/changePassword', [ProfileController::class, 'changePassword']);

// Add subject routes
$router->get('/subjects', [AddSubjectController::class, 'index']); // Display all subjects
$router->get('/subjects/create', [AddSubjectController::class, 'create']); // Show the form
$router->post('/subjects/store', [AddSubjectController::class, 'store']); // Handle form submission
$router->post('/subjects/delete', [AddSubjectController::class, 'delete']); // Handle subject deletion
$router->route($url, $method);