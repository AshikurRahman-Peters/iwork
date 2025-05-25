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
   
   // Extract search term from the form submission
   $searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
   
   // Pagination parameters
   $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
   $itemsPerPage = 10; // Adjust this value based on your preference
   
   // Calculate the offset
   $offset = ($page - 1) * $itemsPerPage;
   
   
   // Modify SQL query
   $sql = "
    SELECT 
    o.cardnumber, 
    (SELECT Name From ework_workers where cardnumber = o.cardnumber LIMIT 1) as Name,
    (SELECT Position From ework_workers where cardnumber = o.cardnumber LIMIT 1) as Position,
    o.WorkOrder, 
    o.Style, 
    o.SewingLine,
    (SELECT Customer FROM ework_sales_order WHERE docnumber = o.docnumber LIMIT 1) as Customer,
    o.StepNumber,
    o.Qty,
    o.qty_type,
    o.color,
    o.size,
    o.DateTime,
    o.PartCode,
    o.ReworkReason,
    o.updated_time,
    o.deleted_time
   FROM
    eworker_operation o
    WHERE
        `o`.`cardnumber` LIKE '%$searchTerm%'
        OR `o`.`WorkOrder` LIKE '%$searchTerm%'
        OR `o`.`Style` LIKE '%$searchTerm%'
        OR `o`.`SewingLine` LIKE '%$searchTerm%'
        OR `o`.`ReworkReason` LIKE '%$searchTerm%'
   ";
   
   
   
   // Modify SQL query to include pagination
   $sql .= " LIMIT $offset, $itemsPerPage";
   
   
   // Execute the query
   $result = $conn->query($sql);
   
   // Check for errors
   if (!$result) {
    die("Query failed: " . $conn->error);
   }
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
                                       <th>Card No.</th>
                                       <th>Name</th>
                                       <th>Position</th>
                                       <th>Work Order</th>
                                       <th>Style</th>
                                       <th>Sewing Line</th>
                                       <th>Customer</th>
                                       <th>Step Number</th>
                                       <th>Quantity</th>
                                       <th>Quantity Type</th>
                                       <th>Color</th>
                                       <th>Size</th>
                                       <th>Entry Time</th>
                                       <th>Part Code</th>
                                       <th>Rework Reason</th>
                                       <th>Update Time</th>
                                       <th>Delete Time</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                       while ($row = $result->fetch_assoc()) {
                                       
                                       if($row['Position'] == '0') $row['Position'] = 'Operator';
                                       if($row['Position'] == '1') $row['Position'] = 'Helper';
                                       if($row['Position'] == '2') $row['Position'] = 'Quality';
                                       
                                       echo '<tr>';
                                       echo '<td>' . htmlspecialchars($row['cardnumber']) . '</td>';
                                       echo '<td>' . htmlspecialchars($row['Name']) . '</td>';
                                       echo '<td>' . htmlspecialchars($row['Position']) . '</td>';
                                       echo '<td>' . htmlspecialchars($row['WorkOrder']) . '</td>';
                                       echo '<td>' . htmlspecialchars($row['Style']) . '</td>';
                                       echo '<td>' . htmlspecialchars($row['SewingLine']) . '</td>';
                                       echo '<td>' . htmlspecialchars($row['Customer']) . '</td>';
                                       echo '<td>' . htmlspecialchars($row['StepNumber']) . '</td>';
                                       echo '<td>' . htmlspecialchars($row['Qty']) . '</td>';
                                       echo '<td>' . htmlspecialchars($row['qty_type']) . '</td>';
                                       echo '<td>' . htmlspecialchars($row['color']) . '</td>';
                                       echo '<td>' . htmlspecialchars($row['size']) . '</td>';
                                       echo '<td>' . htmlspecialchars($row['DateTime']) . '</td>';
                                       echo '<td>' . htmlspecialchars($row['PartCode']) . '</td>';
                                       echo '<td>' . htmlspecialchars($row['ReworkReason']) . '</td>';
                                       echo '<td>' . htmlspecialchars($row['updated_time']) . '</td>';
                                       echo '<td>' . htmlspecialchars($row['deleted_time']) . '</td>';
                                       echo '</tr>';
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
            // "scrollY": "400px",
            "scrollX": true,   // Enable horizontal scrolling if needed
            "buttons": ["csv", "excel"]
        }).buttons().container().appendTo('#myDataTable_wrapper .col-md-6:eq(0)');
      });
   </script>
</body>
</html>