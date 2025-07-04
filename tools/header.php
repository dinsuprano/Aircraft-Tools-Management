<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aircraft Tools Management</title>
  <link rel="icon" href="../dist/img/AdminLTELogo.png" type="image/ico">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">


 <!-- iCheck for checkboxes and radio inputs -->
 <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">

<!-- Select2 -->
<link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">


  

  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">


 <!-- SweetAlert2 -->
 <link rel="stylesheet" href="../plugins/sweetalert2/sweetalert2.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
<style type="text/css">
    #b{
      background-color: #dfe4ea;
    }
  </style>
  <!-- Navbar -->
  <nav id = "b" class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="dashboard.php" class="nav-link">Home</a>
      </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
     <!-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>-->
    </ul>
  </nav>
  <!-- /.navbar -->
  <style type="text/css">
    #a{
      background-color: #1f2d3d;
    }
  </style>
  <!-- Main Sidebar Container -->
  <aside id="a" class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link">
      <img src="../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Tools Management</span>
      
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        
        <div class="image">
          <img src="../dist/img/admin.png" class="rounded" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION["username"]?></a>
        </div>
      </div>

      <!-- SidebarSearch Form 
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>-->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu">
            <a href="#" class="nav-link">
              <i class="nav-icon fab fa-dashcube"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
      
              <li class="nav-item">
                <a href="registration.php" class="nav-link active">
                <i class="nav-icon fas fa-registered"></i>
                  <p>Admin Registration</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="changepassword.php" class="nav-link active">
                <i class="nav-icon fas fa-user-lock"></i>
                  <p>Update Password</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="logout.php" class="nav-link active">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                  <p>Logout</p>
          
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
                <a href="E_list_of_employee.php" class="nav-link">
                <i class="nav-icon fa fa-users"></i>
                  <p>Employee Profile</p>
                </a>
          </li>
          <li class="nav-item menu-open">
            <a href="#" class="nav-link ">
              <i class="nav-icon fab fa-dashcube"></i>
              <p>
                Inventory Information
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="T_addtool.php" class="nav-link">
                <i class="nav-icon fa fa-plus-circle"></i>
                  <p>Add Tool</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="T_listoftool.php" class="nav-link">
                <i class="nav-icon fas fa-laptop"></i>
                  <p>Tool Inventory</p>
          
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="C_Check.php" class="nav-link">
            <i class="nav-icon fa fa-qrcode"></i>
              <p>
                 Check In / Check Out
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="R_toolsusage.php" class="nav-link">
            <i class="nav-icon fa fa-edit"></i>
              <p>
                 Tools Usage Report
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="M_maintenance.php" class="nav-link">
              <i class="nav-icon fa fa-wrench"></i>
              <p>
                 Tools Maintenance
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
