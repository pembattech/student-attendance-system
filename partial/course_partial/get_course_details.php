<?php
include "../../cred/db_connection.php";

if (isset($_GET['course_id'])) {
    $courseId = $_GET['course_id'];

    // Fetch course details from the database
    $sql = "SELECT * FROM courses WHERE id = $courseId";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $courseData = $result->fetch_assoc();
        echo json_encode($courseData);
    } else {
        echo json_encode(['error' => 'Course not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid course ID']);
}

$connection->close();
?>
