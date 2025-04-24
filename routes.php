<?php
require "session.php";

require "Controller/AuthController.php";
require "Controller/DashboardController.php";
require "Controller/AddStudentsController.php";


require "Router.php";


$router = new Router();

$url = parse_url($_SERVER["REQUEST_URI"])["path"];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];



$router->get('/', [AuthController::class, 'login']);
$router->post('/login/process', [AuthController::class, 'processLogin']);
$router->get('/logout', [AuthController::class, 'logout']);

$router->get('/dashboard', [DashboardController::class, 'dashboard']);

//add student
$router->get('/students', [AddStudentsController::class, 'index']);
$router->get('/students/create', [AddStudentsController::class, 'create']);
$router->post('/students/create/store', [AddStudentsController::class, 'store']);
$router->post('/students/delete', [AddStudentsController::class, 'destroy']);






$router->route($url, $method);
