<?php

// include "../cred/db_connection.php";

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Function to get user data from the database
function get_user_data($user_id)
{
    global $connection;
    $sql = "SELECT * FROM users WHERE id = '$user_id'";
    $result = mysqli_query($connection, $sql);
    if (mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        return $user_data;
    } else {
        return "User not exists.";
    }
}

function getAllCourses($table_class) {
    global $connection;
    
    $sql = "SELECT * FROM courses";

    // Execute the query
    $result = $connection->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {
        // Start the HTML table
        echo "<table border='1' id='courseList' class='$table_class'>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Course</th>
                    <th>Description</th>
                    <th>Date Created</th>
                    </tr>
                </thead>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["course"] . "</td>
                    <td>" . $row["description"] . "</td>
                    <td>" . $row["date_created"] . "</td>
                </tr>";
        }

        // Close the HTML table
        echo "</table>";
    } else {
        // If there are no results
        echo "No courses found";
    }
}

?>
