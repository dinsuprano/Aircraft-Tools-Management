<?php

include_once 'connectdb.php';
session_start();


if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){

  header('location:../index.php');
  
}
if($_SESSION['role']=="Admin" ){
    include_once "header.php";
}
error_reporting(0);

$id=$_GET['id'];

if(isset($id)){
     $delete=$pdo->prepare("delete from tbl_employee where employee_id =".$id);

    if($delete->execute()){
        $_SESSION['status']="Account deleted successfully";
        $_SESSION['status_code']="success";

    }else{
        $_SESSION['status']="Account Is Not Deleted";
        $_SESSION['status_code']="warning";
    }

}

if(isset($_POST['btnsave'])){

    $employee_id= $_POST['txtid'];
    $employee_name = $_POST['txtname'];
    $employee_email = $_POST['txtemail'];
    $employee_role= $_POST['txtselect_option'];

    if(isset($_POST['txtemail'])){

        $select=$pdo->prepare("select employee_email from tbl_employee where employee_email='$employee_email'");

        $select->execute();

        if($select->rowCount()>0){

        $_SESSION['status']="Email already exists. Create Account From New Email";
        $_SESSION['status_code']="warning";

        }
        else{

            if(isset($_POST['txtid'])){
                $select=$pdo->prepare("select employee_id from tbl_employee where employee_id='$employee_id'");

                $select->execute();
        
                if($select->rowCount()>0){
        
                $_SESSION['status']="ID already exists. Enter new ID";
                $_SESSION['status_code']="warning";
        
                }
                else{
                    $insert=$pdo->prepare("insert into tbl_employee (employee_id,employee_name,employee_email,employee_role) 
                    values(:eeid,:name,:email,:role)");
        
                    $insert->bindParam(':eeid',$employee_id);
                    $insert->bindParam(':name',$employee_name);
                    $insert->bindParam(':email',$employee_email);
                    $insert->bindParam(':role',$employee_role);
                    
                    if($insert->execute()){
                    $_SESSION['status']="Insert successfully the user into the database";
                    $_SESSION['status_code']="success";
                    
                    }else{
        
                    $_SESSION['status']="Error inserting the user into the database";
                    $_SESSION['status_code']="error";
                    
                    }
                }
            }

       

        }

    }
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Employee Menu</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="list_of_employee.php">Home</a></li>
                <li class="breadcrumb-item active">Starter Page</li>
            </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
            <div class="container-fluid">
            
                <div class="card card-primary card-outline">
                    <div class="card-header">
                    <h5 class="m-0">Employee Details</h5>
                 
                    </div>
                    <div class="card-body">

        <div class="row">
                <div class="col-md-4">
                <form action="" method="post">

                    <div class="form-group">
                        <label for="exampleInputEmail1">ID</label>
                        <input type="text" class="form-control" placeholder="Enter ID" name="txtid" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" placeholder="Enter Name" name="txtname" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" class="form-control"  placeholder="Enter email" name="txtemail" required>
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <select class="form-control" name="txtselect_option" required>
                            <option value="" disabled selected>Select Role</option>
                            <option>Head Engineer</option>  
                            <option>Head Technician</option>  
                            <option>Technician</option>      
                            <option>Engineer</option>  
                            <option>Junior Technician</option>  
                        </select>
                    </div>
           
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" name="btnsave">Save</button>
                    </div>
                </form>
                </div>

                    <div class="col-md-8">

                    <table class="table table-striped table-hover ">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Name</td>
                                <td>Email</td>
                                <td>Role</td> 
                                <td>Delete</td>   
                            </tr>
                        </thead>
                    <tbody>

                    <?php
                        $select = $pdo->prepare("select * from tbl_employee order by employee_id ASC");
                        $select->execute();

                        while($row=$select->fetch(PDO::FETCH_OBJ))
                        {
                        echo'
                        <tr>
                        <td>'.$row->employee_id.'</td>
                        <td>'.$row->employee_name.'</td>
                        <td>'.$row->employee_email.'</td>
                        <td>'.$row->employee_role.'</td>
                        <td>
                        <a href="employee.php?id='.$row->employee_id.'" class="btn btn-danger"><i class="fa fa-trash-alt"></i></a>
                        </td>

                        </tr>';

                        }
                    ?>
                    </tbody>

                    </table>
                    </div>

                    </div>
                </div>
            </div>
            
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include_once "footer.php";
?>
<?php
  if(isset($_SESSION['status']) && $_SESSION['status']!='')
 
  {
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