<?php
   session_start();
   if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit;
   }
   ?>
<?php 
   include 'header.php'; 
   // Check the connection
   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   }
   
   // Modify SQL query
   $sql = "
   SELECT
    `w`.`name`,
    `o`.`cardnumber`,
    `o`.`StepNumber`,
    `a`.`Description_StepName`,
    (SELECT
        SUM(`Qty`) AS Total_Qty
    FROM
        `eworker_operation`
    WHERE
        `StepNumber` = `o`.`StepNumber`) AS `Total_Qty`,
    (SELECT SUM(SUBSTRING(`end_datetime`, 15, 2) - SUBSTRING(`DateTime`, 15, 2)) AS Total_Time FROM `eworker_operation` WHERE `StepNumber` = `o`.`StepNumber`) AS `Total_Time`,
    '' AS `Average`,
    `a`.`StepTimeMins`,
    '' AS `Deviation`,
    '' AS `Efficiency`,
    `o`.`SewingLine`,
    `o`.`WorkOrder`,
    `o`.`Style`,
    `a`.`Customer`,
    `w`.`position`,
    `a`.`site`,
    `a`.`building`,
    `a`.`floor`,
    `e`.`WorkingHour`
   FROM
    `eworker_operation` `o`
   LEFT JOIN `eworker_assignment` `a`
   ON
    `o`.`WorkOrder` = `a`.`WorkOrder` AND `o`.`Style` = `a`.`Style` AND `o`.`SewingLine` = `a`.`line` AND `o`.`cardnumber` = `a`.`cardnumber`
   LEFT JOIN `ework_workers` `w`
   ON
    `o`.`cardnumber` = `w`.`cardnumber`
   LEFT JOIN `ework_target_efficiency` `e` ON
    `o`.`SewingLine` = `e`.`SewingLine` AND `o`.`WorkOrder` = `e`.`WorkOrder` AND `o`.`Style` = `e`.`Style`
   GROUP BY `o`.`WorkOrder`, `o`.`SewingLine`, `o`.`StepNumber`, `o`.`cardnumber`
   ";
   
   
   
   // Execute the query
   $result = $conn->query($sql);
   ?>
