<?php

include 'header.php';
error_reporting(E_ERROR | E_PARSE);
error_reporting(0);
// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$Date      = $_GET['Date'];
    $WorkOrder = $_GET['WorkOrder'];
    $Style     = $_GET['Style'];
    $Line      = $_GET['Line'];

    $sql = "SELECT 
                SUM(A.StepTimeMins) AS SMV
            FROM
                `ework_sales_order` AS A
            WHERE
                A.WorkOrder = '$WorkOrder'
                    AND A.Style = '$Style'
            GROUP BY A.WorkOrder";

    $queryResult = $conn->query($sql);
    $row = $queryResult->fetch_assoc();
    $SMV =  $row['SMV'];

    $sql = "SELECT 
                SUM(o.Qty) AS InputQty
            FROM
                eworker_operation o
                    LEFT JOIN
                eworker_assignment w ON o.WorkOrder = w.WorkOrder
                    AND o.Style = w.Style
                    AND o.SewingLine = w.line
                    AND o.cardnumber = w.cardnumber
                    LEFT JOIN
                ework_workers e ON o.cardnumber = e.cardnumber
            WHERE
                    o.WorkOrder = '$WorkOrder'
                    AND o.Style = '$Style'
                    AND o.SewingLine = '$Line'
                    AND w.FirstStep = '1'
                    AND o.qty_type = 'pass'
                    AND e.Position IN ('0', '1')";

    $queryResult = $conn->query($sql);
    $row = $queryResult->fetch_assoc();
    $InputQty =  $row['InputQty'];

    // echo $sql;

    $sql = "SELECT 
                SUM(o.Qty) AS PassedQty
            FROM
                eworker_operation o
                    LEFT JOIN
                ework_workers e ON o.cardnumber = e.cardnumber
            WHERE
                    o.WorkOrder = '$WorkOrder'
                    AND o.Style = '$Style'
                    AND o.SewingLine = '$Line'
                    AND o.qty_type = 'pass'
                    AND e.Position = '2'";

    $queryResult = $conn->query($sql);
    $row = $queryResult->fetch_assoc();
    $PassedQty =  $row['PassedQty'];

    $sql = "SELECT 
                SUM(o.Qty) AS FailedQty
            FROM
                eworker_operation o
                    LEFT JOIN
                ework_workers e ON o.cardnumber = e.cardnumber
            WHERE
                    o.WorkOrder = '$WorkOrder'
                    AND o.Style = '$Style'
                    AND o.SewingLine = '$Line'
                    AND o.qty_type = 'fail'
                    AND e.Position = '2'";

    // echo $sql;

    $queryResult = $conn->query($sql);
    $row = $queryResult->fetch_assoc();
    $FailedQty =  $row['FailedQty'];


    $sql = "SELECT 
                *
            FROM
                `eworker_assignment` a
                    LEFT JOIN
                `ework_workers` w ON a.cardnumber = w.cardnumber
            WHERE
                     a.WorkOrder = '$WorkOrder'
                    AND w.Position = '0'
                    AND a.Style = '$Style'
                    AND a.line = '$Line'
                    AND a.WorkerActive = '1'
            GROUP BY w.cardnumber";

    $queryResult = $conn->query($sql);
    $Operator = mysqli_num_rows($queryResult);

    $sql = "SELECT 
            *
            FROM
            `eworker_assignment` a
                LEFT JOIN
            `ework_workers` w ON a.cardnumber = w.cardnumber
            WHERE
                 a.WorkOrder = '$WorkOrder'
                AND w.Position = '1'
                AND a.Style = '$Style'
                AND a.line = '$Line'
                AND a.WorkerActive = '1'
            GROUP BY w.cardnumber";

    $queryResult = $conn->query($sql);
    $Helper = mysqli_num_rows($queryResult);

    $Quality = '1';

    $TotalManPower = $Operator + $Helper + $Quality;

    $DailyTarget = ($_GET['TargetEfficiency'] * $_GET['WorkingHour'] * ($Operator + $Helper) * 60) / ($SMV * 100);

    $DailyTarget = number_format($DailyTarget);


    $sql = "SELECT 
                SUBSTRING(o.DateTime, 1, 10) AS DATE, SUM(o.Qty) AS ToadyPassedQty
            FROM
                eworker_operation o
                    LEFT JOIN
                ework_workers e ON o.cardnumber = e.cardnumber
            WHERE
                    o.WorkOrder = '$WorkOrder'
                    AND o.Style = '$Style'
                    AND o.SewingLine = '$Line'
                    AND o.DateTime LIKE '%$Date%'
                    AND o.qty_type = 'pass'
                    AND e.Position = '2'";

    $queryResult = $conn->query($sql);
    $row = $queryResult->fetch_assoc();
    $ToadyPassedQty =  $row['ToadyPassedQty'];

    $sql = "SELECT 
                SUBSTRING(o.DateTime, 1, 10) AS DATE, SUM(o.Qty) AS ToadyFailQty
            FROM
                eworker_operation o
                    LEFT JOIN
                ework_workers e ON o.cardnumber = e.cardnumber
            WHERE
                    o.WorkOrder = '$WorkOrder'
                    AND o.Style = '$Style'
                    AND o.SewingLine = '$Line'
                    AND o.DateTime LIKE '%$Date%'
                    AND o.qty_type = 'fail'
                    AND e.Position = '2'";

    $queryResult = $conn->query($sql);
    $row = $queryResult->fetch_assoc();
    $ToadyFailQty =  $row['ToadyFailQty'];

    // $sql = "SELECT
    //   SUBSTRING(RegDate, 1, 10) AS DATE, SUBSTRING(RegDate, 12, 2) AS TIME, SUM(QTY) AS FinishedGoodsQty
    // FROM
    //   pyfngood
    //   WHERE RegDate LIKE '$Date%'
    //   GROUP BY DATE, TIME";

    $sql = "SELECT 
                SUBSTRING(o.DateTime, 12, 2) AS Time
            FROM
                eworker_operation o
                    LEFT JOIN
                ework_workers e ON o.cardnumber = e.cardnumber
            WHERE
                    o.WorkOrder = '$WorkOrder'
                    AND o.Style = '$Style'
                    AND o.SewingLine = '$Line'
                    AND o.DateTime LIKE '%$Date%'
                    AND o.qty_type = 'pass'
                    AND e.Position = '2'
            GROUP BY SUBSTRING(o.DateTime, 12, 2)";

    $queryResult = $conn->query($sql);
    $actualWorkingHour = mysqli_num_rows($queryResult);

    // echo $sql;

    $TodayEfficiency = ($ToadyPassedQty * $SMV) / (($Operator + $Helper) * 60 * $actualWorkingHour) * 100;

    ?>

    <fieldset>
        <table style="font-size: 12pt;">
            <tr>
                <td><b>Site: </b><?php echo $_GET['Site']; ?></td>
                <td><b>Building: </b><?php echo $_GET['Building']; ?></td>
                <td><b>FLoor: </b><?php echo $_GET['Floor']; ?></td>
                <td><b>Line No.: </b><?php echo $_GET['Line']; ?></td>
                <td><b>Customer: </b><?php echo $_GET['Customer']; ?></td>
            </tr>
            <tr>
                <td><b>Style: </b><?php echo $_GET['Style']; ?></td>
                <td><b>Item Description: </b><?php echo $_GET['StyleDescription']; ?></td>
                <td><b>Work Order: </b><?php echo $_GET['WorkOrder']; ?></td>
                <td><b>SMV: </b><?php echo $SMV; ?></td>
                <td><b>Target Efficiency: </b><?php echo $_GET['TargetEfficiency'].' %'; ?></td>
            </tr>
            <tr>
                <td><b>Operator: </b><?php echo $Operator; ?></td>
                <td><b>Helper: </b><?php echo $Helper; ?></td>
                <td><b>Working Hour: </b><?php echo $_GET['WorkingHour']; ?></td>
                <td><b>Daily Target: </b><?php echo $DailyTarget; ?></td>

            </tr>

        </table>
    </fieldset>



