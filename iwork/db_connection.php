<?php

    // $cardnumber = $_POST["id"]; // Updated variable name
    //     $password = $_POST["password"];

        // Database connection settings
        $servername = "localhost";
        $db_username = "root";
        $db_password = "";
        $dbname = "iwork";

        // Create a connection to the database
        $conn = new mysqli($servername, $db_username, $db_password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
?>