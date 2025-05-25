<?php

include 'header.php';
error_reporting(E_ERROR | E_PARSE);
error_reporting(0);
// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

    


	$Date 	   = $_GET['Date'];
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
    //             SUBSTRING(o.DateTime, 12, 2) AS Time
    //         FROM
    //             eworker_operation o
    //                 LEFT JOIN
    //             ework_workers e ON o.cardnumber = e.cardnumber
    //         WHERE
    //                 o.WorkOrder = '$WorkOrder'
    //                 AND o.Style = '$Style'
    //                 AND o.SewingLine = '$Line'
    //                 AND o.DateTime LIKE '%$Date%'
    //                 AND o.qty_type = 'pass'
    //                 AND e.Position = '2'
    //         GROUP BY SUBSTRING(o.DateTime, 12, 2)";

    // $queryResult = $conn->query($sql);
    // $actualWorkingHour = mysqli_num_rows($queryResult);

    $actualWorkingHour = $_GET['ActualWorkingHour'];

    // echo $actualWorkingHour;
    // exit();

    if($actualWorkingHour == 0) $actualWorkingHour = '1';
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
                <td><b>Quality Inspector: </b><?php echo $Quality; ?></td>
                <td><b>Total Man Power: </b><?php echo $TotalManPower; ?></td>
                <td><b>Today's Efficiency: </b><?php if($TodayEfficiency == '0'){}else{ echo number_format($TodayEfficiency,2).' %'; }?></td>
            </tr>
            <tr>
                <td><b>Allocated Qty: </b><?php echo number_format($_GET['quantity']); ?></td>
                <td><b>Input Qty: </b><?php echo number_format($InputQty); ?></td>
                <td><b>Line WIP: </b><?php echo $InputQty - $PassedQty; ?></td>
                <td style="color: green;"><b>Total QC Passed Qty: </b><?php echo number_format($PassedQty); ?></td>
                <td style="color: red;"><b>Total QC Failed Qty: </b><?php echo number_format($FailedQty); ?></td>
            </tr>
            <tr>
                <td><b>Working Hour: </b><?php echo $_GET['WorkingHour']; ?></td>
                <td><b>Daily Target: </b><?php echo $DailyTarget; ?></td>
                <td style="color: darkblue;"><b>Today's Inspection Qty: </b><?php echo $ToadyPassedQty + $ToadyFailQty; ?></td>
                <td style="color: green;"><b>Today's QC Passed Qty: </b><?php echo number_format($ToadyPassedQty); ?></td>
                <td style="color: red;"><b>Today's QC Failed Qty: </b><?php echo number_format($ToadyFailQty); ?></td>
            </tr>

        </table>
    </fieldset>


