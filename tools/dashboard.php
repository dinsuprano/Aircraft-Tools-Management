<?php
include_once 'connectdb.php';
session_start();


if($_SESSION['useremail']==""){

header('location:../index.php');

}
include_once "header.php";

//Count the number of tool
$select =$pdo->prepare("select count(tools_name) as toolname from tbl_tools");
$select->execute();

$row=$select->fetch(PDO::FETCH_OBJ);

$total_tools=$row->toolname;


//Count the number of employees
$select =$pdo->prepare("select count(employee_id) as emp_id from tbl_employee");
$select->execute();

$row=$select->fetch(PDO::FETCH_OBJ);

$total_emp=$row->emp_id;


//Count the number of maintenance records
$select =$pdo->prepare("select count(status) as record from tbl_tools where status='Maintenance'");
$select->execute();

$row=$select->fetch(PDO::FETCH_OBJ);

$total_maintenance=$row->record;

//Count the number of tools usages
$select =$pdo->prepare("select count(barcode) as usages from tbl_borrow_tools");
$select->execute();

$row=$select->fetch(PDO::FETCH_OBJ);

$total_usage=$row->usages;

//Count the number of tools that not been returned
$select =$pdo->prepare("select count(status_) as not_ret from tbl_borrow_tools where status_='Not Returned' ");
$select->execute();

$row=$select->fetch(PDO::FETCH_OBJ);

$total_not=$row->not_ret;


?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Aircraft Tools Management Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active"><a href="frame.php">Frame</a></li> 
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
         
          <!-- /.col-md-6 -->
            <div class="col-md-12">
 
            <!-- Dashboard Menu -->   
            <div class="row">
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><?php echo $total_tools;?></h3>
                    <p>TOTAL TOOL</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  <a href="T_listoftool.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3><?php echo $total_emp; ?></h3>
                    <p>TOTAL EMPLOYEE</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  <a href="E_list_of_employee.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3><?php echo $total_maintenance;?></h3>

                    <p>TOOLS IN MAINTENANCE</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person-add"></i>
                  </div>
                  <a href="M_maintenance.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3><?php echo $total_not;?></h3>

                    <p>TOTAL OF NOT RETURN TOOLS</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person-add"></i>
                  </div>
                  <a href="R_toolsusage.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>

              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-purple">
                  <div class="inner">
                    <h3><?php echo $total_usage;?></h3>

                    <p>TOTAL USAGE OF TOOLS</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person-add"></i>
                  </div>
                  <a href="R_toolsusage.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            
            </div>
          </div>
          
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
include_once "footer.php";
?>


