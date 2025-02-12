<?php
include_once 'connectdb.php';
session_start();

  if($_SESSION['role']=="Admin"){
    include_once'header.php';
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
      $phone= $_POST['txtphone'];
      $employee_role= $_POST['txtselect_option'];
      $department= $_POST['txtdept'];

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
                      $insert=$pdo->prepare("insert into tbl_employee (employee_id,employee_name,employee_email,phone,employee_role,department)  
                      values(:eeid,:name,:email,:phone,:role,:dept)");
          
                      $insert->bindParam(':eeid',$employee_id);
                      $insert->bindParam(':name',$employee_name);
                      $insert->bindParam(':email',$employee_email);
                      $insert->bindParam(':phone',$phone);
                      $insert->bindParam(':role',$employee_role);
                      $insert->bindParam(':dept',$department);


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
              <h1 class="m-0">Employee Menu</h1>
            </div><!-- /.col -->
            

        </div><!-- /.row -->
        <div class="col-sm-12">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                  Add Employee
              </button>
            </div><!-- /.col -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">

          <div class="card card-primary card-outline">
            <div class="card-header">
              <h5 class="m-0">Employee List :</h5>
            </div>

            
            <div class="card-body">

              <table class="table table-striped table-hover " id="table_emp">
                <thead>
                  <tr>
                    <td>Employee ID</td>
                    <td>Employee Name</td>
                    <td>Email</td>
                    <td>Phone</td>
                    <td>Department</td>
                    <td>Role</td>
                    <td>Action</td>
  
                  </tr>
                </thead>
                <tbody>

                  <?php

                  $select = $pdo->prepare("select * from tbl_employee order by employee_id ASC");
                  $select->execute();

                  while ($row = $select->fetch(PDO::FETCH_OBJ)) {

                    echo '
                        <tr>
                        <td>' . $row->employee_id . '</td>
                        <td>' . $row->employee_name . '</td>
                        <td>' . $row->employee_email . '</td>
                        <td>' . $row->phone . '</td>
                        <td>' . $row->department . '</td>
                        <td>' . $row->employee_role. '</td>
       
                        <td>

                            <div class="btn-group">
                                    
                            <a href="E_edit_employee.php?id=' . $row->employee_id . '" class="btn btn-success btn-xs" role="button"><span class="fa fa-edit" style="color:#ffffff" data-toggle="tooltip" title="Edit Employee"></span></a>

                            <a href="E_list_of_employee.php?id='.$row->employee_id.'" class="btn btn-danger btn-xs"><i class="fa fa-trash-alt"></i></a>

                            </div>

                        </td>

                        </tr>';
                                          }
                ?>

                </tbody>

              </table>

            </div>
          </div>

        </div>
        <!-- /.col-md-6 -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
<!---Modal -->
    <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Add Employee</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>


              <div class="modal-body">
              <form action="" method="post" onsubmit="return validatePhoneNumber()">

                    <div class="form-group">
                        <label for="exampleInputEmail1">ID</label>
                        <input type="text" class="form-control" placeholder="Enter ID" name="txtid" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" placeholder="Enter name" name="txtname" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" class="form-control"  placeholder="Enter email" name="txtemail" required>
                    </div>

                    <div class="form-group">
                        <label for="examplePhoneNumber">Phone</label>
                        <input type="tel" class="form-control"  placeholder="Enter phone number" id="phoneInput" pattern="01[0-46-9]-\d{7,8}"  name="txtphone" maxlength="12" required>
                    </div>

                    <div class="form-group">
                        <label>Department</label>
                        <select class="form-control" name="txtdept" required>
                            <option value="" disabled selected>Select Department</option>
                            <option>Inspection</option>  
                            <option>Mechanic</option>  
                        </select>
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
                        <button type="submit" class="btn btn-primary" name="btnsave">Save</button>
                    </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    </div>
<!---End of Modal -->
</div>
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
<script>
  $(document).ready(function() {
    $('#table_emp').DataTable();
  });
</script>
<script>
  $(document).ready(function() {
    $('.btndelete').click(function() {
        var tdh = $(this);
        var id = $(this).attr("id");
        Swal.fire({
        title: 'Do you want to delete?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {

        $.ajax({
            url: 'DeleteTool.php',
            type: 'post',
            data: {
              tidd: id
            },
            success: function(data) {
              tdh.parents('tr').hide();
            }
        });
        Swal.fire(
          'Deleted!',
          'Your Product has been deleted.',
          'success'
        )
      }
    })

  });
            
});
</script>
</script>