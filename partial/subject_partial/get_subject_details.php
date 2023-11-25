<?php
include "../../cred/db_connection.php";

if (isset($_GET['subject_id'])) {
    $subjectId = $_GET['subject_id'];

    // Fetch subject details from the database
    $sql = "SELECT * FROM subjects WHERE id = $subjectId";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $subjectData = $result->fetch_assoc();
        echo json_encode($subjectData);
    } else {
        echo json_encode(['error' => 'Subject not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid subject ID']);
}

$connection->close();
?>
