<?php
include_once 'connectdb.php';
session_start();
if($_SESSION['useremail']==""  OR $_SESSION['role']=="User"){

  header('location:../index.php');
  
  }

if($_SESSION['role']=="Admin"){
    include_once'header.php';
}


$id = $_GET['id'];

$select = $pdo->prepare("select * from tbl_employee where employee_id=$id");
$select->execute();

$row=$select->fetch(PDO::FETCH_ASSOC);

$id_db=$row['employee_id'];
$empname_db=$row['employee_name'];
$empemail_db=$row['employee_email'];
$p_db=$row['phone'];
$emprole_db=$row['employee_role'];
$dept_db=$row['department'];


if(isset($_POST['btneditemp'])){

    $employee_id= $_POST['txtid'];
    $employee_name = $_POST['txtname'];
    $employee_email = $_POST['txtemail'];
    $phone = $_POST['txtphone'];
    $employee_role = $_POST['txtrole'];
    $department = $_POST['txtdept'];

                
    $update=$pdo->prepare("update tbl_employee set employee_name=:name, employee_email=:email ,phone=:phone,employee_role=:role,
    department=:dept where employee_id=$id");
        
   
    $update->bindParam(':name',$employee_name);
    $update->bindParam(':email',$employee_email);
    $update->bindParam(':phone',$phone);
    $update->bindParam(':role',$employee_role);
    $update->bindParam(':dept',$department);

    if($update->execute()){
      $_SESSION['status']="Insert successfully the user into the database";
      $_SESSION['status_code']="success";
                    
    }else{
        
      $_SESSION['status']="Error inserting the user into the database";
      $_SESSION['status_code']="error";
                    
    }
                
}
$id = $_GET['id'];

$select = $pdo->prepare("select * from tbl_employee where employee_id=$id");
$select->execute();

$row=$select->fetch(PDO::FETCH_ASSOC);

$id_db=$row['employee_id'];
$empname_db=$row['employee_name'];
$empemail_db=$row['employee_email'];
$p_db=$row['phone'];
$emprole_db=$row['employee_role'];
$dept_db=$row['department'];

?>
<script>
    function validatePhoneNumber() {
      var phoneNumber = document.getElementById("phoneInput").value;
      var phoneNumberPattern = /^01[0-46-9]-\d{7,8}$/; // Regular expression for Malaysia phone number format
      
      if (!phoneNumberPattern.test(phoneNumber)) {
        alert("Please enter a valid Malaysia phone number in the format 01X-XXXXXXX or 01X-XXXXXXXX.");
        return false;
      }
      
      // Further processing or submission can be done here
      
      return true;
    }
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
           <h2 class="m-0">Edit Employee Profile</h2>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
            <li class="breadcrumb-item active"><a href="E_list_of_employee.php">List of Employee</a></li> 
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
              <h5 class="m-0">Edit Profile : </h5>
            </div>

            <form action="" method="post" name="formeditproduct" onsubmit="return validatePhoneNumber()" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="row">
                        <div class="col-md-6">
                
                            <div class="form-group">
                                <label for="exampleInputEmail1">ID</label>
                                <input type="text" class="form-control" value="<?php echo $id_db;?>" placeholder="Enter ID" name="txtid" autocomplete="off" required readonly>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" class="form-control" value="<?php echo $empname_db;?>" placeholder="Enter ID" name="txtname" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" class="form-control" value="<?php echo $empemail_db;?>" placeholder="Enter ID" name="txtemail" autocomplete="off" required>
                            </div>

                            
                            <div class="form-group">
                                <label for="examplePhoneNumber">Phone</label>
                                <input type="tel" class="form-control"  value="<?php echo $p_db;?>"  id="phoneInput" pattern="01[0-46-9]-\d{7,8}"  name="txtphone" maxlength="12" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Department</label>
                                <select class="form-control" name="txtdept" required>
                                    <option value="" disabled selected>Select Category</option>
                         
                                        <?php
                                        $select=$pdo->prepare("select * from tbl_department order by dept_id asc");
                                        $select->execute();

                                        while($row=$select->fetch(PDO::FETCH_ASSOC))
                                        {
                                        extract($row);

                                        ?>
                                        <option <?php if($row['department']==$dept_db  ){ ?>
                                            
                                            selected="selected"
                                            
                                            <?php }?>  ><?php echo $row['department'];?></option>

                                        <?php

                                        }

                                        ?>
                
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Role</label>
                                <select class="form-control" name="txtrole" required>
                                    <option value="" disabled selected>Select Category</option>
                         
                                        <?php
                                        $select=$pdo->prepare("select * from tbl_job order by job_id asc");
                                        $select->execute();

                                        while($row=$select->fetch(PDO::FETCH_ASSOC))
                                        {
                                        extract($row);

                                        ?>
                                        <option <?php if($row['role']==$emprole_db  ){ ?>
                                            
                                            selected="selected"
                                            
                                            <?php }?>  ><?php echo $row['role'];?></option>

                                        <?php

                                        }

                                        ?>
                
                                </select>
                            </div>

                        </div>         
                    </div>

                </div>

                <div class="card-footer">
                    <div class="text-center">
                        <button type="submit" class="btn btn-success" name="btneditemp">Update Profile</button>
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