<?php include 'header.php'; session_start(); ?>
<?php include 'db_connection.php';

   // Check if the form is submitted
   if (isset($_FILES["image"]) && !empty($_FILES["image"]["name"])) {
    $uploadDir = './uploads/images/'; // Specify the directory where you want to save the uploaded files
    $allowedTypes = ["jpg", "jpeg", "gif", "png"]; // Specify the allowed file types
  
    // Check if the file input is set and not empty
    if (isset($_FILES["image"]) && !empty($_FILES["image"]["name"])) {
        $fileName = basename($_FILES["image"]["name"]);
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $doc_number = $_POST['docnumber'];
        // Check if the file type is allowed
        if (in_array($fileType, $allowedTypes)) {
            $image_url = uniqid() . '.' . $fileType; // Generate a unique filename
            $uploadPath = $uploadDir . $image_url; // Generate a unique filename
            move_uploaded_file($_FILES["image"]["tmp_name"], $uploadPath);
            try {


      
    
                    $docnumber = $doc_number;
                    $image_url = $image_url; 
                    $image_add_by =   $_SESSION['cardnumber'];
                    $image_add_date_time =  date('Y-m-d H:i:s');
                    $image_status =  'a';
                
                
                    
                $sql = "INSERT INTO `ework_work_order_image` (`image_url`,`image_status`,`image_add_by`,`image_add_date_time`,`docnumber`)
                VALUES ('$image_url','$image_status','$image_add_by','$image_add_date_time','$docnumber')";

           
    
                    if ($conn->query($sql) === TRUE) {
                     // If the operation was successful
                    $response['success'] = true;
                    $response['message'] = 'New record created successfully';
                    exit;
                    } else {
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
        } else {
            echo "Invalid file type. Allowed types are: " . implode(", ", $allowedTypes);
        }
    } else {
        echo "No file selected!";
    }
    exit;
}else{
    echo "error";
}

    // Assuming $cartItems contains the data from your form
    $cartItems = isset($_POST['cartItems']) ? $_POST['cartItems'] : [];
    $line_number = 0;
    
if ($cartItems[0]['type']  == 'add'){

  
        try {


            foreach ($cartItems as $cartItem) { 
                $line_number++;
                $WorkOrder = $cartItem['WorkOrder'];
                $docdate = $cartItem['docdate']; 
                $WorkerAssignment = $cartItem['WorkerAssignment'];
                $ColorSizeAssortment = $cartItem['ColorSizeAssortment'];
                $GarmentParts = $cartItem['GarmentParts'];
                $WorkerActive = $cartItem['ActiveStatus'];
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
                $linenumber = $line_number+1;
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
                $doccreationtime =  $cartItem['doccreationtime'];
                $lineentrytime =  date('Y-m-d H:i:s');
                $docnumber = $cartItem['docnumber'];
                $ColorSizeEntry = $cartItem['ColorSizeEntry'];
                $LastStep = $cartItem['LastStep'];
                $cardnumber =  $cartItem['Worker'];
                $name = $cartItem['Name'];
                $position = $cartItem['Position'];
                
                
            $sql = "INSERT INTO `eworker_assignment` (`WorkOrder`,`docdate`,`quantity`,`SalesOrder`,`Style`,`StyleDescription`,`SalesOrderQuantity`,`linenumber`,`StepNumber`,`Process`,`Description_StepName`,`Machine`,
            `StepTimeMins`,`NextStep`,`FirstStep`,`docstatus`,`entrypersonbadge`,`entrypersonname`,`doccreationtime`,`docnumber`,`lineentrytime`,`ColorSizeEntry`,`cardnumber`,`name`,`position`,`site`,`building`,`floor`,
            `LastStep`,`WorkerAssignment`,`ColorSizeAssortment`,`GarmentParts`,`WorkerActive`,`Customer`)
            VALUES ('$WorkOrder','$docdate','$quantity','$SalesOrder','$Style','$StyleDescription','$SalesOrderQuantity','$linenumber','$StepNumber','$Process','$Description_StepName','$Machine','$StepTimeMins',
            '$NextStep','$FirstStep','$docstatus','$entrypersonbadge','$entrypersonname','$doccreationtime','$docnumber','$lineentrytime','$ColorSizeEntry','$cardnumber','$name','$position','$site','$building','$floor',
            '$LastStep','$WorkerAssignment','$ColorSizeAssortment','$GarmentParts','$WorkerActive','$Customer')";

                if ($conn->query($sql) === TRUE) {
                    // If the operation was successful
                    $response['success'] = true;
                    $response['message'] = 'New record created successfully';
                } else {
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


        
        try {

        $doc_number =  $cartItems[0]['docnumber'];
        $doc_line =  $cartItems[0]['linenumber'];
            
        $sql = "SELECT idlines FROM `ework_sales_order` where docnumber = '$doc_number' and linenumber = '$doc_line'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $sewing_line_data = [];
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $sewing_line_data[] =  $row;
        }
        } else {
        echo "0 results";
        }
            foreach($sewing_line_data as $value){
                $idlines = $value['idlines'];
            
        
            $sql = "UPDATE ework_sales_order SET WorkerAssignment = 'Yes' WHERE idlines = '$idlines';";

            
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


}elseif($cartItems[0]['type']  == 'update'){

     
        try {


        foreach ($cartItems as $cartItem) { 
            $line_number++;
            $WorkOrder = $cartItem['WorkOrder'];
            $docdate = $cartItem['docdate']; 
            $WorkerAssignment = $cartItem['WorkerAssignment'];
            $ColorSizeAssortment = $cartItem['ColorSizeAssortment'];
            $GarmentParts = $cartItem['GarmentParts'];
            $WorkerActive = $cartItem['WorkerActive'];
            $site = $cartItem['site'];
            $building = $cartItem['building'];
            $floor = $cartItem['floor'];
            // $line = $cartItem['line'];
            $quantity = $cartItem['quantity'];
            $SalesOrder = $cartItem['SalesOrder'];
            $Customer = $cartItem['Customer'];
            $Style = $cartItem['Style']; 
            $StyleDescription = $cartItem['StyleDescription']; 
            $SalesOrderQuantity = $cartItem['SalesOrderQuantity'];
            $linenumber = $line_number+1;
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
            $doccreationtime =  $cartItem['doccreationtime'];
            $lineentrytime =  date('Y-m-d H:i:s');
            $docnumber = $cartItem['docnumber'];
            $ColorSizeEntry = $cartItem['ColorSizeEntry'];
            $LastStep = $cartItem['LastStep'];
            $cardnumber =  $cartItem['Worker'];
            $name = $cartItem['Name'];
            $position = $cartItem['Position'];
            
        $sql = "INSERT INTO `eworker_assignment` (`WorkOrder`,`docdate`,`quantity`,`SalesOrder`,`Style`,`StyleDescription`,`SalesOrderQuantity`,`linenumber`,`StepNumber`,`Process`,`Description_StepName`,`Machine`,
        `StepTimeMins`,`NextStep`,`FirstStep`,`docstatus`,`entrypersonbadge`,`entrypersonname`,`doccreationtime`,`docnumber`,`lineentrytime`,`ColorSizeEntry`,`cardnumber`,`name`,`position`,`site`,`building`,`floor`,
        `LastStep`,`WorkerAssignment`,`ColorSizeAssortment`,`GarmentParts`,`WorkerActive`,`Customer`)
         VALUES ('$WorkOrder','$docdate','$quantity','$SalesOrder','$Style','$StyleDescription','$SalesOrderQuantity','$linenumber','$StepNumber','$Process','$Description_StepName','$Machine','$StepTimeMins',
         '$NextStep','$FirstStep','$docstatus','$entrypersonbadge','$entrypersonname','$doccreationtime','$docnumber','$lineentrytime','$ColorSizeEntry','$cardnumber','$name','$position','$site','$building','$floor',
         '$LastStep','$WorkerAssignment','$ColorSizeAssortment','$GarmentParts','$WorkerActive','$Customer')";

            if ($conn->query($sql) === TRUE) {
                // If the operation was successful
                $response['success'] = true;
                $response['message'] = 'New record created successfully';
            } else {
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


}elseif($cartItems[0]['type']  == 'edit'){

    try {
        
            
        $idlines =  $cartItems[0]['idlines'];
        $cardnumber =  $cartItems[0]['cardnumber'];
        $name = $cartItems[0]['name'];
        $position = $cartItems[0]['position'];
        $WorkerActive = $cartItems[0]['WorkerActive'];


    
    
    
        $sql = "UPDATE eworker_assignment SET cardnumber = '$cardnumber', name ='$name', position = '$position', WorkerActive = '$WorkerActive' WHERE idlines = '$idlines';";

     
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


}elseif($cartItems[0]['type']  == 'delete'){

    try {
        
            
        $idlines =  $cartItems[0]['idlines'];

    
    
    
        $sql = " DELETE FROM eworker_assignment  WHERE idlines = $idlines;";

           
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


}

// Move this outside of the loop
$conn->close(); 


?>