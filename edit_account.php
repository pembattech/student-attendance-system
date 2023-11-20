<?php

include "cred/db_connection.php";

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


// Function to update user account information
function update_user_account($user_id, $name, $username, $password)
{
    global $connection;

    // Sanitize input to prevent SQL injection
    $name = mysqli_real_escape_string($connection, $name);
    $username = mysqli_real_escape_string($connection, $username);

    // Check if a new password is provided
    $password_update = '';
    if (!empty($password)) {
        // Hash the new password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $password_update = ", password = '$hashed_password'";
    }

    // Update the user account information
    $query = "UPDATE users SET name = '$name', username = '$username' $password_update WHERE id = $user_id";

    if ($connection->query($query) === TRUE) {
        // User account updated successfully
        return true;
    } else {
        // Error updating user account
        return false;
    }
}

// Function to check if a username is already taken
function is_username_taken($username, $current_user_id)
{
    global $connection;

    // Sanitize input to prevent SQL injection
    $username = mysqli_real_escape_string($connection, $username);

    // Check if the username is taken by another user
    $query = "SELECT id FROM users WHERE username = '$username' AND id != $current_user_id";
    $result = $connection->query($query);

    if ($result && $result->num_rows > 0) {
        // Username is already taken
        return true;
    } else {
        // Username is available
        return false;
    }
}

// Set content type to JSON
header("Content-Type: application/json");

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Assume you have a function to sanitize and validate input
    function sanitize_input($data)
    {
        // Implement your logic to sanitize and validate input
        return $data;
    }

    // Assume you have session management in place
    session_start();
    $user_id = $_SESSION['user_id'];

    // Get input data
    $name = sanitize_input($_POST["editName"]);
    $username = sanitize_input($_POST["editUsername"]);
    $password = sanitize_input($_POST["editPassword"]);

    // Validation
    $errors = [];

    // Validate Name
    if (empty($name)) {
        $errors["name"] = "Name is required.";
    }

    // Validate Username
    if (empty($username)) {
        $errors["username"] = "Username is required.";
    } elseif (is_username_taken($username, $user_id)) {
        $errors["username"] = "Username is already taken.";
    }

    // If there are no validation errors, update the user account
    if (empty($errors)) {
        // Update user account information
        if (update_user_account($user_id, $name, $username, $password)) {
            echo json_encode(["status" => "success"]);
            exit;
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update user account."]);
            exit;
        }
    } else {
        // Return validation errors
        echo json_encode(["status" => "error", "errors" => $errors]);
        exit;
    }
} else {
    // If the request is not a POST request, return an error
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
    exit;
}
?>
