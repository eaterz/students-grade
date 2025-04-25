<?php

require "session.php";
require "Controller/AuthController.php";
require "Controller/DashboardController.php";
require "Controller/AddStudentsController.php";
require "Controller/AddSubjectController.php"; // Include the AddSubjectController
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

// Add subject routes
$router->get('/subjects', [AddSubjectController::class, 'index']); // Display all subjects
$router->get('/subjects/create', [AddSubjectController::class, 'create']); // Show the form
$router->post('/subjects/store', [AddSubjectController::class, 'store']); // Handle form submission

$router->route($url, $method);