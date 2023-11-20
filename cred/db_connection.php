<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "attendance_sys_student";

$connection = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

?>
