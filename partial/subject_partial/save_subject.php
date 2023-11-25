<?php
include "../../cred/db_connection.php";

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Validate the form data
$errors = array();

if (empty($_POST['subjectName'])) {
    $errors['subjectName'] = 'Subject name is required.';
}
if (empty($_POST['subjectDesc'])) {
    $errors['subjectDesc'] = 'Subject description is required.';
}

// If there are validation errors, send an error response
if (!empty($errors)) {
    header('Content-Type: application/json');
    echo json_encode(array('status' => 'error', 'errors' => $errors));
    exit;
}

// If validation passes, process the form data and save it to the database
$subjectName = $_POST['subjectName'];
$subjectDesc = $_POST['subjectDesc'];

$sql = "INSERT INTO subjects (subject, description) VALUES ('$subjectName', '$subjectDesc')";

if ($connection->query($sql) === TRUE) {
    // Get the inserted data (you may customize this part based on your needs)
    $lastInsertId = $connection->insert_id;
    $selectSql = "SELECT * FROM subjects WHERE id = $lastInsertId";
    $result = $connection->query($selectSql);

    // Fetch the inserted row
    $insertedData = $result->fetch_assoc();

    // Prepare the response in DataTables format
    $response = array('status' => 'success', 'data' => array('data' => $insertedData));

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    header('Content-Type: application/json');
    echo json_encode(array('status' => 'error', 'message' => 'Error saving subject. Please try again.'));
}
?>
