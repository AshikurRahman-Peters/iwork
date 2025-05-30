<?php
   session_start();
   if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit;
   }
   ?>
<?php 
   include 'header.php'; 
   $query = "SELECT * FROM ework_target_efficiency";
   $result = $conn->query($query);
   $query_SewingLine = "SELECT * FROM ework_mrd_library WHERE LibraryName='SewingLine'";
   $result_SewingLine = $conn->query($query_SewingLine);
   ?>
<?php
   // Check if the form is submitted
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
       $date1 = $_POST['Date'];
   // Convert the date to MySQL date format using PHP
   $mysqlDate = date('Y-m-d', strtotime($date1));
   
   // Check connection
   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   }
   
   $query_check = "SELECT * FROM ework_target_efficiency WHERE DATE(`Date`) = '$mysqlDate' AND `WorkOrder` = '{$_POST['WorkOrder']}' AND `Style` = '{$_POST['Style']}' AND `SewingLine` = '{$_POST['SewingLine']}'";
   $result_check = $conn->query($query_check);
   
   if ($result_check->num_rows > 0) {
       // JavaScript alert for existing record
       echo '<script>alert("Record already exists");</script>';
       // Redirect to all_workers.php after displaying the alert
       echo '<script>window.location.href = "all_daily_line_info.php";</script>';
       exit();
   }
   
   // Fetch values from the form
   $Date = $_POST['Date'];
   $SewingLine = $_POST['SewingLine'];
   $WorkingHour = $_POST['WorkingHour'];
   $TargetEfficiency = $_POST['TargetEfficiency'];
   $WorkOrder = $_POST['WorkOrder'];
   $Style = $_POST['Style'];
   $actualworkinghour = $_POST['actualworkinghour'];
   
   // SQL query to insert data into the table
   $sql = "INSERT INTO `ework_target_efficiency`(`ID`, `Date`, `WorkingHour`, `TargetEfficiency`, `SewingLine`, `WorkOrder`, `Style`, `actualworkinghour`)
           VALUES ('','$Date','$WorkingHour', '$TargetEfficiency', '$SewingLine', '$WorkOrder', '$Style', '$actualworkinghour')";
   
   if ($conn->query($sql) === TRUE) {
       // JavaScript alert for successful record creation
       echo '<script>alert("New record created successfully");</script>';
       // Redirect to all_workers.php after displaying the alert
       echo '<script>window.location.href = "all_daily_line_info.php";</script>';
   } else {
       echo "Error: " . $sql . "<br>" . $conn->error;
   }
   
   // Close the database connection
   $conn->close();
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
                     <!-- <div id="formLineslegend" class="mt-2">Line Information</div> -->
                     <div class="mb-1">
                        <button type="button" class="btn btn-outline-primary newLine me-2" data-bs-toggle="modal"
                           data-bs-target="#myModal">New</button>
                     </div>
                     <div class="clearfix"></div>
                     <div id="leftFormLines">
                        <div id="formLines">
                           <div id="fieldset_lineinformation">
                              <table class="table table-bordered" id="example">
                                 <thead>
                                    <tr>
                                       <th class="linenumber">Date</th>
                                       <th class="linenumber">Sewing Line</th>
                                       <th class="linenumber">Working Hour</th>
                                       <th class="linenumber">Target Efficiency</th>
                                       <th class="linenumber">WorkOrder</th>
                                       <th class="linenumber">Style</th>
                                       <th class="linenumber">Actual Working Hour</th>
                                       <th>Actions</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                       foreach ($result as $key => $value) {
                                          
                                       ?>
                                    <tr data-id="1" class="valid new">
                                       <td>
                                          <div class="btn-group" role="group">
                                             <?php echo date('Y-m-d', strtotime($value['Date'])); ?>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="btn-group" role="group">
                                             <?php echo $value['SewingLine'] ?>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="btn-group" role="group">
                                             <?php echo $value['WorkingHour'] ?>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="btn-group" role="group">
                                             <?php echo $value['TargetEfficiency'] ?>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="btn-group" role="group">
                                             <?php echo $value['WorkOrder'] ?>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="btn-group" role="group">
                                             <?php echo $value['Style'] ?>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="btn-group" role="group">
                                             <?php echo $value['actualworkinghour'] ?>
                                          </div>
                                       </td>
                                       <td>
                                          <div class="btn-group" role="group">
                                             <button type="button" class="btn btn-outline-primary btn-sm editLine" 
                                                data-Date="<?php echo $value['Date']; ?>"
                                                data-SewingLine="<?php echo $value['SewingLine']; ?>"
                                                data-WorkingHour="<?php echo $value['WorkingHour']; ?>"
                                                data-TargetEfficiency="<?php echo $value['TargetEfficiency']; ?>"
                                                data-WorkOrder="<?php echo $value['WorkOrder']; ?>"
                                                data-Style="<?php echo $value['Style']; ?>"
                                                data-actualworkinghour="<?php echo $value['actualworkinghour']; ?>"
                                                data-id="<?php echo $value['ID']; ?>">
                                             Edit
                                             </button>
                                             <button type="button" class="btn btn-outline-primary btn-sm deleteLine"
                                                data-id="<?php echo $value['ID']; ?>">
                                             Delete
                                             </button>
                                          </div>
                                       </td>
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
                  <form method="post" action="edit_daily_line_info.php">
                     <div class="modal" id="myModaledit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog  modal-xl">
                           <div class="modal-content">
                              <!-- Modal Header -->
                              <div class="modal-header">
                                 <h4 class="modal-title">Daily Line Information</h4>
                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <!-- Modal Body -->
                              <div class="modal-body">
                                 <!-- Your form content goes here -->
                                 <div id="rightFormLines">
                                    <div id="rightFormLines">
                                       <div id="dragbar"></div>
                                       <fieldset id="fieldset_linegroup1" class="border p-3">
                                          <!-- <legend class="fs-5">Worker</legend> -->
                                          <div class="row">
                                             <div class="col-md-4 mb-3">
                                                <label for="Date" class="form-label">Date*</label>
                                                <input type="datetime-local" name="Date" id="Date" class="form-control" value="" required="">
                                             </div>
                                             <input type="hidden" name="id" id="id" class="form-control" value="">
                                             <div class="col-md-4 mb-3">
                                                <label for="SewingLine" class="form-label">Sewing Line*</label>
                                                <select name="SewingLine" id="SewingLine" class="form-select"
                                                   required="required">
                                                   <option value="">Select</option>
                                                   <?php
                                                      foreach ($result_SewingLine as $key => $SewingLine) {
                                                      ?>
                                                   <option value="<?php echo $SewingLine['Code']; ?>"><?php echo $SewingLine['Code']; ?></option>
                                                   <?php } ?>
                                                </select>
                                             </div>
                                             <div class="col-md-4 mb-3">
                                                <label for="WorkingHour" class="form-label">Target Working Hour*</label>
                                                <input type="text" name="WorkingHour" id="WorkingHour" class="form-control" value="" required="">
                                             </div>
                                             <div class="col-md-4 mb-3">
                                                <label for="TargetEfficiency" class="form-label">Target Efficiency*</label>
                                                <input type="text" name="TargetEfficiency" id="TargetEfficiency" class="form-control" value="" required="">
                                             </div>
                                             <div class="col-md-4 mb-3">
                                                <label for="WorkOrder" class="form-label">Work Order*</label>
                                                <input type="text" name="WorkOrder" id="WorkOrder" class="form-control" value="">
                                             </div>
                                             <div class="col-md-4 mb-3">
                                                <label for="Style" class="form-label">Style*</label>
                                                <input type="text" name="Style" id="Style" class="form-control" value="" required="">
                                             </div>
                                             <div class="col-md-4 mb-3">
                                                <label for="actualworkinghour" class="form-label">Actual Working Hour*</label>
                                                <input type="number" name="actualworkinghour" id="actualworkinghour" class="form-control" value="" required="">
                                             </div>
                                          </div>
                                       </fieldset>
                                    </div>
                                 </div>
                              </div>
                              <!-- Modal Footer -->
                              <div class="modal-footer">
                                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                 <button type="Submit" class="btn btn-outline-primary">Update</button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </form>
                  <form method="post" action="">
                     <div class="modal" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog  modal-xl">
                           <div class="modal-content">
                              <!-- Modal Header -->
                              <div class="modal-header">
                                 <h4 class="modal-title">Daily Line Information</h4>
                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <!-- Modal Body -->
                              <div class="modal-body">
                                 <!-- Your form content goes here -->
                                 <div id="rightFormLines">
                                    <div id="rightFormLines">
                                       <div id="dragbar"></div>
                                       <fieldset id="fieldset_linegroup1" class="border p-3">
                                          <!-- <legend class="fs-5">Worker</legend> -->
                                          <div class="row">
                                             <div class="col-md-4 mb-3">
                                                <label for="Date" class="form-label">Date*</label>
                                                <input type="datetime-local" name="Date" id="Date" class="form-control" value="" required="">
                                             </div>
                                             <div class="col-md-4 mb-3">
                                                <label for="SewingLine" class="form-label">Sewing Line*</label>
                                                <select name="SewingLine" id="SewingLine" class="form-select"
                                                   required="required">
                                                   <option value="">Select</option>
                                                   <?php
                                                      foreach ($result_SewingLine as $key => $SewingLine) {
                                                      ?>
                                                   <option value="<?php echo $SewingLine['Code']; ?>"><?php echo $SewingLine['Code']; ?></option>
                                                   <?php } ?>
                                                </select>
                                             </div>
                                             <div class="col-md-4 mb-3">
                                                <label for="WorkingHour" class="form-label">Target Working Hour*</label>
                                                <input type="text" name="WorkingHour" id="WorkingHour" class="form-control" value="" required="">
                                             </div>
                                             <div class="col-md-4 mb-3">
                                                <label for="TargetEfficiency" class="form-label">Target Efficiency*</label>
                                                <input type="text" name="TargetEfficiency" id="TargetEfficiency" class="form-control" value="" required="">
                                             </div>
                                             <div class="col-md-4 mb-3">
                                                <label for="WorkOrder" class="form-label">Work Order*</label>
                                                <input type="text" name="WorkOrder" id="WorkOrder" class="form-control" value="">
                                             </div>
                                             <div class="col-md-4 mb-3">
                                                <label for="Style" class="form-label">Style*</label>
                                                <input type="text" name="Style" id="Style" class="form-control" value="" required="">
                                             </div>
                                             <div class="col-md-4 mb-3">
                                                <label for="actualworkinghour" class="form-label">Actual Working Hour*</label>
                                                <input type="number" name="actualworkinghour" id="actualworkinghour" class="form-control" value="" required="">
                                             </div>
                                          </div>
                                       </fieldset>
                                    </div>
                                 </div>
                              </div>
                              <!-- Modal Footer -->
                              <div class="modal-footer">
                                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                 <button type="Submit" class="btn btn-outline-primary">Save changes</button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </form>
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
   <script>
      document.addEventListener('DOMContentLoaded', function() {
          var editButtons = document.querySelectorAll('.editLine');
      
          editButtons.forEach(function(button) {
              button.addEventListener('click', function() {
                  // Retrieve data attributes
                  var Date = button.getAttribute('data-Date');
                  var SewingLine = button.getAttribute('data-SewingLine');
                  var WorkingHour = button.getAttribute('data-WorkingHour');
                  var TargetEfficiency = button.getAttribute('data-TargetEfficiency');
                  var WorkOrder = button.getAttribute('data-WorkOrder');
                  var Style = button.getAttribute('data-Style');
                  var actualworkinghour = button.getAttribute('data-actualworkinghour');
                  var id = button.getAttribute('data-id');
      
                  // Populate the modal with the retrieved data
                  document.getElementById('Date').value = Date;
                  document.getElementById('SewingLine').value = SewingLine;
                  document.getElementById('WorkingHour').value = WorkingHour;
                  document.getElementById('TargetEfficiency').value = TargetEfficiency;
                  document.getElementById('WorkOrder').value = WorkOrder;
                  document.getElementById('Style').value = Style;
                  document.getElementById('actualworkinghour').value = actualworkinghour;
                  document.getElementById('id').value = id;
      
                  // Show the modal using Bootstrap's modal method
                  var myModaledit = new bootstrap.Modal(document.getElementById('myModaledit'));
                  myModaledit.show();
              });
          });
      });
   </script>
   <script>
      document.addEventListener('DOMContentLoaded', function () {
          var deleteButtons = document.querySelectorAll('.deleteLine');
      
          deleteButtons.forEach(function (button) {
              button.addEventListener('click', function () {
                  // Get the card number from the data attribute
                  var id = button.getAttribute('data-id');
      
                  // Display a confirmation dialog
                  var isConfirmed = confirm('Are you sure you want to delete?');
      
                  // If the user confirms, proceed with deletion
                  if (isConfirmed) {
                      // You can perform the deletion via AJAX or redirect to a delete script
                      // For simplicity, I'm using a placeholder URL here
                      var deleteUrl = 'delete_daily_line_info.php?id=' + id;
                      window.location.href = deleteUrl;
                  }
              });
          });
      });
   </script>
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
        $("#example").DataTable({
          "responsive": true, "lengthChange": false, "autoWidth": false,
          "buttons": ["csv", "excel"]
          // "buttons": ["copy", "csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
        
      });
   </script>
</body>
</html>