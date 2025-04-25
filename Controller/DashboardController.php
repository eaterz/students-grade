<?php

// require "Validator.php";
class DashboardController
{
    public function dashboard()
    {
        if (Validator::Role() == false) { //only can use this if logged in
            header("Location: /");
            exit();
        }
        include './view/dashboard.php';
    }
}
