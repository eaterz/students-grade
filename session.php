<?php
if (!isset($_SESSION) || session_status() == PHP_SESSION_NONE) {
    session_set_cookie_params(86400);
    session_start();
}
$_SESSION['token'] = md5(uniqid(mt_rand(), true));
