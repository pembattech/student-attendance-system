<?php
include "../../cred/db_connection.php";


ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


// Query to retrieve all subjects from the database
$sql = "SELECT * FROM subjects";
$result = $connection->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Fetch all rows into an array
    $subjects = $result->fetch_all(MYSQLI_ASSOC);

    // Prepare the response in DataTables format
    $response = array('data' => $subjects);

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // If no subjects found, return an empty array
    $response = array('data' => array());

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
