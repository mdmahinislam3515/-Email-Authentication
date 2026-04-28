<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "my_website";

$con = mysqli_connect($host, $username, $password, $database);

if (!$con) {
    die("Database connection failed.");
}

mysqli_set_charset($con, "utf8mb4");
?>