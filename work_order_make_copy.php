<?php
   session_start();
   if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit;
   }
   include 'header.php';
   //insert data
   $sql_doc = "Select MAX(docnumber) as docnumber from ework_sales_order";
   $result_doc = $conn->query($sql_doc);

   if ($result_doc->num_rows > 0) {
     // output data of each row
     while($row_doc = $result_doc->fetch_assoc()) {
       // print_r($row);  
       $split_data =  str_split($row_doc['docnumber'],4);
       $new_doc_number = 'EWO-' . ($split_data[1] + 1);
    
     }
    
   } else {
     echo "0 results";
   }
   $doc_number = htmlspecialchars($_GET['id']);
                           
   $sql_insert_data = "SELECT * FROM `ework_sales_order` where docnumber = '$doc_number' order by linenumber DESC";
   $result_insert_data = $conn->query($sql_insert_data);
   $line_number = 0;
   while($row_insert_data = $result_insert_data->fetch_assoc()) { 
            $line_number++;
            $WorkOrder = $row_insert_data['WorkOrder'];
            $docdate = $row_insert_data['docdate']; 
            $Version = $row_insert_data['Version'];
            $site = $row_insert_data['site'];
            $building = $row_insert_data['building'];
            $floor = $row_insert_data['floor'];
            $line = $row_insert_data['line'];
            $quantity = $row_insert_data['quantity'];
            $SalesOrder = $row_insert_data['SalesOrder'];
            $Customer = $row_insert_data['Customer'];
            $Style = $row_insert_data['Style']; 
            $StyleDescription = $row_insert_data['StyleDescription']; 
            $SalesOrderQuantity = $row_insert_data['SalesOrderQuantity'];
            $linenumber = $row_insert_data['linenumber'];
            $StepNumber = $row_insert_data['StepNumber']; 
            $Process = $row_insert_data['Process'];
            $Description_StepName = $row_insert_data['Description_StepName'];
            $Machine = $row_insert_data['Machine']; 
            $StepTimeMins = $row_insert_data['StepTimeMins']; 
            $NextStep = $row_insert_data['NextStep'];
            $FirstStep = $row_insert_data['FirstStep'];
            $docstatus = 0;
            $entrypersonbadge = $_SESSION['cardnumber'];
            $entrypersonname = 'test';
            $doccreationtime =  date('Y-m-d H:i:s');
            $docnumber = $new_doc_number;
            $ColorSizeEntry = $row_insert_data['ColorSizeEntry'];
            $LastStep = $row_insert_data['LastStep'];
            
        $sql = "INSERT INTO `ework_sales_order` (`WorkOrder`, `docdate`, `quantity`, `SalesOrder`, `Customer`, `Style`, `StyleDescription`, `SalesOrderQuantity`, `linenumber`, `StepNumber`, `Process`, `Description_StepName`,
            `Machine`, `StepTimeMins`, `NextStep`, `FirstStep`,`LastStep`,`docstatus`, `entrypersonbadge`, `entrypersonname`, `doccreationtime`, `docnumber`,`line`,`ColorSizeEntry`,`site`,`building`,`floor`,`Version`)
        VALUES
                ('$WorkOrder', '$docdate', '$quantity', '$SalesOrder', '$Customer', '$Style', '$StyleDescription', '$SalesOrderQuantity',
              '$linenumber', '$StepNumber', '$Process', '$Description_StepName', '$Machine', '$StepTimeMins', '$NextStep',
             '$FirstStep','$LastStep','$docstatus','$entrypersonbadge','$entrypersonname','$doccreationtime','$docnumber','$line','$ColorSizeEntry','$site','$building','$floor','$Version')";

        
            // use query() method for MySQLi
            if ($conn->query($sql) === TRUE) {
                
            } else {
               
            }
            
      
    }
   echo "<script> window.location.href = 'work_order_edit.php?id=' + encodeURIComponent('$new_doc_number'); </script>";
   ?>