<?php
include_once 'connectdb.php';
session_start();
if($_SESSION['useremail']==""){

  header('location:../index.php');
  
  }

if($_SESSION['role']=="Admin"){
    include_once'header.php';
}


$id = $_GET['id'];

$select = $pdo->prepare("select * from tbl_maintenance JOIN tbl_tools
ON tbl_maintenance.barcode = tbl_tools.barcode where mid = $id");

$select->execute();

$row=$select->fetch(PDO::FETCH_ASSOC);

$barcode_db=$row['barcode'];
$toolsname_db=$row['tools_name'];
$status_db=$row['status'];
$problem_db=$row['problem'];
$date_db=$row['date_report'];
$dater_db=$row['date_released'];

if(isset($_POST['btneditproduct'])){


  $problem = $_POST['txtproblem'];
  $status = $_POST['txtstatus'];
  $date_report= $_POST['txtdate_report'];
  $solution =$_POST['txtsolution'];
  $date_released =$_POST['txtdate_released'];


  $stmt = $pdo->prepare("UPDATE tbl_tools SET status = :status , available_quantity='1'  WHERE barcode = :id");
  $stmt->bindParam(':id', $barcode_db, PDO::PARAM_STR);
  $stmt->bindParam(':status', $status, PDO::PARAM_STR);
  $stmt->execute();

  $statement = $pdo->prepare("UPDATE tbl_maintenance SET solution = :solution , date_released =:dr WHERE mid = :id");
  $statement->bindParam(':id', $id, PDO::PARAM_STR);
  $statement->bindParam(':solution', $solution, PDO::PARAM_STR);
  $statement->bindParam(':dr', $date_released, PDO::PARAM_STR);


  if($statement->execute()){
      $_SESSION['status']="Report Close Successfully";
      $_SESSION['status_code']="success";
  }else{
      $_SESSION['status']="Tool Inserted Failed";
      $_SESSION['status_code']="error";

  }

}

$select = $pdo->prepare("select * from tbl_maintenance JOIN tbl_tools
ON tbl_maintenance.barcode = tbl_tools.barcode where mid = $id");

$select->execute();

$row=$select->fetch(PDO::FETCH_ASSOC);


$barcode_db=$row['barcode'];
$toolsname_db=$row['tools_name'];
$status_db=$row['status'];
$problem_db=$row['problem'];
$solution_db=$row['solution'];
$date_db=$row['date_report'];
$dater_db=$row['date_released'];


?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <!-- <h1 class="m-0">Admin Dashboard</h1> -->
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Starter Page</li> -->
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
        <div class="col-lg-12">
        

        <div class="card card-success card-outline">
            <div class="card-header">
              <h5 class="m-0">Update Tool Maintenance Report</h5>
            </div>

            <form action="" method="post" name="formeditproduct" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label >Barcode</label>
                            <input type="text" class="form-control" value="<?php echo $barcode_db;?>" placeholder="Enter Barcode" name="txtbarcode" autocomplete="off" disabled>
                        </div>

                        <div class="form-group">
                            <label >Tool Name</label>
                            <input type="text" class="form-control" value="<?php echo $toolsname_db;?>" placeholder="Enter Name" name="txttooltname" autocomplete="off" readonly>
                        </div>

                        <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="txtstatus" required>
                                    <option value="" disabled selected>Select Category</option>
                         
                                        <?php
                                        $select=$pdo->prepare("select * from tbl_status order by sid desc");
                                        $select->execute();

                                        while($row=$select->fetch(PDO::FETCH_ASSOC))
                                        {
                                        extract($row);

                                        ?>
                                        <option <?php if($row['status']==$status_db ){ ?>
                                            
                                            selected="selected"
                                            
                                            
                                            <?php }?>  ><?php echo $row['status'];?></option>

                                        <?php

                                        }

                                        ?>
                
                                </select>
                            </div>

                        <div class="form-group">
                            <label>Problem</label>
                            <textarea class="form-control" placeholder="Enter Description" name="txtproblem" rows="4" readonly><?php echo $problem_db;?> </textarea>
                        </div>


                    </div>
                    <div class="col-md-6">

                      <div class="form-group">


                          <label>Date</label>
                            <div class="input-group date" data-target-input="nearest">
                                  <input type="date" class="form-control datetimepicker-input"   value="<?php echo $date_db;?>" placeholder="Date" name="txtdate_report" readonly>
                            </div>
                        </div>
                        
                        <div class="form-group">
                          <label>Date Released</label>
                            <div class="input-group date" data-target-input="nearest">
                                  <input type="date" class="form-control datetimepicker-input" value="<?php echo $dater_db;?>" placeholder="Date" name="txtdate_released" require>
                            </div>
                        </div>

                        
                      <div class="form-group">
                            <label>Remark</label>
                            <textarea class="form-control" placeholder="Enter Description" name="txtsolution" rows="4" required><?php echo $solution_db;?> </textarea>
                        </div>
                    </div>
                                    
                    </div>

                </div>

                <div class="card-footer">
                    <div class="text-center">
                        <button type="submit" class="btn btn-success" name="btneditproduct">Close Report</button>
                    </div>
                </div>
                                
            </form>

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
<?php
  if(isset($_SESSION['status']) && $_SESSION['status']!=''){
?>
<script>
     Swal.fire({
        icon: '<?php echo $_SESSION['status_code'];?>',
        title: '<?php echo $_SESSION['status'];?>'
      });

</script>
<?php
unset($_SESSION['status']);
  }
?>