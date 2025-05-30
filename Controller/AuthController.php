<?php

require "Models/UserModel.php";
require "Validator.php";

class AuthController
{
    public function login()
    {
        include './view/login.php';
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['user']);
        session_destroy();
        header('Location: /');
        exit;
    }

    public function processLogin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];
            $userModel = new UserModel();

            $personal_code = trim($_POST['personal_code'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (!Validator::String($personal_code)) {
                $errors[] = "Personal code must be a valid string.";
            }

            if (!Validator::Password($password)) {
                $errors[] = "Password must be a valid string.";
            }

            $user = $userModel->getUser($personal_code);

            if (!$user || !isset($user[0])) {
                $errors[] = "User does not exist.";
            } else {
                $storedPassword = $user[0]['password'] ?? '';
                if ($password !== $storedPassword) {
                    $errors[] = "Password is incorrect.";
                }
                
            }

            if (empty($errors)) {
                $_SESSION['user'] = $user[0];
                header('Location: /dashboard');
                exit;
            } else {
                $_SESSION['login_errors'] = $errors;
                include './view/login.php';
            }
        } else {
            header('Location: /');
            exit;
        }
    }

}
