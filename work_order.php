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
                        <div class="border p-3">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="docdate" class="form-label">Date<span class="required">*</span></label>
                                    <?php $date = date('Y-m-d');?>
                                    <input type="text" name="docdate" id="docdate" class="form-control datepicker"
                                        value="<?php echo $date; ?>" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="WorkOrder" class="form-label">Work Order<span
                                            class="required">*</span></label>
                                    <input type="text" name="WorkOrder" id="WorkOrder" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="Version" class="form-label">Version</label>
                                    <input type="text" name="Version" id="Version" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="site" class="form-label">Site<span class="required">*</span></label>
                                    <select name="site" id="site" class="form-select" required>
                                        <option value="">Select</option>
                                        <option value="LTD">Lida Textile and Dyeing Limited</option>
                                        <option value="LFI">Liz Fashion Industry Limited</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="building" class="form-label">Building<span
                                            class="required">*</span></label>
                                    <select name="building" id="building" class="form-select" required>
                                        <option value="">Select</option>
                                        <option value="LTD01">Lida Production</option>
                                        <option value="Liz01">Liz-1</option>
                                        <option value="Liz02">Liz-2</option>
                                        <option value="Liz03">Liz-3</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="floor" class="form-label">Floor<span class="required">*</span></label>
                                    <select name="floor" id="floor" class="form-select" required>
                                        <option value="">Select</option>
                                        <option value="002">1st</option>
                                        <option value="003">2nd</option>
                                        <option value="004">3rd</option>
                                        <option value="005">4th</option>
                                        <option value="006">5th</option>
                                        <option value="007">6th</option>
                                        <option value="001">Ground</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="line" class="form-label">Sewing Line No.<span
                                            class="required">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="line" id="line" class="form-control" required>
                                        <button type="button" class="btn btn-outline-primary"
                                            title="Click this for look up data" onclick="showModalSewing()"><i
                                                class="material-icons">search</i></button>
                                    </div>
                                </div>
                                <!-- Bootstrap 5 Modal -->
                                <div class="modal" tabindex="-1" role="dialog" id="lookupModalsewing">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Sewing Line Data</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <?php
                                       $sql = "SELECT Code FROM `ework_mrd_library` WHERE LibraryName = 'SewingLine'";
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
                                                <!-- Dropdown for options -->
                                                <div class="input-group mt-3">
                                                    <select class="form-select" id="lookupOptionssewing">
                                                        <?php foreach($sewing_line_data as $value){?>
                                                        <option value="<?php echo $value['Code'];?>">
                                                            <?php echo $value['Code'];?></option>
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
                                                    onclick="saveDataSewing()">Save
                                                    changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="quantity" class="form-label">Allocated Qty<span
                                            class="required">*</span></label>
                                    <input type="text" name="quantity" id="quantity" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="SalesOrder" class="form-label">Customer Ref#</label>
                                    <input type="text" name="SalesOrder" id="SalesOrder" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="Customer" class="form-label">Customer<span
                                            class="required">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="Customer" id="Customer" class="form-control" required>
                                        <button type="button" class="btn btn-outline-primary"
                                            title="Click this for look up data" onclick="showModalCustomer()"><i
                                                class="material-icons">search</i></button>
                                    </div>
                                </div>
                                <!-- Bootstrap 5 Modal -->
                                <div class="modal" tabindex="-1" role="dialog" id="lookupModalcustomer">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Customer Data</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <?php
                                       $sql = "SELECT Description FROM `ework_mrd_library` WHERE LibraryName = 'Buyer'";
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
                                                <div class="input-group mt-3">
                                                    <select class="form-select" id="lookupOptionscustomer">
                                                        <?php foreach($customer_data as $value){?>
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
                                                    onclick="saveDataCustomer()">Save
                                                    changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="Style" class="form-label">Style<span class="required">*</span></label>
                                    <input type="text" name="Style" id="Style" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="StyleDescription" class="form-label">Style Description<span
                                            class="required">*</span></label>
                                    <textarea name="StyleDescription" id="StyleDescription" class="form-control"
                                        required></textarea>
                                </div>
                                <div class="col-md-4">
                                    <label for="SalesOrderQuantity" class="form-label">Work Order Qty</label>
                                    <input type="text" name="SalesOrderQuantity" id="SalesOrderQuantity"
                                        class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="WorkerAssignment" class="form-label">Worker Assignment</label>
                                    <input type="text" name="WorkerAssignment" id="WorkerAssignment"
                                        class="form-control" readonly disabled>
                                </div>
                                <div class="col-md-4">
                                    <label for="ColorSizeAssortment" class="form-label">Color & Size Assortment</label>
                                    <input type="text" name="ColorSizeAssortment" id="ColorSizeAssortment"
                                        class="form-control" readonly disabled>
                                </div>
                                <div class="col-md-4">
                                    <label for="GarmentParts" class="form-label">Part Name Entry</label>
                                    <input type="text" name="GarmentParts" id="GarmentParts" class="form-control"
                                        readonly disabled>
                                </div>
                            </div>
                        </div>
                        <div id="formLinesContainer" class=" mt-3">
                            <div id="formLinesFieldset">
                                <div id="formLineslegend" class="mt-2">Line Information</div>
                                <div class="mb-3">
                                    <button type="button" class="btn btn-outline-primary newLine me-2"
                                        id="openFormBtn">Add New Line</button>
                                    <!-- <button type="button" class="btn btn-outline-primary saveLine me-2">Save</button> -->
                                    <!-- <button type="button" class="btn btn-secondary removeLine me-2" disabled>Delete</button> -->
                                    <!-- <button type="button" class="btn btn-secondary copyAndNewLine">Copy &amp; New</button> -->
                                </div>
                                <div id="rightFormLines" style="display: none">
                                    <div id="dragbar"></div>
                                    <fieldset id="fieldset_linegroup1" class="border p-3">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="lg_linenumber" class="form-label">Line</label>
                                                <input type="text" name="linenumber" id="lg_linenumber"
                                                    class="form-control" value="" readonly="readonly">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="lg_StepNumber" class="form-label">Step Number<span
                                                        class="required">*</span></label>
                                                <input type="text" name="StepNumber" id="lg_StepNumber"
                                                    class="form-control" value="" required="required">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="lg_Process" class="form-label">Process<span
                                                        class="required">*</span></label>
                                                <select name="Process" id="lg_Process" class="form-select"
                                                    required="required">
                                                    <option value="">Select</option>
                                                    <option value="Quality">Quality</option>
                                                    <option value="Sewing">Sewing</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="lg_Description_StepName" class="form-label">Description Step
                                                    Name<span class="required">*</span></label>
                                                <textarea name="Description_StepName" id="lg_Description_StepName"
                                                    class="form-control" required="required"
                                                    spellcheck="false"></textarea>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="lg_Machine" class="form-label">Machine</label>
                                                <select name="Machine" id="lg_Machine" class="form-select">
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
                                                <input type="text" name="StepTimeMins" id="lg_StepTimeMins"
                                                    class="form-control" value="">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="lg_NextStep" class="form-label">Next Step</label>
                                                <input type="text" name="NextStep" id="lg_NextStep" class="form-control"
                                                    value="">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="lg_FirstStep" class="form-label">First Step</label>
                                                <select name="FirstStep" id="lg_FirstStep" class="form-select">
                                                    <option value="">Select</option>
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="lg_LastStep" class="form-label">Last Step</label>
                                                <select name="LastStep" id="lg_LastStep" class="form-select">
                                                    <option value="">Select</option>
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="lg_ColorSizeEntry" class="form-label">Color Size
                                                    Entry</label>
                                                <select name="ColorSizeEntry" id="lg_ColorSizeEntry"
                                                    class="form-select">
                                                    <option value="">Select</option>
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-success"
                                            onclick="addToCart(); return false;">Add to
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
                                                        <th class="StepNumber" required="required">Step Number<span
                                                                class="required">*</span></th>
                                                        <th class="Process" required="required">Process<span
                                                                class="required">*</span></th>
                                                        <th class="Description_StepName" required="required">Description
                                                            Step Name<span class="required">*</span></th>
                                                        <th class="Machine">Machine</th>
                                                        <th class="StepTimeMins">SMV</th>
                                                        <th class="NextStep">Next Step</th>
                                                        <th class="FirstStep">First Step</th>
                                                        <th class="LastStep">Last Step</th>
                                                        <th class="ColorSizeEntry">Color Size Entry</th>
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
                                <label for="lg_ColorSizeEntry" class="form-label">Color Size Entry</label>
                                <select name="ColorSizeEntry" id="lg_ColorSizeEntry1" class="form-select">
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
        <?php include 'footer.php'; ?>
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
            "buttons": ["csv", "excel"]
            // "buttons": ["copy", "csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#myDataTable_wrapper .col-md-6:eq(0)');

    });
    </script>
    <script>
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
    var myModalsewing = new bootstrap.Modal(document.getElementById('lookupModalsewing'));

    function showModalSewing() {
        myModalsewing.show();
    }

    // Function to save data (updated to hide modal)
    function saveDataSewing() {
        var selectedValue = document.getElementById('lookupOptionssewing').value;
        document.getElementById('line').value = selectedValue;
        myModalsewing.hide();
    }

    var myModalcustomer = new bootstrap.Modal(document.getElementById('lookupModalcustomer'));

    function showModalCustomer() {
        myModalcustomer.show();
    }

    // Function to save data (updated to hide modal)
    function saveDataCustomer() {
        var selectedValue = document.getElementById('lookupOptionscustomer').value;
        document.getElementById('Customer').value = selectedValue;
        myModalcustomer.hide();
    }
    </script>
    <script>
    var cartItems = [];
    var rowNumber = 1;

    function addToCart() {

        var lg_StepNumberValue = document.getElementById("lg_StepNumber").value;
        var lg_ProcessValue = document.getElementById("lg_Process").value;
        var lg_Description_StepNameValue = document.getElementById("lg_Description_StepName").value;
        var lg_MachineValue = document.getElementById("lg_Machine").value;
        var lg_StepTimeMinsValue = document.getElementById("lg_StepTimeMins").value;
        var lg_NextStepValue = document.getElementById("lg_NextStep").value;
        var lg_FirstStepValue = document.getElementById("lg_FirstStep").value;
        var lg_LastStepValue = document.getElementById("lg_LastStep").value;
        var lg_ColorSizeEntryValue = document.getElementById("lg_ColorSizeEntry").value;

        var docdateValue = document.getElementById("docdate").value;
        var WorkOrderValue = document.getElementById("WorkOrder").value;
        var VersionValue = document.getElementById("Version").value;
        var siteValue = document.getElementById("site").value;
        var buildingValue = document.getElementById("building").value;
        var floorValue = document.getElementById("floor").value;
        var lineValue = document.getElementById("line").value;
        var quantityValue = document.getElementById("quantity").value;
        var SalesOrderValue = document.getElementById("SalesOrder").value;
        var CustomerValue = document.getElementById("Customer").value;
        var StyleValue = document.getElementById("Style").value;
        var StyleDescriptionValue = document.getElementById("StyleDescription").value;
        var SalesOrderQuantityValue = document.getElementById("SalesOrderQuantity").value;

        // Check if all required fields are filled
        if (!lg_StepNumberValue || !lg_ProcessValue || !lg_Description_StepNameValue || !lg_MachineValue ||
            !lg_StepTimeMinsValue || !lg_NextStepValue || !lg_FirstStepValue || !lg_LastStepValue ||
            !lg_ColorSizeEntryValue || !docdateValue || !WorkOrderValue || !siteValue || !buildingValue || !floorValue
        ) {
            alert("Please fill in all required fields");
            return;
        }

        // Create a cartItem object
        var cartItem = {
            StepNumber: lg_StepNumberValue,
            Process: lg_ProcessValue,
            Description_StepName: lg_Description_StepNameValue,
            Machine: lg_MachineValue,
            StepTimeMins: lg_StepTimeMinsValue,
            NextStep: lg_NextStepValue,
            FirstStep: lg_FirstStepValue,
            LastStep: lg_LastStepValue,
            ColorSizeEntry: lg_ColorSizeEntryValue,
            docdate: docdateValue,
            WorkOrder: WorkOrderValue,
            Version: VersionValue,
            site: siteValue,
            building: buildingValue,
            floor: floorValue,
            line: lineValue,
            quantity: quantityValue,
            SalesOrder: SalesOrderValue,
            Customer: CustomerValue,
            Style: StyleValue,
            StyleDescription: StyleDescriptionValue,
            SalesOrderQuantity: SalesOrderQuantityValue,
            type: 'add'
        };

        // Push the cartItem into the cartItems array
        cartItems.push(cartItem);

        // Create a table row for the added item
        var newRow = document.createElement("tr");
        newRow.innerHTML = `
          <td>${rowNumber}</td>
          <td>${lg_StepNumberValue}</td>
          <td>${lg_ProcessValue}</td>
          <td>${lg_Description_StepNameValue}</td>
          <td>${lg_MachineValue}</td>
          <td>${lg_StepTimeMinsValue}</td>
          <td>${lg_NextStepValue}</td>
          <td>${lg_FirstStepValue}</td>
          <td>${lg_LastStepValue}</td>
          <td>${lg_ColorSizeEntryValue}</td>
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
            alert("Please fill in all required fields.");
            return;
        }

        var saveData = $.ajax({
            type: 'POST',
            url: "work_order_store.php",
            data: {
                cartItems: cartItems
            }, // Send an object with a property named "cartItems" containing the array
            dataType: "text",
            success: function(resultData) {
                alert("Save Complete");
                window.location.reload();
            },
            error: function() {
                alert("Something went wrong");
            }
        });
    }

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
            editingRow.cells[9].innerText = document.getElementById("lg_ColorSizeEntry1").value;


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
        var lg_ColorSizeEntryValue = row.cells[9].innerText;

        document.getElementById("lg_linenumber1").value = lg_linenumberValue;
        document.getElementById("lg_StepNumber1").value = lg_StepNumberValue;
        document.getElementById("lg_Process1").value = lg_ProcessValue;
        document.getElementById("lg_Description_StepName1").value = lg_Description_StepNameValue;
        document.getElementById("lg_Machine1").value = lg_MachineValue;
        document.getElementById("lg_StepTimeMins1").value = lg_StepTimeMinsValue;
        document.getElementById("lg_NextStep1").value = lg_NextStepValue;
        document.getElementById("lg_FirstStep1").value = lg_FirstStepValue;
        document.getElementById("lg_LastStep1").value = lg_LastStepValue;
        document.getElementById("lg_ColorSizeEntry1").value = lg_ColorSizeEntryValue;


    }
    </script>
</body>

</html>