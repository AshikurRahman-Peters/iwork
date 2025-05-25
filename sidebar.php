<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="admin_dashboard.php" class="brand-link" style="text-decoration: none;">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">LDC Group</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <!-- <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
        </div>
        <div class="info">
          <a href="#" class="d-block" style="text-decoration: none;"><?php echo $_SESSION['username']; ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <!-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-network-wired"></i>
              <p>
                Worker & Work Order
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="work_order.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Work Order</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="work_order_list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Work Order List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="worker_assignment_list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Worker Assignment List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="color_size_list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Color & Size List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="parts_name_list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Parts Name List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="all_workers.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Workers</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="all_daily_line_info.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Daily Line Information</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-chart-pie"></i>
              <p>
                Reports
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="line_perfomance_report.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Line Performance Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="defect_details_report.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Defect Details Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="worker_skill_report.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Workers' Skill Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="step_wise_report.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Step-wise Report</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-crop-alt"></i>
              <p>
                Ework Operation
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="iwork/index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Operation</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="operation_list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Operation List</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Simple Link
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li> -->
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>