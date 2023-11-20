<?php

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

include "cred/db_connection.php";

session_start(); // Start the session

// Function to validate user credentials
function authenticateUser($username, $password) {
    global $connection;

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $connection->query($sql);

    if ($result && $result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // User found, authentication successful
            $_SESSION['user_id'] = $row['id'];
            return "success";
        }
    }

    // User not found or invalid credentials
    return false;
}

$usernameErr = $passwordErr = $error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Reset error variables
    $usernameErr = $passwordErr = $error_message = "";

    if (isset($_POST["username"])) {
        $inputUsername = $_POST["username"];
        // Validate username
        if (empty($inputUsername)) {
            $usernameErr = "Username is required";
        }
    }

    if (isset($_POST["password"])) {
        $inputPassword = $_POST["password"];
        // Validate password
        if (empty($inputPassword)) {
            $passwordErr = "Password is required";
        }
    }

    // If there are no validation errors, attempt authentication
    if (empty($usernameErr) && empty($passwordErr)) {
        if (authenticateUser($inputUsername, $inputPassword)) {
            // Authentication successful, redirect to dashboard or home page
            header("Location: base.php");
            exit();
        } else {
            // Authentication failed, display an error message
            $error_message = "Invalid username or password";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <form method="post" action="" style="text-align: center;">
    <h2>Login</h2>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <span class="error"><?php echo $usernameErr; ?></span>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <span class="error"><?php echo $passwordErr; ?></span>
        <br>
        <button type="submit">Login</button>
        <?php if (!empty($error_message)) { ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php } ?>
    </form>
</body>

</html>
