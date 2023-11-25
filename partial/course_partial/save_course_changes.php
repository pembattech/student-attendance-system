<?php
// Assume you have a database connection established in your db_connection.php file
include "../../cred/db_connection.php";


ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you pass the course ID, new name, and new description via POST
    if (isset($_POST['course_id'], $_POST['new_name'], $_POST['new_desc'])) {
        $courseId = $_POST['course_id'];
        $newName = $_POST['new_name'];
        $newDesc = $_POST['new_desc'];

        // Perform the update in the database
        $sql = "UPDATE courses SET course = '$newName', description = '$newDesc' WHERE id = $courseId";

        if ($connection->query($sql) === TRUE) {
            echo json_encode(['status' => 'success', 'message' => 'Course changes saved successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error saving course changes']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Missing parameters']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

$connection->close();
?>
