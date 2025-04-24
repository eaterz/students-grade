<?php
require "session.php";

require "Controller/AuthController.php";
require "Controller/DashboardController.php";



require "Router.php";


$router = new Router();

$url = parse_url($_SERVER["REQUEST_URI"])["path"];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];



$router->get('/', [AuthController::class, 'login']);
$router->post('/login/process', [AuthController::class, 'processLogin']);
$router->get('/logout', [AuthController::class, 'logout']);

$router->get('/dashboard', [DashboardController::class, 'dashboard']);





$router->route($url, $method);
