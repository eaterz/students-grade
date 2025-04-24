<?php

// require "Validator.php";
class DashboardController
{
    public function dashboard()
    {
        if (Validator::Role() == false) { //only can use this if logged in
            header("Location: /login");
            exit();
        }
        include './view/dashboard.php';
    }
}