<?php

$sql = "SELECT 
                `w`.`name` AS `Name`, `a`.`StepTimeMins` AS `SMV`, `e`.`WorkingHour` AS `WorkingHour`, `o`.`StepNumber` AS `StepNumber`, `a`.`Description_StepName` AS `StepName`
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
                `o`.`WorkOrder` = '$WorkOrder' AND `w`.`position` IN ('0', '1') AND `o`.`DateTime` LIKE '%$Date%'
            GROUP BY `o`.`WorkOrder`, `o`.`SewingLine`, `o`.`StepNumber`";

    // echo $sql;



    $data = "";
    $data2 = "";

    $queryResult = $conn->query($sql);

    $sl = 1;

    while ($row = $queryResult->fetch_assoc()) {
      
    
      $SMV         = $row['SMV'];
      $Name        = $row['Name'];
      $StepNumber  = $row['StepNumber'];
      $WorkingHour = $row['WorkingHour'];
      $StepName    = $row['StepName'];


      $StepNumber_Name = $StepNumber . '-' . $StepName;


      $sql2       = "SELECT SUM(`Qty`) AS Total_Qty FROM `eworker_operation` WHERE `StepNumber` = '$StepNumber' AND SUBSTRING(`DateTime`, 1, 10) = '$Date' GROUP BY '$StepNumber'";


      $result2    = $conn->query($sql2);
      $row2       = $result2->fetch_assoc();
      $Total_Qty  = $row2['Total_Qty'];

      $Efficiency =  number_format((($SMV * $Total_Qty) / ($WorkingHour * 60)) * 100, 2);

      $data .=  "{ label: '$StepNumber_Name', y: $Total_Qty}, ";
      $data2 .=  "{ label: '$StepNumber_Name', y: $Efficiency}, ";





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
    // modal.style.display = "block";
    var chart = new CanvasJS.Chart("chartContainer",
    {   
        animationEnabled: true,
        exportEnabled: true,
        theme: "light2",
        title: {
            text: "Step No. vs Output Quantity & Efficiency"
        },
        dataPointMaxWidth: 50,
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
            name: "Output Qty",
            // color: "powderblue",
            indexLabel: "{y} ",
            indexLabelOrientation: "vertical", // Add this line
            indexLabelFontColor: "Black", // Add this line
            showInLegend: true,
            dataPoints: [
                <?php echo $data; ?>
            ]
        }
        ,{
            type: "column",
            name: "Efficiency (%)",
            indexLabel: "{y} %",
            indexLabelOrientation: "vertical", // Add this line
            indexLabelFontColor: "Black", // Add this line
            showInLegend: true,
            dataPoints: [
                <?php echo $data2; ?>
            ]
        }
        ]
    });
    chart.render();
}



</script>
<script type="text/javascript" src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

<div id="chartContainer" style="height: 500px; width: 100%;"></div>    
<?php include 'footer.php'; ?>
