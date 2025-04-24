<?php

class Validator
{
    public static function Role(string $role = "")
    {
        if (!isset($_SESSION['user'])) {
            return false;
        }

        if ($role == '' && isset($_SESSION['user'])) {
            return true;
        }

        if ($_SESSION['user']['role'] !== $role) {
            return false;
        }

        return true;
    }
    public static function Crsf()
    {
        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);

        if (!$token || $token !== $_SESSION['token']) {
            return false;
        } else {
            return true;
        }

        return false;
    }

    public static function Email(string $email)
    {
        $string = trim($email);

        if (!filter_var($string, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }

    public static function Password(string $password, $min = 0, $max = INF)
    {
        $string = trim($password);

        if (!is_string($string)) {
            return false;
        }

        if (strlen($string) < $min) {
            return false;
        }

        if (strlen($string) >= $max) {
            return false;
        }

        return true;
    }

    public static function String(string $string, $min = 0, $max = INF)
    {
        $string = trim($string);

        if (!is_string($string)) {
            return false;
        }

        if (strlen($string) < $min) {
            return false;
        }

        if (strlen($string) >= $max) {
            return false;
        }

        return true;
    }

    public static function Date($date, $format = 'Y-m-d')
    {
        $input_date = DateTime::createFromFormat($format, $date);
        $current_date = new DateTime();
        if (!DateTime::createFromFormat($format, $date)) {
            return false;
        }

        if ($input_date > $current_date) {
            return false;
        }


        return true;
    }

    public static function Gender(string $gender)
    {
        $string = trim($gender);
        $string = strtolower($string);

        if ($string == "male" || $string == "female") {
            return false;
        }

        return true;
    }

    public static function Number($number, $min = 0, $max = INF)
    {

        if (!is_numeric($number)) {
            return false;
        }

        if ($number <= $min) {
            return false;
        }

        if ($number >= $max) {
            return false;
        }

        return true;
    }
}