<body class="hold-transition sidebar-mini">
   <div class="wrapper">
      <!-- Navbar -->
      <?php include('navbar.php'); ?>
      <!-- /.navbar -->
      <!-- Main Sidebar Container -->
      <?php include('sidebar.php'); ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
         <!-- /.content-header -->
         <!-- Main content -->
         <div class="content">
            <div class="container-fluid">
               <div id="formLinesContainer" class=" mt-3">
                  <div id="formLinesFieldset">
                     <div class="clearfix"></div>
                     <div id="leftFormLines">
                        <div id="formLines">
                           <div id="fieldset_lineinformation">
                              <table class="table table-bordered" id="myDataTable">
                                 <thead>
                                    <tr>
                                       <th>Name</th>
                                       <th>Card No.</th>
                                       <th>Step No.</th>
                                       <th>Step Name</th>
                                       <th>Total Qty</th>
                                       <th>Total Time</th>
                                       <th>Average</th>
                                       <th>SMV</th>
                                       <th>Deviation</th>
                                       <th>Efficiency</th>
                                       <th>Sewing Line</th>
                                       <th>Work Order</th>
                                       <th>Style</th>
                                       <th>Customer</th>
                                       <th>Position</th>
                                       <th>Site</th>
                                       <th>Building</th>
                                       <th>Floor</th>
                                       <th>Working Hour</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                       while ($row = $result->fetch_assoc()) {
                                            if($row['Total_Time'] < 0) $row['Total_Time'] = $row['Total_Time'] * (-1);
                                            $row['Average'] = number_format($row['Total_Time']/$row['Total_Qty'],2);
                                            $row['Deviation'] = ($row['StepTimeMins'] - $row['Average']);
                                            if($row['Deviation'] < 0) $row['Deviation'] = $row['Deviation'] * (-1);
                                            $row['Efficiency'] = number_format((($row['StepTimeMins'] * $row['Total_Qty']) / ($row['WorkingHour'] * 60)) * 100, 2);  
                                       ?>
                                    <tr data-id="1" class="valid new">
                                       <?php
                                          echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                                          echo '<td>' . htmlspecialchars($row['cardnumber']) . '</td>';
                                          echo '<td>' . htmlspecialchars($row['StepNumber']) . '</td>';
                                          echo '<td>' . htmlspecialchars($row['Description_StepName']) . '</td>';
                                          echo '<td>' . htmlspecialchars($row['Total_Qty']) . '</td>';
                                          echo '<td>' . htmlspecialchars($row['Total_Time']) . '</td>';
                                          echo '<td>' . htmlspecialchars($row['Average']) . '</td>';
                                          echo '<td>' . htmlspecialchars($row['StepTimeMins']) . '</td>';
                                          
                                          if ($row['Average'] > $row['StepTimeMins']) {
                                          echo '<td style="color:red">' . htmlspecialchars($row['Deviation']) . '</td>';
                                          
                                          } else {
                                          echo '<td>' . htmlspecialchars($row['Deviation']) . '</td>';
                                          }
                                          
                                          echo '<td>' . htmlspecialchars($row['Efficiency']) . '</td>';
                                          echo '<td>' . htmlspecialchars($row['SewingLine']) . '</td>';
                                          echo '<td><a target="_blank" href="skill_board.php?Site=' . urlencode($row['site']) . '&Building=' . urlencode($row['building']) . '&Floor=' . urlencode($row['floor']) . '&Line=' . urlencode($row['SewingLine']) . '&WorkOrder=' . urlencode($row['WorkOrder']) . '&Customer=' . urlencode($row['Customer']) . '&Style=' . urlencode($row['Style']) . '">' . htmlspecialchars($row['WorkOrder']) . '</a></td>';
                                          echo '<td>' . htmlspecialchars($row['Style']) . '</td>';
                                          echo '<td>' . htmlspecialchars($row['Customer']) . '</td>';
                                          echo '<td>' . htmlspecialchars($row['position']) . '</td>';
                                          echo '<td>' . htmlspecialchars($row['site']) . '</td>';
                                          echo '<td>' . htmlspecialchars($row['building']) . '</td>';
                                          echo '<td>' . htmlspecialchars($row['floor']) . '</td>';
                                          echo '<td>' . htmlspecialchars($row['WorkingHour']) . '</td>';
                                          ?>
                                       <!-- ... (Remaining code) ... -->
                                    </tr>
                                    <?php
                                       }
                                       ?>
                                    <!-- Add more rows as needed -->
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
         </div>
         <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      <!-- Main Footer -->
      <?php include('footer.php'); ?>
   </div>
   <!-- ./wrapper -->
   <!-- REQUIRED SCRIPTS -->
   <!-- jQuery -->
   <script src="plugins/jquery/jquery.min.js"></script>
   <!-- Bootstrap 4 -->
   <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
   <!-- AdminLTE App -->
   <script src="dist/js/adminlte.min.js"></script>
   <!-- DataTables JS -->
   <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
   <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
   <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
   <script src="plugins/jszip/jszip.min.js"></script>
   <script src="plugins/pdfmake/pdfmake.min.js"></script>
   <script src="plugins/pdfmake/vfs_fonts.js"></script>
   <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
   <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
   <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
   <script>
      $(function () {
            $("#myDataTable").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "scrollY": "400px", // Set the desired height
            "scrollX": true,   // Enable horizontal scrolling if needed
            "buttons": ["csv", "excel"]
        }).buttons().container().appendTo('#myDataTable_wrapper .col-md-6:eq(0)');
      });
   </script>
</body>
</html>