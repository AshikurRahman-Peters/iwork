<?php
   session_start();
   if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit;
   }
   include 'header.php';
   $doc_number = htmlspecialchars($_GET['id']);

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

                        <div class=" col-md-12">

                            <form method="post" action="worker_assignment_store.php" enctype="multipart/form-data">
                                <label>Image:</label>
                                <input type="file" name="image" accept="image/*" id="fileInput" required>
                                <input type="hidden" name="docnumber" value="<?php echo $doc_number;?>" id="docnumber"
                                    required>
                                <br>
                                <input type="button" onclick="uploadFile()" class="btn btn-outline-success"
                                    value="Upload">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    function uploadFile() {
        var fileInput = document.getElementById('fileInput');
        var docnumber = document.getElementById('docnumber');
        var file = fileInput.files[0];
        var docNumberValue = docnumber.value;

        if (file) {
            var formData = new FormData();
            formData.append('image', file);
            formData.append('docnumber', docNumberValue); // Use the correct variable here

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'worker_assignment_store.php', true);

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert("Save Complete");
                    window.location.reload();
                }
            };

            xhr.send(formData);
        } else {
            alert('Please select a file.');
        }
    }
    </script>

    <!-- Main Footer -->
    <?php include('footer.php'); ?>