<?php

// include "../cred/db_connection.php";

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Function to get user data from the database
function get_user_data($user_id)
{
    global $connection;
    $sql = "SELECT * FROM users WHERE id = '$user_id'";
    $result = mysqli_query($connection, $sql);
    if (mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        return $user_data;
    } else {
        return "User not exists.";
    }
}

?>
