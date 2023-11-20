<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once 'cred/db_connection.php';
include 'partial/utils.php';

session_start();

$user_id = $_SESSION['user_id'];
$user_name = get_user_data($user_id)['name'];

?>

<div class="navbar">
    <div class="topbar-flex">
        <div class="title">
            <p>Student Attendance</p>
        </div>
        <div class="user_tool">
            <p><?php echo $user_name ?></p>
        </div>
    </div>
</div>
