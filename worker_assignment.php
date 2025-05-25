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
                    <form action="#" method="post" id="formERP" autocomplete="off" class="container mt-3">
                        <div class="row mb-3">
                            <div class="col-12">
                                <button type="button" class="btn btn-outline-primary me-2"
                                    onclick="sendFormDataToServer()"><i class="material-icons">save</i></button>
                                <input type="button" class="btn btn-secondary me-2" value="Cancel"
                                    title="Cancel changes and go back to the previous page">
                                <!-- <button type="button" class="btn btn-light me-2"><i class="material-icons">edit</i></button> -->
                                <!-- Add other buttons as needed -->
                            </div>
                        </div>
                        <table id="listTable" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Date</center>
                                    </th>
                                    <th>
                                        <center>Work Order</center>
                                    </th>
                                    <th>
                                        <center>Doc No.</center>
                                    </th>
                                    <th>
                                        <center>Style</center>
                                    </th>
                                    <th>
                                        <center>Style Description</center>
                                    </th>
                                    <th>
                                        <center>Sewing Line NO.</center>
                                    </th>
                                    <th>
                                        <center>Customer</center>
                                    </th>
                                    <th>
                                        <center>Quantity</center>
                                    </th>
                                    <th>
                                        <center>Step No.</center>
                                    </th>
                                    <th>
                                        <center>Step Name</center>
                                    </th>
                                    <th>
                                        <center>Process</center>
                                    </th>
                                    <!-- <th>
                              <center>Sales Order Qty</center>
                              </th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                           $idlines = htmlspecialchars($_GET['id']);
                           
                                          $sql = "SELECT * FROM `ework_sales_order` where idlines = '$idlines' limit 1";
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
                                    <td id="docdate" value="<?php echo $value['docdate']; ?>">
                                        <?php echo $value['docdate'];?></td>
                                    <td id="WorkOrder" value="<?php echo $value['WorkOrder']; ?>">
                                        <?php echo $value['WorkOrder'];?></td>
                                    <td id="docnumber" value="<?php echo $value['docnumber']; ?>">
                                        <?php echo $value['docnumber'];?></th>
                                    <td id="Style" value="<?php echo $value['Style']; ?>"><?php echo $value['Style'];?>
                                    </td>
                                    <td id="StyleDescription" value="<?php echo $value['StyleDescription']; ?>">
                                        <?php echo $value['StyleDescription'];?>
                                    </td>
                                    <td id="linenumber" value="<?php echo $value['linenumber']; ?>">
                                        <?php echo $value['linenumber'];?>
                                    </td>
                                    <td id="Customer" value="<?php echo $value['Customer']; ?>">
                                        <?php echo $value['Customer'];?></td>
                                    <td id="quantity" value="<?php echo $value['quantity']; ?>">
                                        <?php echo $value['quantity'];?></td>
                                    <td id="StepNumber" value="<?php echo $value['StepNumber']; ?>">
                                        <?php echo $value['StepNumber'];?></td>
                                    <td id="Description_StepName" value="<?php echo $value['Description_StepName']; ?>">
                                        <?php echo $value['Description_StepName'];?></td>
                                    <td id="Process" value="<?php echo $value['Process']; ?>">
                                        <?php echo $value['Process'];?></td>
                                    <input type="hidden" name="SalesOrder" id="SalesOrder" class="form-control"
                                        value="<?php echo $value['SalesOrder'];?>">
                                    <input type="hidden" name="SalesOrderQuantity" id="SalesOrderQuantity"
                                        class="form-control" value="<?php echo $value['SalesOrderQuantity'];?>">
                                    <input type="hidden" name="ShipDate" id="ShipDate" class="form-control"
                                        value="<?php echo $value['ShipDate'];?>">


                                    <input type="hidden" name="Machine" id="Machine" class="form-control"
                                        value="<?php echo $value['Machine'];?>">
                                    <input type="hidden" name="StepTimeMins" id="StepTimeMins" class="form-control"
                                        value="<?php echo $value['StepTimeMins'];?>">
                                    <input type="hidden" name="NextStep" id="NextStep" class="form-control"
                                        value="<?php echo $value['NextStep'];?>">
                                    <input type="hidden" name="FirstStep" id="FirstStep" class="form-control"
                                        value="<?php echo $value['FirstStep'];?>">
                                    <input type="hidden" name="docstatus" id="docstatus" class="form-control"
                                        value="<?php echo $value['docstatus'];?>">
                                    <input type="hidden" name="ColorSizeEntry" id="ColorSizeEntry" class="form-control"
                                        value="<?php echo $value['ColorSizeEntry'];?>">
                                    <input type="hidden" name="site" id="site" class="form-control"
                                        value="<?php echo $value['site'];?>">
                                    <input type="hidden" name="building" id="building" class="form-control"
                                        value="<?php echo $value['building'];?>">
                                    <input type="hidden" name="floor" id="floor" class="form-control"
                                        value="<?php echo $value['floor'];?>">
                                    <input type="hidden" name="LastStep" id="LastStep" class="form-control"
                                        value="<?php echo $value['LastStep'];?>">
                                    <input type="hidden" name="WorkerAssignment" id="WorkerAssignment"
                                        class="form-control" value="<?php echo $value['WorkerAssignment'];?>">
                                    <input type="hidden" name="ColorSizeAssortment" id="ColorSizeAssortment"
                                        class="form-control" value="<?php echo $value['ColorSizeAssortment'];?>">
                                    <input type="hidden" name="GarmentParts" id="GarmentParts" class="form-control"
                                        value="<?php echo $value['GarmentParts'];?>">
                                    <input type="hidden" name="WorkerActive" id="WorkerActive" class="form-control"
                                        value="<?php echo $value['WorkerActive'];?>">
                                    <input type="hidden" name="doccreationtime" id="doccreationtime"
                                        class="form-control" value="<?php echo $value['doccreationtime'];?>">
                                </tr>
                                <?php }?>
                                <!-- Add more rows as needed -->
                            </tbody>
                        </table>
                        <div id="formLinesContainer" class=" mt-3">
                            <div id="formLinesFieldset">
                                <div id="formLineslegend" class="mt-2">Worker Information</div>
                                <div class="mb-3">
                                    <button type="button" class="btn btn-outline-primary newLine me-2"
                                        id="openFormBtn">Add
                                        New</button>
                                </div>
                                <div id="rightFormLines" style="display: none">
                                    <div id="dragbar"></div>
                                    <fieldset id="fieldset_linegroup1" class="border p-3">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="Worker" class="form-label">Assign Worker<span
                                                        class="required">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" name="Worker" id="Worker" class="form-control"
                                                        required>
                                                    <button type="button" class="btn btn-outline-primary"
                                                        title="Click this for look up data"
                                                        onclick="showModalWorker()"><i
                                                            class="material-icons">search</i></button>
                                                </div>
                                            </div>
                                            <!-- Bootstrap 5 Modal -->
                                            <div class="modal" tabindex="-1" role="dialog" id="lookupModalWorker">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Select Worker Name</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php
                                                $sql = "SELECT * FROM `ework_workers`";
                                                $result = $conn->query($sql);
                                                
                                                if ($result->num_rows > 0) {
                                                    $customer_data = [];
                                                // output data of each row
                                                while($row = $result->fetch_assoc()) {
                                                    $customer_data[] =  $row;
                                                }
                                                } else {
                                                echo "0 results";
                                                }
                                                 ?>
                                                            <!-- Dropdown for options -->
                                                            <div class="input-group m-2">
                                                                <select class="form-select" id="lookupOptionsWorker"
                                                                    onchange="updateFields()">
                                                                    <?php foreach($customer_data as $value){?>
                                                                    <option value="<?php echo $value['cardnumber'];?>">
                                                                        <?php echo $value['cardnumber'];?>
                                                                    </option>
                                                                    <?php }?>
                                                                </select>
                                                            </div>
                                                            <div class="input-group m-2">
                                                                <select class="form-select" id="Name" disabled>
                                                                    <?php foreach($customer_data as $value){?>
                                                                    <option value="<?php echo $value['Name'];?>">
                                                                        <?php echo $value['Name'];?>
                                                                    </option>
                                                                    <?php }?>
                                                                </select>
                                                                <select class="form-select" id="Position" disabled>
                                                                    <?php foreach($customer_data as $value){?>
                                                                    <option value="<?php echo $value['Position'];?>">
                                                                        <?php if($value['Position'] == 0) { echo "Operator";}elseif ($value['Position'] == 1) {
                                                         echo "Helper";
                                                         }elseif ($value['Position'] == 2) {
                                                         echo "Quality";
                                                         }
                                                         ?>
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
                                                                onclick="saveDataWorker()">Save
                                                                changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-success" onclick="addToCart();">Add
                                            to
                                            Line</button>
                                        <button type="button" class="btn btn-outline-success"
                                            id="closefrom">Close</button>
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
                                                        <th class="Worker">Worker </th>
                                                        <th class="CardName">Card Name </th>
                                                        <th class="Position">Position </th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="cartItems" class="editing">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                </form>
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
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Edit form content -->
                    <fieldset id="fieldset_linegroup1" class="border p-3">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="lg_linenumber" class="form-label">Line</label>
                                <input type="text" name="linenumber" id="lg_linenumber1" class="form-control" value=""
                                    readonly="readonly">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="lg_StepNumber" class="form-label">Step Number<span
                                        class="required">*</span></label>
                                <input type="text" name="StepNumber" id="lg_StepNumber1" class="form-control" value=""
                                    required="required">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="lg_Process" class="form-label">Process<span
                                        class="required">*</span></label>
                                <select name="Process" id="lg_Process1" class="form-select" required="required">
                                    <option value="">Select</option>
                                    <option value="Quality">Quality</option>
                                    <option value="Sewing">Sewing</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="lg_Description_StepName1" class="form-label">Description Step
                                    Name<span class="required">*</span></label>
                                <textarea name="Description_StepName" id="lg_Description_StepName1" class="form-control"
                                    required="required" spellcheck="false"></textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="lg_Machine" class="form-label">Machine</label>
                                <select name="Machine" id="lg_Machine1" class="form-select">
                                    <option value="">Select</option>
                                    <option value="BA">Button Attach</option>
                                    <option value="BH">Button Hole</option>
                                    <option value="FL">Flatlock</option>
                                    <option value="FUSING">Fusing</option>
                                    <option value="KNS">Kansai</option>
                                    <option value="MAN">Manual</option>
                                    <option value="OL">Overlock</option>
                                    <option value="PM">Plain</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="lg_StepTimeMins" class="form-label">SMV</label>
                                <input type="text" name="StepTimeMins" id="lg_StepTimeMins1" class="form-control"
                                    value="">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="lg_NextStep" class="form-label">Next Step</label>
                                <input type="text" name="NextStep" id="lg_NextStep1" class="form-control" value="">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="lg_FirstStep" class="form-label">First Step</label>
                                <select name="FirstStep" id="lg_FirstStep1" class="form-select">
                                    <option value="">Select</option>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="lg_LastStep" class="form-label">Last Step</label>
                                <select name="LastStep" id="lg_LastStep1" class="form-select">
                                    <option value="">Select</option>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="lg_ColorWorkerEntry" class="form-label">Color Worker Entry</label>
                                <select name="ColorWorkerEntry" id="lg_ColorWorkerEntry1" class="form-select">
                                    <option value="">Select</option>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-outline-primary" onclick="saveChanges()">Save
                            changes</button>
                    </div>
                </div>
            </div>
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
        function updateFields() {
            // Get the selected cardnumber
            var selectedCardnumber = document.getElementById("lookupOptionsWorker").value;

            // Find the corresponding data in the customer_data array
            var selectedData = <?php echo json_encode($customer_data); ?>.find(function(item) {
                return item.cardnumber == selectedCardnumber;
            });

            // Update the Name and Position fields with the selected data
            document.getElementById("Name").value = selectedData.Name;
            document.getElementById("Position").value = selectedData.Position;
        }

        var myModalWorker = new bootstrap.Modal(document.getElementById('lookupModalWorker'));

        function showModalWorker() {
            myModalWorker.show();
        }

        // Function to save data (updated to hide modal)
        function saveDataWorker() {
            var selectedValue = document.getElementById('lookupOptionsWorker').value;
            document.getElementById('Worker').value = selectedValue;
            myModalWorker.hide();
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

            var Worker = document.getElementById("Worker").value;
            var Name = document.getElementById("Name").value;
            var Position = document.getElementById("Position").value;
            // var color = document.getElementById("color").value;
            // var Worker_Quantity = document.getElementById("Worker_Quantity").value;

            var docdate = document.getElementById("docdate").getAttribute("value");
            var WorkOrder = document.getElementById("WorkOrder").getAttribute("value");
            var docnumber = document.getElementById("docnumber").getAttribute("value");
            var Style = document.getElementById("Style").getAttribute("value");
            var StyleDescription = document.getElementById("StyleDescription").getAttribute("value");
            var linenumber = document.getElementById("linenumber").getAttribute("value");
            var Customer = document.getElementById("Customer").getAttribute("value");
            var quantity = document.getElementById("quantity").getAttribute("value");

            var SalesOrder = document.getElementById("SalesOrder").value;
            var SalesOrderQuantity = document.getElementById("SalesOrderQuantity").value;
            var ShipDate = document.getElementById("ShipDate").value;
            var StepNumber = document.getElementById("StepNumber").getAttribute("value");
            var Process = document.getElementById("Process").getAttribute("value");
            var Description_StepName = document.getElementById("Description_StepName").getAttribute("value");
            var Machine = document.getElementById("Machine").value;
            var StepTimeMins = document.getElementById("StepTimeMins").value;
            var NextStep = document.getElementById("NextStep").value;
            var FirstStep = document.getElementById("FirstStep").value;
            var docstatus = document.getElementById("docstatus").value;
            var ColorSizeEntry = document.getElementById("ColorSizeEntry").value;
            var site = document.getElementById("site").value;
            var building = document.getElementById("building").value;
            var floor = document.getElementById("floor").value;
            var LastStep = document.getElementById("LastStep").value;
            var WorkerAssignment = document.getElementById("WorkerAssignment").value;
            var ColorSizeAssortment = document.getElementById("ColorSizeAssortment").value;
            var GarmentParts = document.getElementById("GarmentParts").value;
            var WorkerActive = document.getElementById("WorkerActive").value;
            var doccreationtime = document.getElementById("doccreationtime").value;




            // Check if all required fields are filled
            if (!Worker) {
                alert("Please fill in all required fields");
                return;
            }

            // Create a cartItem object
            var cartItem = {
                Worker: Worker,
                Name: Name,
                Position: Position,
                docdate: docdate,
                WorkOrder: WorkOrder,
                docnumber: docnumber,
                Style: Style,
                StyleDescription: StyleDescription,
                linenumber: linenumber,
                Customer: Customer,
                quantity: quantity,
                SalesOrder: SalesOrder,
                SalesOrderQuantity: SalesOrderQuantity,
                ShipDate: ShipDate,
                StepNumber: StepNumber,
                Process: Process,
                Description_StepName: Description_StepName,
                Machine: Machine,
                StepTimeMins: StepTimeMins,
                NextStep: NextStep,
                FirstStep: FirstStep,
                docstatus: docstatus,
                ColorSizeEntry: ColorSizeEntry,
                site: site,
                building: building,
                floor: floor,
                LastStep: LastStep,
                WorkerAssignment: WorkerAssignment,
                ColorSizeAssortment: ColorSizeAssortment,
                GarmentParts: GarmentParts,
                WorkerActive: WorkerActive,
                doccreationtime: doccreationtime,
                type: 'add'
            };


            // Push the cartItem into the cartItems array
            cartItems.push(cartItem);

            // Create a table row for the added item
            var newRow = document.createElement("tr");
            newRow.innerHTML = `
          <td>${rowNumber}</td>
          <td>${Worker}</td>
          <td>${Name}</td>
          <td>${Position == 0 ? "Operator" : (Position == 1 ? "Helper" :  Position == 2 ? "Quality" : "")}</td>
          <td>
              <button type="button" class="btn btn-outline-danger" onclick="removeFromCart(this)">Delete</button>
          </td>
      `;


            // Append the new row to the table body
            document.getElementById("cartItems").appendChild(newRow);

            // Increment the row number for the next entry
            rowNumber++;
        }

        // Function to make the AJAX request
        function sendFormDataToServer() {
            // Check if cartItems is not empty
            if (cartItems.length === 0) {
                alert("Cart is empty. Add items before saving.");
                return;
            }

            var saveData = $.ajax({
                type: 'POST',
                url: "worker_assignment_store.php",
                data: {
                    cartItems: cartItems
                }, // Send an object with a property named "cartItems" containing the array
                dataType: "text",
                success: function(resultData) {
                    var docnumberValue = document.getElementById("docnumber").getAttribute("value");
                    window.location.href = 'edit_worker_assignment.php?id=' + docnumberValue;
                },
                error: function() {
                    alert("Something went wrong");
                }
            });
        }

        // sendFormDataToServer();





        function removeFromCart(button) {
            // Remove the corresponding row from the table
            var row = button.closest("tr");
            row.remove();
        }









        function saveChanges() {
            // Find the editing row based on the 'editing' class
            var editingRow = document.querySelector("tr.fieldset_linegroup1");

            if (editingRow) {
                // Update the row data
                editingRow.cells[0].innerText = document.getElementById("lg_linenumber1").value;
                editingRow.cells[1].innerText = document.getElementById("lg_StepNumber1").value;
                editingRow.cells[2].innerText = document.getElementById("lg_Process1").value;
                editingRow.cells[3].innerText = document.getElementById("lg_Description_StepName1").value;
                editingRow.cells[4].innerText = document.getElementById("lg_Machine1").value;
                editingRow.cells[5].innerText = document.getElementById("lg_StepTimeMins1").value;
                editingRow.cells[6].innerText = document.getElementById("lg_NextStep1").value;
                editingRow.cells[7].innerText = document.getElementById("lg_FirstStep1").value;
                editingRow.cells[8].innerText = document.getElementById("lg_LastStep1").value;
                editingRow.cells[9].innerText = document.getElementById("lg_ColorWorkerEntry1").value;


                // Remove the 'editing' class
                editingRow.classList.remove("editing");

                // Close the edit modal
                $('#editModal').hide();

                $("#rightFormLines").hide();

            } else {
                console.error("Row not found.");
            }
        }

        function editCartItem(button) {
            // Get the corresponding row
            var row = button.closest("tr");

            // Populate the modal fields with existing data
            var lg_linenumberValue = row.cells[0].innerText;
            var lg_StepNumberValue = row.cells[1].innerText;
            var lg_ProcessValue = row.cells[2].innerText;
            var lg_Description_StepNameValue = row.cells[3].innerText;
            var lg_MachineValue = row.cells[4].innerText;
            var lg_StepTimeMinsValue = row.cells[5].innerText;
            var lg_NextStepValue = row.cells[6].innerText;
            var lg_FirstStepValue = row.cells[7].innerText;
            var lg_LastStepValue = row.cells[8].innerText;
            var lg_ColorWorkerEntryValue = row.cells[9].innerText;

            document.getElementById("lg_linenumber1").value = lg_linenumberValue;
            document.getElementById("lg_StepNumber1").value = lg_StepNumberValue;
            document.getElementById("lg_Process1").value = lg_ProcessValue;
            document.getElementById("lg_Description_StepName1").value = lg_Description_StepNameValue;
            document.getElementById("lg_Machine1").value = lg_MachineValue;
            document.getElementById("lg_StepTimeMins1").value = lg_StepTimeMinsValue;
            document.getElementById("lg_NextStep1").value = lg_NextStepValue;
            document.getElementById("lg_FirstStep1").value = lg_FirstStepValue;
            document.getElementById("lg_LastStep1").value = lg_LastStepValue;
            document.getElementById("lg_ColorWorkerEntry1").value = lg_ColorWorkerEntryValue;


        }
        </script>
</body>

</html>