<?php
$host = "localhost";
$user = getenv('APP_USER');
$password = getenv('APP_PASSWORD');
$db_name = "snake_game";

$con = mysqli_connect($host, $user, $password, $db_name);
if (mysqli_connect_errno()) {
    die("Failed to connect with MySQL: " . mysqli_connect_error());
}
?>