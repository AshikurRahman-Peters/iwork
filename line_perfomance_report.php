<?php
   session_start();
   if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit;
   }
   ?>
<?php 
   include 'header.php'; 
   $sql = "SELECT
       SUBSTRING(`wp`.`DateTime`, 1, 10) AS `DateTime`,
       `wa`.`site`,
       `wa`.`building`,
       `wa`.`floor`,
       `wp`.`SewingLine`,
       `wp`.`WorkOrder`,
       `wa`.`Customer`,
       `wa`.`Style`,
       `wa`.`StyleDescription`,
       `te`.`WorkingHour`,
       `te`.`TargetEfficiency`,
       `te`.`ActualWorkingHour`,
       `wa`.`quantity`
       FROM
         `eworker_operation` `wp`
         LEFT JOIN `ework_target_efficiency` `te` ON `wp`.`SewingLine` = `te`.`SewingLine` AND `wp`.`WorkOrder` = `te`.`WorkOrder` AND `wp`.`Style` = `te`.`Style` AND SUBSTRING(`wp`.`DateTime`, 1, 10) = SUBSTRING(`te`.`Date`, 1, 10)
         LEFT JOIN `eworker_assignment` `wa` ON `wp`.`WorkOrder` = `wa`.`WorkOrder` AND `wp`.`SewingLine` = `wa`.`line`
       GROUP BY SUBSTRING(`wp`.`DateTime`, 1, 10), `wp`.`SewingLine`
       ORDER BY `wp`.`DateTime` DESC
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
                                       <th>Date Time</th>
                                       <th>Site</th>
                                       <th>Building</th>
                                       <th>Floor</th>
                                       <th>Sewing Line</th>
                                       <th>Work Order</th>
                                       <th>Customer</th>
                                       <th>Style</th>
                                       <th>Style Description</th>
                                       <th>Working Hour</th>
                                       <th>Target Efficiency</th>
                                       <th>Actual Working Hour</th>
                                       <th>Quantity</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                       while ($row = $result->fetch_assoc()) {
                                          
                                       ?>
                                    <tr data-id="1" class="valid new">
                                       <?php
                                          echo '<td><a target="_blank" href="line_board.php?Date=' . urlencode($row['DateTime']) . '&Site=' . urlencode($row['site']) . '&Building=' . urlencode($row['building']) . '&Floor=' . urlencode($row['floor']) . '&Line=' . urlencode($row['SewingLine']) . '&WorkOrder=' . urlencode($row['WorkOrder']) . '&Customer=' . urlencode($row['Customer']) . '&Style=' . urlencode($row['Style']) . '&StyleDescription=' . urlencode($row['StyleDescription']) . '&WorkingHour=' . urlencode($row['WorkingHour']) . '&TargetEfficiency=' . urlencode($row['TargetEfficiency']) . '&ActualWorkingHour=' . urlencode($row['ActualWorkingHour']) . '&quantity=' . urlencode($row['quantity']) . '">' . htmlspecialchars($row['DateTime']) . '</a></td>';
                                          
                                          echo '<td>' . htmlspecialchars($row['site']) . '</td>';
                                          echo '<td>' . htmlspecialchars($row['building']) . '</td>';
                                          echo '<td>' . htmlspecialchars($row['floor']) . '</td>';
                                          echo '<td>' . htmlspecialchars($row['SewingLine']) . '</td>';
                                          echo '<td>' . htmlspecialchars($row['WorkOrder']) . '</td>';
                                          echo '<td>' . htmlspecialchars($row['Customer']) . '</td>';
                                          echo '<td>' . htmlspecialchars($row['Style']) . '</td>';
                                          echo '<td>' . htmlspecialchars($row['StyleDescription']) . '</td>';
                                          echo '<td>' . htmlspecialchars($row['WorkingHour']) . '</td>';
                                          echo '<td>' . htmlspecialchars($row['TargetEfficiency']) . '</td>';
                                          echo '<td>' . htmlspecialchars($row['ActualWorkingHour']) . '</td>';
                                          echo '<td>' . htmlspecialchars($row['quantity']) . '</td>';
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
          "responsive": true, "lengthChange": false, "autoWidth": false,
          "buttons": ["csv", "excel"]
          // "buttons": ["copy", "csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#myDataTable_wrapper .col-md-6:eq(0)');
        
      });
   </script>
</body>
</html>