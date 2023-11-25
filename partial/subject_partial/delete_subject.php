<?php
include "../../cred/db_connection.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you pass the subject ID via POST
    if (isset($_POST['subject_id'])) {
        $subjectId = $_POST['subject_id'];

        // Perform the deletion in the database
        $sql = "DELETE FROM subjects WHERE id = $subjectId";

        if ($connection->query($sql) === TRUE) {
            echo json_encode(['status' => 'success', 'message' => 'Subject deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error deleting subject']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Missing subject ID']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

?>
