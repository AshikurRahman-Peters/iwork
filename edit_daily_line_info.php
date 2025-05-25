<?php
// Assuming you have established a database connection ($conn)
// ...
include 'db_connection.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch values from the form
    $Date = $_POST['Date'];
    $SewingLine = $_POST['SewingLine'];
    $WorkingHour = $_POST['WorkingHour'];
    $TargetEfficiency = $_POST['TargetEfficiency'];
    $WorkOrder = $_POST['WorkOrder'];
    $Style = $_POST['Style'];
    $actualworkinghour = $_POST['actualworkinghour'];
    $id = $_POST['id'];
    // SQL query to update all fields based on the card number

    $sql = "UPDATE ework_target_efficiency SET 
                `Date` = '$Date', 
                `SewingLine` = '$SewingLine', 
                `WorkingHour` = '$WorkingHour', 
                `TargetEfficiency` = '$TargetEfficiency', 
                `WorkOrder` = '$WorkOrder', 
                `Style` = '$Style', 
                `actualworkinghour` = '$actualworkinghour'
            WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        // Success message or redirect to a success page
        echo '<script>alert("Record updated successfully");</script>';
        echo '<script>window.location.href = "all_daily_line_info.php";</script>';
    } else {
        // Error message
        echo "Error updating record: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
