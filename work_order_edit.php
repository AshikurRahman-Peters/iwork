<?php
   session_start();
   if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit;
   }
   include 'header.php';
   $doc_number = htmlspecialchars($_GET['id']);
   $new_doc_number = htmlspecialchars($_GET['id']);
   $sql_header = "SELECT * FROM `ework_sales_order` where docnumber = '$new_doc_number' limit 1";
   $result_header = $conn->query($sql_header);
   $row_header = $result_header->fetch_assoc();
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
                                <button type="button" class="btn btn-primary me-2" onclick="sendFormDataToServer()"><i
                                        class="material-icons">Update</i></button>
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
                                    <input type="text" name="WorkOrder" value="<?php echo $row_header['WorkOrder']; ?>"
                                        id="WorkOrder" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="Version" class="form-label">Version</label>
                                    <input type="text" name="Version" value="<?php echo $row_header['Version']; ?>"
                                        id="Version" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="site" class="form-label">Site<span class="required">*</span></label>
                                    <select name="site" id="site" class="form-select" required>
                                        <option value="">Select</option>
                                        <option value="LTD" <?php if($row_header['site']=='LTD'){echo "selected";} ?>>
                                            Lida Textile and Dyeing Limited</option>
                                        <option value="LFI" <?php if($row_header['site']=='LFI'){echo "selected";} ?>>
                                            Liz Fashion Industry Limited</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="building" class="form-label">Building<span
                                            class="required">*</span></label>
                                    <select name="building" id="building" class="form-select" required>
                                        <option value="">Select</option>
                                        <option value="LTD01"
                                            <?php if($row_header['building']=='LTD01'){echo "selected";} ?>>Lida
                                            Production</option>
                                        <option value="Liz01"
                                            <?php if($row_header['building']=='Liz01'){echo "selected";} ?>>Liz-1
                                        </option>
                                        <option value="Liz02"
                                            <?php if($row_header['building']=='Liz02'){echo "selected";} ?>>Liz-2
                                        </option>
                                        <option value="Liz03"
                                            <?php if($row_header['building']=='Liz03'){echo "selected";} ?>>Liz-3
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="floor" class="form-label">Floor<span class="required">*</span></label>
                                    <select name="floor" id="floor" class="form-select" required>
                                        <option value="">Select</option>
                                        <option value="002" <?php if($row_header['floor']=='002'){echo "selected";} ?>>
                                            1st</option>
                                        <option value="003" <?php if($row_header['floor']=='003'){echo "selected";} ?>>
                                            2nd</option>
                                        <option value="004" <?php if($row_header['floor']=='004'){echo "selected";} ?>>
                                            3rd</option>
                                        <option value="005" <?php if($row_header['floor']=='005'){echo "selected";} ?>>
                                            4th</option>
                                        <option value="006" <?php if($row_header['floor']=='006'){echo "selected";} ?>>
                                            5th</option>
                                        <option value="007" <?php if($row_header['floor']=='007'){echo "selected";} ?>>
                                            6th</option>
                                        <option value="001" <?php if($row_header['floor']=='001'){echo "selected";} ?>>
                                            Ground</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="line" class="form-label">Sewing Line No.<span
                                            class="required">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="line" id="line" class="form-control"
                                            value="<?php echo $row_header['line']; ?>" required>
                                        <button type="button" class="btn btn-primary"
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
                                                        <option value="<?php echo $value['Code'];?>"
                                                            <?php if($row_header['line']==$value['Code']){echo "selected";} ?>>
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
                                                <button type="button" class="btn btn-primary"
                                                    onclick="saveDataSewing()">Save
                                                    changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="quantity" class="form-label">Allocated Qty<span
                                            class="required">*</span></label>
                                    <input type="text" name="quantity" value="<?php echo $row_header['quantity']; ?>"
                                        id="quantity" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="SalesOrder" class="form-label">Customer Ref#</label>
                                    <input type="text" name="SalesOrder"
                                        value="<?php echo $row_header['SalesOrder']; ?>" id="SalesOrder"
                                        class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="Customer" class="form-label">Customer<span
                                            class="required">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="Customer"
                                            value="<?php echo $row_header['Customer']; ?>" id="Customer"
                                            class="form-control" required>
                                        <button type="button" class="btn btn-primary"
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
                                                        <option value="<?php echo $value['Description'];?>"
                                                            <?php if($row_header['Customer']==$value['Description']){echo "selected";} ?>>
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
                                                <button type="button" class="btn btn-primary"
                                                    onclick="saveDataCustomer()">Save
                                                    changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="Style" class="form-label">Style<span class="required">*</span></label>
                                    <input type="text" name="Style" value="<?php echo $row_header['Style']; ?>"
                                        id="Style" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="StyleDescription" class="form-label">Style Description<span
                                            class="required">*</span></label>
                                    <textarea name="StyleDescription" id="StyleDescription" class="form-control"
                                        required> <?php echo $row_header['StyleDescription']; ?> </textarea>
                                </div>
                                <div class="col-md-4">
                                    <label for="SalesOrderQuantity" class="form-label">Work Order Qty</label>
                                    <input type="text" name="SalesOrderQuantity"
                                        value="<?php echo $row_header['SalesOrderQuantity']; ?>" id="SalesOrderQuantity"
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
                                <div class="col-md-8">
                                    <label for="GarmentParts" class="form-label">Work Order Image</label><br>
                                    <?php      $sql = "SELECT image_url FROM `ework_work_order_image` WHERE docnumber = '$new_doc_number' limit 1";
                                       $result = $conn->query($sql);
                                       
                                       if ($result->num_rows > 0) {
                                           $customer_data ='';
                                       // output data of each row
                                       while($row = $result->fetch_assoc()) {
                                           $customer_data =  $row;
                                       }
                                       } else {
                                       echo "0 results";
                                       } ?>
                                    <img src="<?php echo 'uploads/images/'.$customer_data['image_url'];?>"
                                        alt="Girl in a jacket" width="200" height="100">
                                </div>
                            </div>
                        </div>
                        <div id="formLinesContainer" class=" mt-3">
                            <div id="formLinesFieldset">
                                <div id="formLineslegend" class="mt-2">Line Information</div>
                                <div class="mb-3">
                                    <button type="button" class="btn btn-primary newLine me-2" id="openFormBtn">Add New
                                        Line</button>
                                    <!-- <button type="button" class="btn btn-primary saveLine me-2">Save</button> -->
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
                                                <input type="hidden" name="" id="docnumber"
                                                    value="<?php echo $new_doc_number; ?>">
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
                                                    <?php
                                          $doc_number = htmlspecialchars($_GET['id']);
                           
                                          $sql = "SELECT * FROM `ework_sales_order` where docnumber = '$new_doc_number' ORDER BY linenumber DESC";
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
                                                        <td><?php echo $value['linenumber']; ?></td>
                                                        <td><input type="text" name="StepNumber"
                                                                id="lg_StepNumber_<?php echo $value['idlines']; ?>"
                                                                class="form-control"
                                                                value="<?php echo $value['StepNumber']; ?>"
                                                                required="required"></td>
                                                        <td>
                                                            <select name="Process"
                                                                id="lg_Process_<?php echo $value['idlines']; ?>"
                                                                class="form-select" required="required">
                                                                <option value="">Select</option>
                                                                <option value="Quality"
                                                                    <?php if($value['Process']=='Quality'){echo "selected";} ?>>
                                                                    Quality</option>
                                                                <option value="Sewing"
                                                                    <?php if($value['Process']=='Sewing'){echo "selected";} ?>>
                                                                    Sewing</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <textarea name="Description_StepName"
                                                                id="lg_Description_StepName_<?php echo $value['idlines']; ?>"
                                                                class="form-control" required="required"
                                                                spellcheck="false"><?php echo $value['Description_StepName']; ?></textarea>
                                                        </td>
                                                        <td>
                                                            <select name="Machine"
                                                                id="lg_Machine_<?php echo $value['idlines']; ?>"
                                                                class="form-select">
                                                                <option value="">Select</option>
                                                                <option value="BA"
                                                                    <?php if($value['Machine']=='BA'){echo "selected";} ?>>
                                                                    Button Attach</option>
                                                                <option value="BH"
                                                                    <?php if($value['Machine']=='BH'){echo "selected";} ?>>
                                                                    Button Hole</option>
                                                                <option value="FL"
                                                                    <?php if($value['Machine']=='FL'){echo "selected";} ?>>
                                                                    Flatlock</option>
                                                                <option value="FUSING"
                                                                    <?php if($value['Machine']=='FUSING'){echo "selected";} ?>>
                                                                    Fusing</option>
                                                                <option value="KNS"
                                                                    <?php if($value['Machine']=='KNS'){echo "selected";} ?>>
                                                                    Kansai</option>
                                                                <option value="MAN"
                                                                    <?php if($value['Machine']=='MAN'){echo "selected";} ?>>
                                                                    Manual</option>
                                                                <option value="OL"
                                                                    <?php if($value['Machine']=='OL'){echo "selected";} ?>>
                                                                    Overlock</option>
                                                                <option value="PM"
                                                                    <?php if($value['Machine']=='PM'){echo "selected";} ?>>
                                                                    Plain</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="text" name="StepTimeMins"
                                                                id="lg_StepTimeMins_<?php echo $value['idlines']; ?>"
                                                                class="form-control"
                                                                value="<?php echo $value['StepTimeMins']; ?>"></td>
                                                        <td><input type="text" name="NextStep"
                                                                id="lg_NextStep_<?php echo $value['idlines']; ?>"
                                                                class="form-control"
                                                                value="<?php echo $value['NextStep']; ?>"></td>
                                                        <td>
                                                            <select name="FirstStep"
                                                                id="lg_FirstStep_<?php echo $value['idlines']; ?>"
                                                                class="form-select">
                                                                <option value="">Select</option>
                                                                <option value="0"
                                                                    <?php if($value['FirstStep']=='0'){echo "selected";} ?>>
                                                                    No</option>
                                                                <option value="1"
                                                                    <?php if($value['FirstStep']=='1'){echo "selected";} ?>>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="LastStep"
                                                                id="lg_LastStep_<?php echo $value['idlines']; ?>"
                                                                class="form-select">
                                                                <option value="">Select</option>
                                                                <option value="0"
                                                                    <?php if($value['LastStep']=='0'){echo "selected";} ?>>
                                                                    No</option>
                                                                <option value="1"
                                                                    <?php if($value['LastStep']=='1'){echo "selected";} ?>>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="ColorSizeEntry"
                                                                id="lg_ColorSizeEntry_<?php echo $value['idlines']; ?>"
                                                                class="form-select">
                                                                <option value="">Select</option>
                                                                <option value="0"
                                                                    <?php if($value['ColorSizeEntry']=='0'){echo "selected";} ?>>
                                                                    No</option>
                                                                <option value="1"
                                                                    <?php if($value['ColorSizeEntry']=='1'){echo "selected";} ?>>
                                                                    Yes</option>
                                                            </select>
                                                        </td>
                                                        <td>

                                                            <button type="button" class="btn btn-outline-warning btn-sm"
                                                                onclick="updateCartItem('<?php echo $value['idlines']; ?>')">Update
                                                            </button>
                                                            <button type="button" class="btn btn-outline-danger btn-sm"
                                                                onclick="confirmDelete('<?php echo $value['idlines']; ?>')">Delete
                                                            </button>

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
                        <button type="button" class="btn btn-primary" onclick="saveChanges()">Save changes</button>
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
        var docnumberValue = document.getElementById("docnumber").value;

        // Check if all required fields are filled
        if (!lg_StepNumberValue || !lg_ProcessValue || !lg_Description_StepNameValue || !lg_MachineValue || !
            lg_StepTimeMinsValue || !lg_NextStepValue || !lg_FirstStepValue || !lg_LastStepValue || !
            lg_ColorSizeEntryValue
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
            docnumber: docnumberValue,
            type: 'addline'
        };

        // Push the cartItem into the cartItems array
        cartItems.push(cartItem);
        var saveData = $.ajax({
            type: 'POST',
            url: "work_order_edit_store.php",
            data: {
                cartItems: cartItems
            },
            dataType: "text",
            success: function(data) {
                alert("Line Successfully Inserted");
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
            }
        });

    }

    // Function to make the AJAX request
    function sendFormDataToServer() {

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
        var docnumberValue = document.getElementById("docnumber").value;

        // Check if all required fields are filled
        if (!WorkOrderValue || !siteValue || !buildingValue || !floorValue || !
            lineValue || !quantityValue || !SalesOrderValue || !CustomerValue || !StyleValue
        ) {
            alert("Please fill in all required fields");
            return;
        }

        // Create a cartItem object
        var cartItem = {
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
            docnumber: docnumberValue,
            type: 'updateheader'
        };

        // Push the cartItem into the cartItems array
        cartItems.push(cartItem);
        var saveData = $.ajax({
            type: 'POST',
            url: "work_order_edit_store.php",
            data: {
                cartItems: cartItems
            },
            dataType: "text",
            success: function(data) {
                alert("Header Successfully Updated");
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
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

    function updateCartItem(idlines) {
        // Fetch other necessary data
        var updatedItem = {

            lg_StepNumber: document.getElementById('lg_StepNumber_' + idlines).value,
            lg_Process: document.getElementById('lg_Process_' + idlines).value,
            lg_Description_StepName: document.getElementById('lg_Description_StepName_' + idlines).value,
            lg_Machine: document.getElementById('lg_Machine_' + idlines).value,
            lg_StepTimeMins: document.getElementById('lg_StepTimeMins_' + idlines).value,
            lg_NextStep: document.getElementById('lg_NextStep_' + idlines).value,
            lg_FirstStep: document.getElementById('lg_FirstStep_' + idlines).value,
            lg_LastStep: document.getElementById('lg_LastStep_' + idlines).value,
            lg_ColorSizeEntry: document.getElementById('lg_ColorSizeEntry_' + idlines).value,

            idlines: idlines,
            type: 'edit'
            // Add other properties as needed
        };


        // Check if all required fields are filled
        if (!lg_StepNumber || !lg_Process || !lg_Description_StepName || !lg_Machine || !lg_StepTimeMins || !
            lg_NextStep || !lg_FirstStep || !lg_LastStep || !lg_ColorSizeEntry) {
            alert("Please fill in all required fields");
            return;
        }
        cartItems.push(updatedItem);
        var saveData = $.ajax({
            type: 'POST',
            url: "work_order_edit_store.php",
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

        cartItems.push(updatedItem);
        var saveData = $.ajax({
            type: 'POST',
            url: "work_order_edit_store.php",
            data: {
                cartItems: cartItems
            }, // Send an object with a property named "cartItems" containing the array
            dataType: "text",
            success: function(data) {

                alert("Delete Successfully Done");
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