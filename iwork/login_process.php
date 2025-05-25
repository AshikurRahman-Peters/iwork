<?php
session_start();
include 'db_connection.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cardnumber = $_POST["id"]; // Updated variable name
    $password = $_POST["password"];



    // Create a connection to the database
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize user input to prevent SQL injection (you should use prepared statements for better security)
    $cardnumber = $conn->real_escape_string($cardnumber);


// Set the timezone to Bangladesh
date_default_timezone_set('Asia/Dhaka');

// Get the current date and time
$currentDateTime = date('Y-m-d H:i:s');


    // Perform a database query to check if the user exists and the password matches
    $query = "SELECT * 
    FROM
        eworker_assignment AS C
    LEFT JOIN
        ework_workers AS A ON C.cardnumber = A.cardnumber
    LEFT JOIN
        ework_sales_order AS B ON C.WorkOrder = B.WorkOrder
    WHERE
        C.cardnumber = '$cardnumber'
   	and B.docstatus=1
    and C.WorkerActive=1
    and C.StepActive=1
    AND C.WorkOrder = B.WorkOrder
  limit 1";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $hashed_password = md5($password);

        if ($hashed_password === $user['password']) {
            $_SESSION['cardnumber'] = $cardnumber;
            $_SESSION['loginDatetime'] = $currentDateTime;
            header("Location: status.php");
        } else {
            $_SESSION['error'] = "Invalid password";
            header("Location: index.php");
        }
    } else {
        $_SESSION['error'] = "Invalid username";
        header("Location: index.php");
    }

    // Close the database connection
    $conn->close();
}
?>