<?php
$username = "root";
$password = "";
$server = 'localhost';
$db = "aimgod";


// $username = "mypoetry_admin";
// $password = 'aX0m9~U&6)Fr';
// $server = 'localhost';
// $db = "mypoetry_esports";


$con  = mysqli_connect($server,$username,$password,$db);

if (!$con) {
    echo "Connection unsuccessful";
    die("Not Connected " . mysqli_connect_error());
} 

if (!isset($_COOKIE['viewed'])) {
    // Update database and set cookie
    $sql = "UPDATE settings SET `data1` = `data1` + 1 WHERE id = 1";
    $con->query($sql);

    setcookie('viewed', '1', time() + (5 * 24 * 60 * 60));
}


?>