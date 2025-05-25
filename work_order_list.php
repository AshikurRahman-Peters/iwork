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
                                                        <center>Quantity</center>
                                                    </th>
                                                    <th>
                                                        <center>Sales Order</center>
                                                    </th>
                                                    <th>
                                                        <center>Customer</center>
                                                    </th>
                                                    <th>
                                                        <center>Style</center>
                                                    </th>
                                                    <th>
                                                        <center>Style Description</center>
                                                    </th>
                                                    <th>
                                                        <center>Sales Order Qty</center>
                                                    </th>
                                                    <th>
                                                        <center>Worker Assignment</center>
                                                    </th>
                                                    <th>
                                                        <center>Color Size Assortment</center>
                                                    </th>
                                                    <th>
                                                        <center>Garment Parts</center>
                                                    </th>
                                                    <th>
                                                        <center>Status</center>
                                                    </th>
                                                    <th>
                                                        <center>Actions</center>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                       $sql = "SELECT * FROM `ework_sales_order` group by docnumber";
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
                                                    <td><a href="work_order_edit.php?id=<?php echo $value['docnumber'];?>"
                                                            target="_blank"><?php echo $value['docnumber'];?></a></th>
                                                    <td><?php echo $value['WorkOrder'];?></td>
                                                    <td><?php echo $value['docdate'];?></td>
                                                    <td><?php echo $value['quantity'];?></td>
                                                    <td><?php echo $value['SalesOrder'];?></td>
                                                    <td><?php echo $value['Customer'];?></td>
                                                    <td><?php echo $value['Style'];?></td>
                                                    <td><?php echo $value['StyleDescription'];?></td>
                                                    <td><?php echo $value['SalesOrderQuantity'];?></td>
                                                    <td><?php echo $value['WorkerAssignment'];?></td>
                                                    <td><?php echo $value['ColorSizeAssortment'];?></td>
                                                    <td><?php echo $value['GarmentParts'];?></td>
                                                    <td><?php if( $value['docstatus'] == 0){?>
                                                        Entered
                                                        <?php }elseif( $value['docstatus'] == 1){ ?>
                                                        In Progress
                                                        <?php  }elseif( $value['docstatus'] == 9){?>
                                                        Closed
                                                        <?php }?></td>
                                                    <td style="width: 15%">
                                                        <div class="btn-group" role="group">
                                                            <?php if ($value['docstatus']  == 9){ ?>
                                                            <button type="button"
                                                                class="btn btn-outline-primary btn-sm deleteLine"
                                                                onclick="ReOpenDoc('<?php echo $value['docnumber']; ?>')">Re-Open
                                                                WO</button>
                                                            <?php } elseif ($value['docstatus']  == 1){ ?>
                                                            <button type="button" class="btn btn-outline-primary btn-sm"
                                                                onclick="CloseDoc('<?php echo $value['docnumber']; ?>')">Close
                                                                WO</button>
                                                            <?php } elseif ($value['GarmentParts']  == 'Yes' && $value['ColorSizeAssortment'] == 'Yes' && $value['WorkerAssignment'] == 'Yes'){ ?>
                                                            <button type="button"
                                                                class="btn btn-outline-primary btn-sm editLine"
                                                                onclick="updateDoc('<?php echo $value['docnumber']; ?>')">Ready
                                                                for Operation</button>
                                                            <?php }else{?>
                                                            <button
                                                                style="font-size: 10px; padding: 1px; background: #00b7ea; color: white"
                                                                type="button" class="btn btn-outline-primary btn-sm"
                                                                onclick="addColorSize('<?php echo $value['docnumber']; ?>')">Add
                                                                Color & Size</button>
                                                            <button type="button" class="btn btn-outline-primary btn-sm"
                                                                onclick="addPartsName('<?php echo $value['docnumber']; ?>')">Add
                                                                parts
                                                                Name</button>
                                                            <button type="button" class="btn btn-outline-primary btn-sm"
                                                                onclick="addWorker('<?php echo $value['docnumber']; ?>')">Add
                                                                Worker</button>
                                                            <button type="button" class="btn btn-outline-primary btn-sm"
                                                                onclick="addimage('<?php echo $value['docnumber']; ?>')">Add
                                                                Image</button>
                                                            <button type="button" class="btn btn-outline-primary btn-sm"
                                                                onclick="makecopy('<?php echo $value['docnumber']; ?>')">Make
                                                                Copy</button>
                                                            <?php }?>
                                                        </div>
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

    function addColorSize(docnumber) {
        window.location.href = 'add_color_size.php?id=' + encodeURIComponent(docnumber);
    }

    function addPartsName(docnumber) {
        window.location.href = 'add_parts_name.php?id=' + encodeURIComponent(docnumber);
    }

    function addWorker(docnumber) {
        window.location.href = 'worker_assignment2.php?id=' + encodeURIComponent(docnumber);
    }
    var cartItems = [];

    function CloseDoc(docnumber) {
        var confirmDelete = confirm("Do you really want to make this  " + docnumber +
            " document ready for operation ?");

        if (confirmDelete) {
            // User clicked OK, proceed with the delete action
            CloseDocStatus(docnumber);
        } else {
            // User clicked Cancel, do nothing or provide feedback
        }
    }

    function ReOpenDoc(docnumber) {
        var confirmDelete = confirm("Do you really want to make this  " + docnumber +
            " document Re Open ?");

        if (confirmDelete) {
            // User clicked OK, proceed with the delete action
            ReOpenDocStatus(docnumber);
        } else {
            // User clicked Cancel, do nothing or provide feedback
        }
    }

    function ReOpenDocStatus(docnumber) {

        var updatedItem = {
            docnumber: docnumber,
            type: 'ReOpen'
        };
        if (!updatedItem) {
            alert("Please fill in all required fields");
            return;
        }
        cartItems.push(updatedItem);
        var saveData = $.ajax({
            type: 'POST',
            url: "work_order_store.php",
            data: {
                cartItems: cartItems
            }, // Send an object with a property named "cartItems" containing the array
            dataType: "text",
            success: function(data) {

                // alert("Form Submitted Successfully");
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
            }
        });
    }

    function CloseDocStatus(docnumber) {

        var updatedItem = {
            docnumber: docnumber,
            type: 'CloseDocStatus'
        };
        if (!updatedItem) {
            alert("Please fill in all required fields");
            return;
        }
        cartItems.push(updatedItem);
        var saveData = $.ajax({
            type: 'POST',
            url: "work_order_store.php",
            data: {
                cartItems: cartItems
            }, // Send an object with a property named "cartItems" containing the array
            dataType: "text",
            success: function(data) {

                // alert("Form Submitted Successfully");
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
            }
        });
    }


    function updateDoc(docnumber) {
        var confirmDelete = confirm("Do you really want to make this  " + docnumber +
            " document ready for operation ?");

        if (confirmDelete) {
            // User clicked OK, proceed with the delete action
            updateDocStatus(docnumber);
        } else {
            // User clicked Cancel, do nothing or provide feedback
        }
    }



    function updateDocStatus(docnumber) {

        var updatedItem = {
            docnumber: docnumber,
            type: 'updateDocStatus'
        };
        if (!updatedItem) {
            alert("Please fill in all required fields");
            return;
        }
        cartItems.push(updatedItem);
        var saveData = $.ajax({
            type: 'POST',
            url: "work_order_store.php",
            data: {
                cartItems: cartItems
            }, // Send an object with a property named "cartItems" containing the array
            dataType: "text",
            success: function(data) {

                // alert("Form Submitted Successfully");
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
            }
        });
    }

    function makecopy(docnumber) {
        window.location.href = 'work_order_make_copy.php?id=' + encodeURIComponent(docnumber);
    }

    function addimage(docnumber) {
        window.location.href = 'work_order_add_image.php?id=' + encodeURIComponent(docnumber);
    }
    </script>
</body>

</html>