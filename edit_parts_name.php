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
                    <div class="container mt-3">
                        <table id="listTable" class="table table-bordered" style="width:100%">
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
                                        <center>Style</center>
                                    </th>
                                    <th>
                                        <center>Customer</center>
                                    </th>
                                    <th>
                                        <center>Part Name</center>
                                    </th>
                                    <th>
                                        <center>Line No.</center>
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                        $docnumber = htmlspecialchars($_GET['id']);
                        
                                       $sql = "SELECT * FROM `ework_partname` where wo_docnumber = '$docnumber' limit 1";
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
                                    <td id="docnumber" value="<?php echo $value['docnumber']; ?>">
                                        <?php echo $value['docnumber'];?></th>
                                    <td id="WorkOrder" value="<?php echo $value['WorkOrder']; ?>">
                                        <?php echo $value['WorkOrder'];?></td>
                                    <td id="docdate" value="<?php echo $value['docdate']; ?>">
                                        <?php echo $value['docdate'];?></td>
                                    <td id="Style" value="<?php echo $value['Style']; ?>">
                                        <?php echo $value['Style'];?></td>
                                    <td id="Customer" value="<?php echo $value['Customer']; ?>">
                                        <?php echo $value['Customer'];?></td>
                                    <td id="PartName" value="<?php echo $value['PartName']; ?>">
                                        <?php echo $value['PartName'];?>
                                    </td>
                                    <td id="linenumber" value="<?php echo $value['linenumber']; ?>">
                                        <?php echo $value['linenumber'];?>
                                    </td>
                                    <input type="hidden" id="wo_docnumber" value="<?php echo $value['wo_docnumber'];?>">
                                    <!-- <input type="hidden" id="quantity" value="<?php //echo $value['quantity'];?>"> -->

                                </tr>
                                <?php }?>
                                <!-- Add more rows as needed -->
                            </tbody>
                        </table>
                        <div id="formLinesContainer" class=" mt-3">
                            <div id="formLinesFieldset">
                                <div id="rightFormLines">
                                    <div id="dragbar"></div>
                                    <fieldset id="fieldset_linegroup1" class="border p-3">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="Part" class="form-label">Part<span
                                                        class="required">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" name="Part" id="Part" class="form-control"
                                                        required />
                                                    <button type="button" class="btn btn-outline-primary"
                                                        title="Click this for look up data" onclick="showModalPart()"><i
                                                            class="material-icons">search</i></button>
                                                </div>
                                            </div>
                                            <!-- Bootstrap 5 Modal -->
                                            <div class="modal" tabindex="-1" role="dialog" id="lookupModalPart">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Part Name</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php
                                                              $sql = "SELECT Description FROM `ework_mrd_library` WHERE LibraryName = 'PartCodes'";
                                                              $result = $conn->query($sql);
                      
                                                              if ($result->num_rows > 0) {
                                                                  $Part_data = [];
                                                              // output data of each row
                                                              while($row = $result->fetch_assoc()) {
                                                                  $Part_data[] =  $row;
                                                              }
                                                              } else {
                                                              echo "0 results";
                                                              }
                                                                ?>
                                                            <!-- Dropdown for options -->
                                                            <div class="input-group mt-3">
                                                                <select class="form-select" id="lookupOptionsPart">
                                                                    <?php foreach($Part_data as $value){?>
                                                                    <option value="<?php echo $value['Description'];?>">
                                                                        <?php echo $value['Description'];?>
                                                                    </option>
                                                                    <?php }?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <!-- Close button -->
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <!-- Save button (you can customize the onclick function as needed) -->
                                                            <button type="button" class="btn btn-outline-primary"
                                                                onclick="saveDataPart()">Save
                                                                changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-success" onclick="addToCart();">Add
                                            New</button>
                                    </fieldset>
                                </div>
                                <div class="clearfix"></div>
                                <div id="leftFormLines">
                                    <div id="formLines">
                                        <div id="fieldset_lineinformation">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="linenumber">Line</th>
                                                        <th class="linenumber">Part </th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                        $docnumber = htmlspecialchars($_GET['id']);
                                                        
                                                        $sql = "SELECT * FROM `ework_partname` where wo_docnumber = '$docnumber'";
                                                        $result = $conn->query($sql);
                                            
                                                        if ($result->num_rows > 0) {
                                                            $sewing_line_data = [];
                                                        // output data of each row
                                                        while($row = $result->fetch_assoc()) {
                                                            $sewing_line_data[] =  $row;
                                                        }
                                                        } else {
                                                        echo "0 results";
                                                        } ?>

                                                <tbody>
                                                    <?php foreach ($sewing_line_data as $value) { ?>
                                                    <tr>
                                                        <td><?php echo $value['linenumber']; ?></td>


                                                        <td>
                                                            <div class="input-group">
                                                                <select class="form-select"
                                                                    id="lookupOptionsPart_<?php echo $value['idlines']; ?>">
                                                                    <?php foreach ($Part_data as $Part_data_value) { ?>
                                                                    <option
                                                                        value="<?php echo $Part_data_value['Description']; ?>"
                                                                        <?php if ($value['PartName'] == $Part_data_value['Description']) { echo "selected"; } ?>>
                                                                        <?php echo $Part_data_value['Description']; ?>
                                                                    </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-outline-primary"
                                                                onclick="updateCartItem('<?php echo $value['idlines']; ?>')">Update</button>
                                                            <button type="button" class="btn btn-outline-danger"
                                                                onclick="confirmDelete('<?php echo $value['idlines']; ?>')">Delete</button>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>

                                            </table>
                                        </div>
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
        <!-- Edit Modal -->

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
        // Assuming 'a' is a variable that holds the condition
        var Docstatus = '<?php echo  $sewing_line_data[0]['docstatus'];?>';

        // Function to disable all input fields
        function disableAllFields() {
            var inputs = document.querySelectorAll('input, textarea, select,button');
            inputs.forEach(function(input) {
                input.disabled = true;
            });
        }

        // Check if 'a' is equal to 1, then disable all fields
        if (Docstatus === '9') {
            disableAllFields();
        }

        var myModalPart = new bootstrap.Modal(document.getElementById('lookupModalPart'));

        function showModalPart() {
            myModalPart.show();
        }

        // Function to save data (updated to hide modal)
        function saveDataPart() {
            var selectedValue = document.getElementById('lookupOptionsPart').value;
            document.getElementById('Part').value = selectedValue;
            myModalPart.hide();
        }

        $(document).ready(function() {
            $("#openFormBtn").on("click", function() {
                $("#rightFormLines").show();
            });
        });
        $(document).ready(function() {
            $("#closefrom").on("click", function() {
                $("#rightFormLines").hide();
            });
        });
        </script>
        <!-- JavaScript to show the modal -->
        <script>
        var cartItems = [];
        var rowNumber = 1;

        function addToCart() {

            var Part = document.getElementById("Part").value;

            var docdateValue = document.getElementById("docdate").getAttribute("value");
            var docnumberValue = document.getElementById("wo_docnumber").value;
            var WorkOrderValue = document.getElementById("WorkOrder").getAttribute("value");
            // var quantityValue = document.getElementById("quantity").getAttribute("value");
            // var SalesOrderValue = document.getElementById("SalesOrder").getAttribute("value");
            var CustomerValue = document.getElementById("Customer").getAttribute("value");
            var StyleValue = document.getElementById("Style").getAttribute("value");
            // var StyleDescriptionValue = document.getElementById("StyleDescription").getAttribute("value");
            // var SalesOrderQuantityValue = document.getElementById("SalesOrderQuantity").getAttribute("value");

            // Check if all required fields are filled
            if (!Part) {
                alert("Please fill in all required fields");
                return;
            }

            // Create a cartItem object
            var cartItem = {
                Part: Part,
                docdate: docdateValue,
                docnumber: docnumberValue,
                WorkOrder: WorkOrderValue,
                Customer: CustomerValue,
                Style: StyleValue,
                type: 'update'
            };
            cartItems.push(cartItem);
            if (cartItem.length === 0) {
                alert("Cart is empty. Add items before saving.");
                return;
            }

            var saveData = $.ajax({
                type: 'POST',
                url: "parts_name_store.php",
                data: {
                    cartItems: cartItems
                }, // Send an object with a property named "cartItems" containing the array
                dataType: "text",
                success: function(data) {

                    alert("Form Submitted Successfully");
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', xhr.responseText);
                }
            });
        }



        function updateCartItem(idlines) {
            // Fetch other necessary data
            var updatedItem = {


                Part: document.getElementById('lookupOptionsPart_' + idlines).value,
                idlines: idlines,
                type: 'edit'
                // Add other properties as needed
            };


            // Check if all required fields are filled
            if (!updatedItem) {
                alert("Please fill in all required fields");
                return;
            }
            cartItems.push(updatedItem);
            var saveData = $.ajax({
                type: 'POST',
                url: "parts_name_store.php",
                data: {
                    cartItems: cartItems
                }, // Send an object with a property named "cartItems" containing the array
                dataType: "text",
                success: function(data) {

                    alert("Form Submitted Successfully");
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', xhr.responseText);
                }
            });
        }

        function confirmDelete(idlines) {
            var confirmDelete = confirm("Do you really want to delete the row with linenumber " + idlines + "?");

            if (confirmDelete) {
                // User clicked OK, proceed with the delete action
                removeFromCart(idlines);
            } else {
                // User clicked Cancel, do nothing or provide feedback
            }
        }

        // sendFormDataToServer();

        function removeFromCart(idlines) {
            // Fetch other necessary data
            var updatedItem = {

                idlines: idlines,
                type: 'delete'
                // Add other properties as needed
            };
            // Check if all required fields are filled
            if (!updatedItem) {
                alert("Please fill in all required fields");
                return;
            }
            cartItems.push(updatedItem);
            var saveData = $.ajax({
                type: 'POST',
                url: "parts_name_store.php",
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
        </script>
</body>

</html>