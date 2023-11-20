<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/css/styles.css">
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .navbar {
            background-color: #3498db;
            color: #fff;
            padding: 10px;
        }

        .topbar-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
        }

        .user_tool {
            font-size: 18px;
        }

        .sidebar {
            width: 200px;
            background-color: #2c3e50;
            color: #ecf0f1;
            height: 100vh;
            padding-top: 20px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        li:hover {
            background-color: #34495e;
        }

        .container {
            padding: 20px;
            margin-left: 200px; /* Adjust this to match the width of the sidebar */
        }

        h1 {
            color: #2c3e50;
        }

        a {
            text-decoration: none;
            color: #ecf0f1;
        }
    </style>
</head>
<body>

<?php
include 'partial/navbar.php';
include 'partial/sidebar.php';
?>

<div class="container">
    <h1>Hello world</h1>
</div>

</body>
</html>
