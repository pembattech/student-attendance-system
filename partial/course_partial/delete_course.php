<?php
include "../../cred/db_connection.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you pass the course ID via POST
    if (isset($_POST['course_id'])) {
        $courseId = $_POST['course_id'];

        // Perform the deletion in the database
        $sql = "DELETE FROM courses WHERE id = $courseId";

        if ($connection->query($sql) === TRUE) {
            echo json_encode(['status' => 'success', 'message' => 'Course deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error deleting course']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Missing course ID']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

?>
