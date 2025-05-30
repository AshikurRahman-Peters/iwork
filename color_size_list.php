<?php
   session_start();
   if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit;
   }
   include 'header.php';
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
                                        <table id="myDataTable" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <center>Doc No.</center>
                                                    </th>
                                                    <th>
                                                        <center>Work Order</center>
                                                    </th>
                                                    <th>
                                                        <center>Date</center>
                                                    </th>
                                                    <th>
                                                        <center>WO Quantity</center>
                                                    </th>
                                                    <th>
                                                        <center>Customer</center>
                                                    </th>
                                                    <th>
                                                        <center>Style</center>
                                                    </th>
                                                    <th>
                                                        <center>Color</center>
                                                    </th>
                                                    <th>
                                                        <center>Size</center>
                                                    </th>
                                                    <th>
                                                        <center>Quantity</center>
                                                    </th>

                                                    <th>
                                                        <center>Actions</center>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                       $sql = "SELECT * FROM `ework_order_wise_color_size_qty` group by WO_docnumber";
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
                                       ?>
                                                <?php foreach($sewing_line_data as $value){?>
                                                <tr>
                                                    <td><a href="" target="_blank"><?php echo $value['docnumber'];?></a>
                                                        </th>
                                                    <td><?php echo $value['WorkOrder'];?></td>
                                                    <td><?php echo $value['docdate'];?></td>
                                                    <td><?php echo $value['quantity'];?></td>
                                                    <td><?php echo $value['Customer'];?></td>
                                                    <td><?php echo $value['Style'];?></td>
                                                    <td><?php echo $value['color'];?></td>
                                                    <td><?php echo $value['size'];?></td>
                                                    <td><?php echo $value['qty'];?></td>
                                                    <td style="padding: 2px;width: 10%;color: white;">
                                                        <button type="button"
                                                            onclick="editColorSize('<?php echo $value['WO_docnumber']; ?>')"
                                                            class="btn btn-outline-primary">Edit</button>
                                                    </td>
                                                </tr>
                                                <?php }?>
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
    $(function() {
        $("#myDataTable").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "scrollY": "400px", // Set the desired height
            "scrollX": true, // Enable horizontal scrolling if needed
            "buttons": ["csv", "excel"]
        }).buttons().container().appendTo('#myDataTable_wrapper .col-md-6:eq(0)');
    });

    function viewColorSize(docnumber) {
        window.location.href = 'view_color_size.php?id=' + encodeURIComponent(docnumber);
    }

    function editColorSize(docnumber) {
        window.location.href = 'edit_color_size.php?id=' + encodeURIComponent(docnumber);
    }
    </script>
</body>

</html>