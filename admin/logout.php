<?php
include '../assets/php/config.php';
session_start();

session_unset();
session_destroy();
header("Location: login.php");
setcookie("adminlogincheck", "", time() - 3600, '/');
exit;
?>