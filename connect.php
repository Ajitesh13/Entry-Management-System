<?php
    $servername = "localhost";
    $username = "root";
    $password = "password";
    $dbname = "entry-management-system";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    echo "Connected successfully";
?>