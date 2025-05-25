<?php include 'header.php'; session_start(); ?>
<?php include 'db_connection.php';

?>
<?php
// Assuming $cartItems contains the data from your form
$docstatus = isset($_POST['cartItems']) ? $_POST['cartItems'] : [];

if ($docstatus[0]['type'] == 'updateDocStatus') {

    try {
        $docnumber =  $docstatus[0]['docnumber'];
      

        $sql = "UPDATE ework_sales_order SET docstatus = 1 WHERE docnumber = '$docnumber';";

        // print_r($sql);
            if ($conn->query($sql) === TRUE) {
                // If the operation was successful
                $response['success'] = true;
                $response['message'] = 'New record created successfully';
            } else {
                // If the operation failed
                $response['success'] = false;
                $response['message'] = 'Error creating new record';
            }
            
            // Convert the response array to JSON format
            $json_response = json_encode($response);
            $_SESSION['form_submitted'] = true;
            // Send the JSON response back to the client
            echo $json_response;
   
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}elseif ($docstatus[0]['type'] == 'CloseDocStatus') {

    try {
        $docnumber =  $docstatus[0]['docnumber'];
      

        $sql = "UPDATE eworker_assignment SET docstatus = 9 WHERE docnumber = '$docnumber';";

        // print_r($sql);
            if ($conn->query($sql) === TRUE) {
                // If the operation was successful
                $response['success'] = true;
                $response['message'] = 'New record created successfully';
            } else {
                // If the operation failed
                $response['success'] = false;
                $response['message'] = 'Error creating new record';
            }
            
            // Convert the response array to JSON format
            $json_response = json_encode($response);
            $_SESSION['form_submitted'] = true;
            // Send the JSON response back to the client
            echo $json_response;
   
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    try {
        $docnumber =  $docstatus[0]['docnumber'];
      

        $sql = "UPDATE ework_order_wise_color_size_qty SET docstatus = 9 WHERE WO_docnumber = '$docnumber';";

        // print_r($sql);
            if ($conn->query($sql) === TRUE) {
                // If the operation was successful
                $response['success'] = true;
                $response['message'] = 'New record created successfully';
            } else {
                // If the operation failed
                $response['success'] = false;
                $response['message'] = 'Error creating new record';
            }
            
            // Convert the response array to JSON format
            $json_response = json_encode($response);
            $_SESSION['form_submitted'] = true;
            // Send the JSON response back to the client
            echo $json_response;
   
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    try {
        $docnumber =  $docstatus[0]['docnumber'];
      

        $sql = "UPDATE ework_partname SET docstatus = 9 WHERE wo_docnumber = '$docnumber';";

        // print_r($sql);
            if ($conn->query($sql) === TRUE) {
                // If the operation was successful
                $response['success'] = true;
                $response['message'] = 'New record created successfully';
            } else {
                // If the operation failed
                $response['success'] = false;
                $response['message'] = 'Error creating new record';
            }
            
            // Convert the response array to JSON format
            $json_response = json_encode($response);
            $_SESSION['form_submitted'] = true;
            // Send the JSON response back to the client
            echo $json_response;
   
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    try {
        $docnumber =  $docstatus[0]['docnumber'];
      

        $sql = "UPDATE ework_sales_order SET docstatus = 9 WHERE docnumber = '$docnumber';";

        // print_r($sql);
            if ($conn->query($sql) === TRUE) {
                // If the operation was successful
                $response['success'] = true;
                $response['message'] = 'New record created successfully';
            } else {
                // If the operation failed
                $response['success'] = false;
                $response['message'] = 'Error creating new record';
            }
            
            // Convert the response array to JSON format
            $json_response = json_encode($response);
            $_SESSION['form_submitted'] = true;
            // Send the JSON response back to the client
            echo $json_response;
   
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}elseif ($docstatus[0]['type'] == 'ReOpen') {

    try {
        $docnumber =  $docstatus[0]['docnumber'];
      

        $sql = "UPDATE eworker_assignment SET docstatus = 0 WHERE docnumber = '$docnumber';";

        // print_r($sql);
            if ($conn->query($sql) === TRUE) {
                // If the operation was successful
                $response['success'] = true;
                $response['message'] = 'New record created successfully';
            } else {
                // If the operation failed
                $response['success'] = false;
                $response['message'] = 'Error creating new record';
            }
            
            // Convert the response array to JSON format
            $json_response = json_encode($response);
            $_SESSION['form_submitted'] = true;
            // Send the JSON response back to the client
            echo $json_response;
   
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    try {
        $docnumber =  $docstatus[0]['docnumber'];
      

        $sql = "UPDATE ework_order_wise_color_size_qty SET docstatus = 0 WHERE WO_docnumber = '$docnumber';";

        // print_r($sql);
            if ($conn->query($sql) === TRUE) {
                // If the operation was successful
                $response['success'] = true;
                $response['message'] = 'New record created successfully';
            } else {
                // If the operation failed
                $response['success'] = false;
                $response['message'] = 'Error creating new record';
            }
            
            // Convert the response array to JSON format
            $json_response = json_encode($response);
            $_SESSION['form_submitted'] = true;
            // Send the JSON response back to the client
            echo $json_response;
   
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    try {
        $docnumber =  $docstatus[0]['docnumber'];
      

        $sql = "UPDATE ework_partname SET docstatus = 0 WHERE wo_docnumber = '$docnumber';";

        // print_r($sql);
            if ($conn->query($sql) === TRUE) {
                // If the operation was successful
                $response['success'] = true;
                $response['message'] = 'New record created successfully';
            } else {
                // If the operation failed
                $response['success'] = false;
                $response['message'] = 'Error creating new record';
            }
            
            // Convert the response array to JSON format
            $json_response = json_encode($response);
            $_SESSION['form_submitted'] = true;
            // Send the JSON response back to the client
            echo $json_response;
   
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    try {
        $docnumber =  $docstatus[0]['docnumber'];
      

        $sql = "UPDATE ework_sales_order SET docstatus = 0 WHERE docnumber = '$docnumber';";

        // print_r($sql);
            if ($conn->query($sql) === TRUE) {
                // If the operation was successful
                $response['success'] = true;
                $response['message'] = 'New record created successfully';
            } else {
                // If the operation failed
                $response['success'] = false;
                $response['message'] = 'Error creating new record';
            }
            
            // Convert the response array to JSON format
            $json_response = json_encode($response);
            $_SESSION['form_submitted'] = true;
            // Send the JSON response back to the client
            echo $json_response;
   
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}else{

    $sql = "Select MAX(docnumber) as docnumber from ework_sales_order";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        // print_r($row);  
        $split_data =  str_split($row['docnumber'],4);
        $new_doc_number = 'EWO-' . ($split_data[1] + 1);
    
      }
    
    } else {
      echo "0 results";
    }


    // Assuming $cartItems contains the data from your form
    $cartItems = isset($_POST['cartItems']) ? $_POST['cartItems'] : [];
    $line_number = 0;

        try {


            foreach ($cartItems as $cartItem) { 
              $line_number++;
                $WorkOrder = $cartItem['WorkOrder'];
                $docdate = $cartItem['docdate']; 
                $Version = $cartItem['Version'];
                $site = $cartItem['site'];
                $building = $cartItem['building'];
                $floor = $cartItem['floor'];
                $line = $cartItem['line'];
                $quantity = $cartItem['quantity'];
                $SalesOrder = $cartItem['SalesOrder'];
                $Customer = $cartItem['Customer'];
                $Style = $cartItem['Style']; 
                $StyleDescription = $cartItem['StyleDescription']; 
                $SalesOrderQuantity = $cartItem['SalesOrderQuantity'];
                $linenumber = $line_number;
                $StepNumber = $cartItem['StepNumber']; 
                $Process = $cartItem['Process'];
                $Description_StepName = $cartItem['Description_StepName'];
                $Machine = $cartItem['Machine']; 
                $StepTimeMins = $cartItem['StepTimeMins']; 
                $NextStep = $cartItem['NextStep'];
                $FirstStep = $cartItem['FirstStep'];
                $docstatus = 0;
                $entrypersonbadge = $_SESSION['cardnumber'];
                $entrypersonname = 'test';
                $doccreationtime =  date('Y-m-d H:i:s');
                $docnumber = $new_doc_number;
                $ColorSizeEntry = $cartItem['ColorSizeEntry'];
                $LastStep = $cartItem['LastStep'];
                $ActiveStatus = $cartItem['ActiveStatus'];
                
            $sql = "INSERT INTO `ework_sales_order` (`WorkOrder`, `docdate`, `quantity`, `SalesOrder`, `Customer`, `Style`, `StyleDescription`, `SalesOrderQuantity`, `linenumber`, `StepNumber`, `Process`, `Description_StepName`,
                `Machine`, `StepTimeMins`, `NextStep`, `FirstStep`,`LastStep`,`docstatus`, `entrypersonbadge`, `entrypersonname`, `doccreationtime`, `docnumber`,`line`,`ColorSizeEntry`,`site`,`building`,`floor`,`Version`)
            VALUES
                    ('$WorkOrder', '$docdate', '$quantity', '$SalesOrder', '$Customer', '$Style', '$StyleDescription', '$SalesOrderQuantity',
                  '$linenumber', '$StepNumber', '$Process', '$Description_StepName', '$Machine', '$StepTimeMins', '$NextStep',
                '$FirstStep','$LastStep','$docstatus','$entrypersonbadge','$entrypersonname','$doccreationtime','$docnumber','$line','$ColorSizeEntry','$site','$building','$floor','$Version')";

            
                // use query() method for MySQLi
                if ($conn->query($sql) === TRUE) {
                    // If the operation was successful
                    $response['success'] = true;
                    $response['message'] = 'New record created successfully';
                } else {
                    // If the operation failed
                    $response['success'] = false;
                    $response['message'] = 'Error creating new record';
                }
                
                // Convert the response array to JSON format
                $json_response = json_encode($response);
                $_SESSION['form_submitted'] = true;
                // Send the JSON response back to the client
                echo $json_response;
          
        }
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
  }
// Move this outside of the loop
$conn->close(); 


?>