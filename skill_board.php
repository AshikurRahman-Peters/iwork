<?php
   session_start();
   if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit;
   }

include 'header.php'; 

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<fieldset>
        <table style="font-size: 15pt;">
            <tr>
                <td><b>Work Order: </b><?php echo $_GET['WorkOrder']; ?></td>
                <td><b>Customer: </b><?php echo $_GET['Customer']; ?></td>
                <td><b>Style: </b><?php echo $_GET['Style']; ?></td>
            </tr>
            <tr>
                <td><b>Site: </b><?php echo $_GET['Site']; ?></td>
                <td><b>Building: </b><?php echo $_GET['Building']; ?></td>
                <td><b>Floor: </b><?php echo $_GET['Floor']; ?></td>
                <td><b>Sewing Line: </b><?php echo $_GET['Line']; ?></td>
            </tr>
            

        </table>
    </fieldset>



<?php

$WorkOrder = $_GET['WorkOrder'];

    $sql = "SELECT 
                `w`.`name` AS `Name`, `a`.`StepTimeMins` AS `SMV`, `e`.`WorkingHour` AS `WorkingHour`, `o`.`StepNumber` AS `StepNumber`
            FROM
                `eworker_operation` `o`
                    LEFT JOIN
                `eworker_assignment` `a` ON `o`.`WorkOrder` = `a`.`WorkOrder`
                    AND `o`.`Style` = `a`.`Style`
                    AND `o`.`SewingLine` = `a`.`line`
                    AND `o`.`cardnumber` = `a`.`cardnumber`
                    LEFT JOIN
                `ework_workers` `w` ON `o`.`cardnumber` = `w`.`cardnumber`
                    LEFT JOIN
                `ework_target_efficiency` `e` ON `o`.`SewingLine` = `e`.`SewingLine`
                    AND `o`.`WorkOrder` = `e`.`WorkOrder`
                    AND `o`.`Style` = `e`.`Style`
            WHERE
                `o`.`WorkOrder` = '$WorkOrder' AND `w`.`position` IN ('0', '1')
            GROUP BY `o`.`WorkOrder`, `o`.`SewingLine`, `o`.`StepNumber`, `o`.`cardnumber`";

    // echo $sql;



    $data = "";

    $queryResult = $conn->query($sql);

    while ($row = $queryResult->fetch_assoc()) {
      
      $SMV         = $row['SMV'];
      $Name        = $row['Name'];
      $StepNumber  = $row['StepNumber'];
      $WorkingHour = $row['WorkingHour'];

      $sql2       = "SELECT SUM(`Qty`) AS Total_Qty FROM `eworker_operation` WHERE `StepNumber` = '$StepNumber'";
      $result2    = $conn->query($sql2);
      $row2       = $result2->fetch_assoc();
      $Total_Qty  = $row2['Total_Qty'];

      $Efficiency =  number_format((($SMV * $Total_Qty) / ($WorkingHour * 60)) * 100, 2);

      $data .=  "{ label: '$Name', y: $Efficiency}, ";

    }

    // $data .= rtrim($data, ',');

    // echo $data;



?>


<!DOCTYPE HTML>
<html>
<head>

<style>
    a.canvasjs-chart-credit {
        display: none !important;
    }



</style>


<script type="text/javascript">



window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer",
    {   
        animationEnabled: true,
        exportEnabled: true,
        theme: "light2",
        title: {
            text: "Operator-Helper vs Efficiency (%)"
        },
        dataPointMaxWidth: 40,
        axisY:{
            includeZero: true
        },
        axisX: {
            labelAngle: -45, // Rotate labels
            interval: 1 // Adjust the interval between ticks
        },
        data: [
        {
            type: "column",
            name: "Efficiency (%)",
            // color: "powderblue",
            indexLabel: "{y} %",
            indexLabelOrientation: "vertical", // Add this line
            indexLabelFontColor: "Black", // Add this line
            showInLegend: true,
            dataPoints: [
                <?php echo $data; ?>
            ]
        }
        ]
    });
    chart.render();
}



</script>
<script type="text/javascript" src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

</head>
<body>
<div id="chartContainer" style="height: 500px; width: 100%;"></div>    
</body>
</html>




