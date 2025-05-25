<?php 
	include 'header.php'; 
	session_start();
	include 'db_connection.php'; 
?>
<?php
	$cartItems = isset($_POST['cartItems']) ? $_POST['cartItems'] : [];
	if($cartItems[0]['type']  == 'edit'){
			try {
	        $idlines =  $cartItems[0]['idlines'];
	        $lg_StepNumber =  $cartItems[0]['lg_StepNumber'];
	        $lg_Process =  $cartItems[0]['lg_Process'];
	        $lg_Description_StepName =  $cartItems[0]['lg_Description_StepName'];
	        $lg_Machine =  $cartItems[0]['lg_Machine'];
	        $lg_StepTimeMins =  $cartItems[0]['lg_StepTimeMins'];
	        $lg_NextStep =  $cartItems[0]['lg_NextStep'];
	        $lg_FirstStep =  $cartItems[0]['lg_FirstStep'];
	        $lg_LastStep =  $cartItems[0]['lg_LastStep'];
	        $lg_ColorSizeEntry =  $cartItems[0]['lg_ColorSizeEntry'];

	        $sql = "UPDATE ework_sales_order SET StepNumber = '$lg_StepNumber',Process = '$lg_Process',Description_StepName = '$lg_Description_StepName',Machine = '$lg_Machine',StepTimeMins = '$lg_StepTimeMins',NextStep = '$lg_NextStep',FirstStep = '$lg_FirstStep',LastStep = '$lg_LastStep',ColorSizeEntry = '$lg_ColorSizeEntry' WHERE idlines = '$idlines';";

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
	}elseif($cartItems[0]['type']  == 'delete'){
	    try {
	        $idlines =  $cartItems[0]['idlines'];
	        $sql = " DELETE FROM ework_sales_order  WHERE idlines = $idlines;";
	           
	            if ($conn->query($sql) === TRUE) {
	                // If the operation was successful
	                $response['success'] = true;
	                $response['message'] = 'Delete successfully Done';
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
    }elseif($cartItems[0]['type']  == 'addline'){
	    try {
	        $docnumber =  $cartItems[0]['docnumber'];
	        $sql_header = "SELECT linenumber FROM `ework_sales_order` where docnumber = '$docnumber' order by linenumber DESC LIMIT 1";
		    $result_header = $conn->query($sql_header);
		    $row_header = $result_header->fetch_assoc();

	        $WorkOrder = $cartItems[0]['WorkOrder'];
            $docdate = $cartItems[0]['docdate']; 
            $Version = $cartItems[0]['Version'];
            $site = $cartItems[0]['site'];
            $building = $cartItems[0]['building'];
            $floor = $cartItems[0]['floor'];
            $line = $cartItems[0]['line'];
            $quantity = $cartItems[0]['quantity'];
            $SalesOrder = $cartItems[0]['SalesOrder'];
            $Customer = $cartItems[0]['Customer'];
            $Style = $cartItems[0]['Style']; 
            $StyleDescription = $cartItems[0]['StyleDescription']; 
            $SalesOrderQuantity = $cartItems[0]['SalesOrderQuantity'];
            $linenumber = $row_header['linenumber']+1;
            $StepNumber = $cartItems[0]['StepNumber']; 
            $Process = $cartItems[0]['Process'];
            $Description_StepName = $cartItems[0]['Description_StepName'];
            $Machine = $cartItems[0]['Machine']; 
            $StepTimeMins = $cartItems[0]['StepTimeMins']; 
            $NextStep = $cartItems[0]['NextStep'];
            $FirstStep = $cartItems[0]['FirstStep'];
            $docstatus = 0;
            $entrypersonbadge = $_SESSION['cardnumber'];
            $entrypersonname = 'test';
            $doccreationtime =  date('Y-m-d H:i:s');
            $docnumber = $docnumber;
            $ColorSizeEntry = $cartItems[0]['ColorSizeEntry'];
            $LastStep = $cartItems[0]['LastStep'];

	        $sql = "INSERT INTO `ework_sales_order` (`WorkOrder`, `docdate`, `quantity`, `SalesOrder`, `Customer`, `Style`, `StyleDescription`, `SalesOrderQuantity`, `linenumber`, `StepNumber`, `Process`, `Description_StepName`,
            `Machine`, `StepTimeMins`, `NextStep`, `FirstStep`,`LastStep`,`docstatus`, `entrypersonbadge`, `entrypersonname`, `doccreationtime`, `docnumber`,`line`,`ColorSizeEntry`,`site`,`building`,`floor`,`Version`)
        VALUES
                ('$WorkOrder', '$docdate', '$quantity', '$SalesOrder', '$Customer', '$Style', '$StyleDescription', '$SalesOrderQuantity',
              '$linenumber', '$StepNumber', '$Process', '$Description_StepName', '$Machine', '$StepTimeMins', '$NextStep',
             '$FirstStep','$LastStep','$docstatus','$entrypersonbadge','$entrypersonname','$doccreationtime','$docnumber','$line','$ColorSizeEntry','$site','$building','$floor','$Version')";
	           
	            if ($conn->query($sql) === TRUE) {
	                // If the operation was successful
	                $response['success'] = true;
	                $response['message'] = 'Line Successfully Inserted';
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
    }elseif($cartItems[0]['type']  == 'updateheader'){
	    try {
	        $docnumber =  $cartItems[0]['docnumber'];
	        $WorkOrder = $cartItems[0]['WorkOrder'];
            $Version = $cartItems[0]['Version'];
            $site = $cartItems[0]['site'];
            $building = $cartItems[0]['building'];
            $floor = $cartItems[0]['floor'];
            $line = $cartItems[0]['line'];
            $quantity = $cartItems[0]['quantity'];
            $SalesOrder = $cartItems[0]['SalesOrder'];
            $Customer = $cartItems[0]['Customer'];
            $Style = $cartItems[0]['Style']; 
            $StyleDescription = $cartItems[0]['StyleDescription']; 
            $SalesOrderQuantity = $cartItems[0]['SalesOrderQuantity'];
            

	        $sql = "UPDATE ework_sales_order SET WorkOrder = '$WorkOrder',Version = '$Version',site = '$site',building = '$building',floor = '$floor',line = '$line',quantity = '$quantity',SalesOrder = '$SalesOrder',Customer = '$Customer',Style = '$Style',StyleDescription = '$StyleDescription',SalesOrderQuantity = '$SalesOrderQuantity' WHERE docnumber = '$docnumber';";
	           
	            if ($conn->query($sql) === TRUE) {
	                // If the operation was successful
	                $response['success'] = true;
	                $response['message'] = 'Header Successfully Updated';
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
?>