<?php

    $sql = "SELECT 
                SUBSTRING(o.DateTime, 1, 10) AS DATE,
                SUBSTRING(o.DateTime, 12, 2) AS TIME,
                SUM(Qty) AS FinishedGoodsQty
            FROM
                eworker_operation o
                    LEFT JOIN
                ework_workers w ON o.cardnumber = w.cardnumber
                    LEFT JOIN
                eworker_assignment a ON o.cardnumber = a.cardnumber
                    AND o.WorkOrder = a.WorkOrder
                    AND o.Style = a.Style
                    AND o.SewingLine = a.line
            WHERE
                o.DateTime LIKE '%$Date%'
                    AND o.qty_type = 'pass'
                    AND w.Position = '2'
                    AND o.WorkOrder = '$WorkOrder'
                    AND o.Style = '$Style'
                    AND o.SewingLine = '$Line'
            GROUP BY DATE, TIME";

            

    $data = "";

    $queryResult = $conn->query($sql);

    while ($row = $queryResult->fetch_assoc()) {


      
      
      $Time   = $row['TIME'];
      if($Time == '00') $Time = '24';
      

      $FinishedGoodsQty = $row['FinishedGoodsQty'];
      if($FinishedGoodsQty == '') $FinishedGoodsQty = '0';


      $data .=  "{ label: $Time, y: $FinishedGoodsQty},";

    }



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

    if ($row['SMV'] != null) {
        $SMV = $row['SMV'];
        // Process $SMV or do something with it
    } else {
        // Handle the case where SMV is not set
        $SMV = '1';
    }



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

    $sql = "SELECT 
                SUBSTRING(o.DateTime, 1, 10) AS DATE,
                SUBSTRING(o.DateTime, 12, 2) AS TIME,
                SUM(Qty) AS FinishedGoodsQty
            FROM
                eworker_operation o
                    LEFT JOIN
                ework_workers w ON o.cardnumber = w.cardnumber
                    LEFT JOIN
                eworker_assignment a ON o.cardnumber = a.cardnumber
                    AND o.WorkOrder = a.WorkOrder
                    AND o.Style = a.Style
                    AND o.SewingLine = a.line
            WHERE
                o.DateTime LIKE '%$Date%'
                    AND o.qty_type = 'pass'
                    AND w.Position = '2'
                    AND o.WorkOrder = '$WorkOrder'
                    AND o.Style = '$Style'
                    AND o.SewingLine = '$Line'
            GROUP BY DATE, TIME";

    $data2 = "";

    $queryResult = $conn->query($sql);

    while ($row = $queryResult->fetch_assoc()) {
      
      
      $Time   = $row['TIME'];
      if($Time == '00') $Time = '24';
      
      
      $Efficiency = $row['FinishedGoodsQty'] * $SMV / (($Operator + $Helper) * 60) * 100;

      $Efficiency = number_format($Efficiency,2);

      $data2 .=  "{ label: $Time, y: $Efficiency},";

    }


    $sql = "SELECT 
                SUBSTRING(o.DateTime, 1, 10) AS DATE,
                SUBSTRING(o.DateTime, 12, 2) AS TIME,
                SUM(Qty) AS HourlyProductionQty
            FROM
                eworker_operation o
                    LEFT JOIN
                ework_workers w ON o.cardnumber = w.cardnumber
                    LEFT JOIN
                eworker_assignment a ON o.cardnumber = a.cardnumber
                    AND o.WorkOrder = a.WorkOrder
                    AND o.Style = a.Style
                    AND o.SewingLine = a.line
            WHERE
                o.DateTime LIKE '%$Date%'
                    AND o.qty_type IN ('pass', 'fail')
                    AND w.Position = '2'
                    AND o.WorkOrder = '$WorkOrder'
                    AND o.Style = '$Style'
                    AND o.SewingLine = '$Line'
            GROUP BY DATE, TIME";
            // echo $sql;
    $data3 = "";

    $queryResult = $conn->query($sql);

    while ($row = $queryResult->fetch_assoc()) {
      
      
      $Time   = $row['TIME'];
      if($Time == '00') $Time = '24';
      

      $HourlyProductionQty = $row['HourlyProductionQty'];
      if($HourlyProductionQty == '') $HourlyProductionQty = '0';


      $data3 .=  "{ label: $Time, y: $HourlyProductionQty},";

    }


?>



<style>
    a.canvasjs-chart-credit {
        display: none !important;
    }
</style>

<script type="text/javascript">

window.onload = function () {
    var chart = new CanvasJS.Chart("chartConntainer",
    {   
        animationEnabled: true,
        exportEnabled: true,
        theme: "light2",
        title: {
            text: "Time vs Total Inspection Qty, QC Passed Qty & Efficiency (%)"
        },
        dataPointMaxWidth: 100,
     
	axisY:{
            includeZero: true
        },
                data: [
    {
        type: "column",
        name: "Inspection Qty",
        indexLabel: "{y}",
        indexLabelOrientation: "vertical", // Add this line
        indexLabelFontColor: "Black", // Add this line
        // indexLabelPlacement: "inside",
        showInLegend: true,
        dataPoints: [
            <?php echo $data3; ?>
        ]
    },{
        type: "column",
        name: "QC Passed Qty",
        indexLabel: "{y}",
        indexLabelOrientation: "vertical", // Add this line
        indexLabelFontColor: "Black", // Add this line
        // indexLabelPlacement: "inside",
        showInLegend: true,
        dataPoints: [
            <?php echo $data; ?>
        ]
    },{
        type: "column",
        name: "Efficiency (%)",
        indexLabel: "{y}%",
        indexLabelOrientation: "vertical", // Add this line
        indexLabelFontColor: "Black", // Add this line
        // indexLabelPlacement: "inside",
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


<div id="chartConntainer" style="height: 700px; width: 100%;"></div>    
<?php include 'footer.php'; ?>