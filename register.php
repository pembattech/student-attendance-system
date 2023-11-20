<?php
include "cred/db_connection.php";

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Function to register a new faculty member
function registerFaculty($name, $email, $contact, $address) {
    global $connection;


    $sql = "INSERT INTO faculty (name, email, contact, address) VALUES ('$name', '$email', '$contact', '$address')";
    
    if ($connection->query($sql) === TRUE) {
        return $connection->insert_id; // Return the ID of the newly inserted faculty
    } else {
        return false; // Faculty registration failed
    }
}

// Function to register a new user
function registerUser($name, $username, $password, $type, $faculty_id) {
    global $connection;

    $name = mysqli_real_escape_string($connection, $name);
    $username = mysqli_real_escape_string($connection, $username);
    $password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, username, password, type, faculty_id) VALUES ('$name', '$username', '$password', '$type', '$faculty_id')";
    
    if ($connection->query($sql) === TRUE) {
        return true; // Registration successful
    } else {
        return false; // Registration failed
    }
}

$nameErr = $emailErr = $contactErr = $addressErr = $usernameErr = $passwordErr = $error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Reset error variables
    $nameErr = $emailErr = $contactErr = $addressErr = $usernameErr = $passwordErr = $error_message = "";

    if (isset($_POST["name"])) {
        $inputName = $_POST["name"];
        // Validate name
        if (empty($inputName)) {
            $nameErr = "Name is required";
        }
    }

    if (isset($_POST["email"])) {
        $inputEmail = $_POST["email"];
        // Validate email
        if (empty($inputEmail)) {
            $emailErr = "Email is required";
        }
    }

    if (isset($_POST["contact"])) {
        $inputContact = $_POST["contact"];
        // Validate contact
        if (empty($inputContact)) {
            $contactErr = "Contact is required";
        }
    }

    if (isset($_POST["address"])) {
        $inputAddress = $_POST["address"];
        // Validate address
        if (empty($inputAddress)) {
            $addressErr = "Address is required";
        }
    }

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

    // If there are no validation errors, attempt registration
    if (empty($nameErr) && empty($emailErr) && empty($contactErr) && empty($addressErr) && empty($usernameErr) && empty($passwordErr)) {
        // Register faculty first
        $faculty_id = registerFaculty($inputName, $inputEmail, $inputContact, $inputAddress);

        if ($faculty_id) {
            // Faculty registration successful, proceed with user registration
            if (registerUser($inputName, $inputUsername, $inputPassword, 2, $faculty_id)) {
                echo 'Registration successful';
                // Registration successful, you may redirect to login page or perform other actions
            } else {
                // Registration failed, display an error message
                $error_message = "Registration failed. Please try again.";
            }
        } else {
            // Faculty registration failed, display an error message
            $error_message = "Faculty registration failed. Please try again.";
        }
    }
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <style>
        /* Add your styling here */
    </style>
</head>

<body>
    <form method="post" action="" style="text-align: center;">
        <h2>Registration</h2>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br>
        <span class="error"><?php echo $nameErr; ?></span>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <span class="error"><?php echo $emailErr; ?></span>
        <br>
        <label for="contact">Contact:</label>
        <input type="text" id="contact" name="contact" required>
        <br>
        <span class="error"><?php echo $contactErr; ?></span>
        <br>
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>
        <br>
        <span class="error"><?php echo $addressErr; ?></span>
        <br>
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
        <button type="submit">Register</button>
        <?php if (!empty($error_message)) { ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php } ?>
    </form>
</body>

</html>
