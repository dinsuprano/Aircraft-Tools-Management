<?php
include_once 'connectdb.php';
session_start();
if($_SESSION['useremail']==""){

  header('location:../index.php');
  
}
  if($_SESSION['role']=="Admin"){
    include_once'header.php';
  }

  error_reporting(0);

  $id=$_GET['id'];
    
  if(isset($_POST['btnsave'])){
  
    
      $barcode= $_POST['txtbarcode'];
      $problem = $_POST['txtproblem'];
      $status = $_POST['txtstatus'];
      $date_report= $_POST['txtdate_report'];
      $date_released= $_POST['txtdate_r'];
      $solution= $_POST['txtsolution'];

      if(isset($_POST['txtbarcode'])){

        $select=$pdo->prepare("select barcode from tbl_tools where barcode='$barcode'");

        $select->execute();

        if($select->rowCount()>0){
          
          if(isset($_POST['txtdate_r'])&& isset($_POST['txtsolution'])){

            $select=$pdo->prepare("select date_released from tbl_maintenance where date_released=0");
    
            $select->execute();
  
            if($select->rowCount()>0){
              $_SESSION['status']="Record already exists";
              $_SESSION['status_code']="warning";

            }else{
                         
              $stmt = $pdo->prepare("UPDATE tbl_tools SET status = :status , available_quantity = '0' WHERE barcode = :id");
              $stmt->bindParam(':id', $barcode, PDO::PARAM_STR);
              $stmt->bindParam(':status', $status, PDO::PARAM_STR);
              $stmt->execute();
            
        
              $query="INSERT INTO tbl_maintenance(barcode,problem,date_report,solution,date_released)VALUEs('$barcode','$problem','$date_report','$date_released','$solution')";
              $statement = $pdo ->prepare($query);
              $statement->execute();
            }
          }

        }else{

          $_SESSION['status']="Tool Not Exists";
          $_SESSION['status_code']="warning";
  
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
              <h1 class="m-0">Maintenance Menu</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">Menu</li>
                <li class="breadcrumb-item active"><a href="M_history.php">Maintenance History</a></li>
              </ol>
            </div>
        </div><!-- /.row -->
        <div class="col-sm-12">
             <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                 Create Report
              </button> 
               <!--<a class="btn btn-primary" href="M_history.php" role="button" >Maintenance History</a>-->
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
              <h5 class="m-0">Maintenance List :</h5>
            </div>

            
            <div class="card-body">

              <table class="table table-striped table-hover " id="table_tool">
                <thead>
                  <tr>
                    <td>Barcode</td>
                    <td>Tool Name</td>
                    <td>Problem</td>
                    <td>Status</td>
                    <td>Date Reported</td>
                    <td>Action</td>
                  </tr>
                </thead>
                <tbody>

                  <?php

                  $select = $pdo->prepare("select * from tbl_tools JOIN tbl_maintenance
                  ON tbl_tools.barcode = tbl_maintenance.barcode where tbl_tools.status ='Maintenance' and tbl_maintenance.solution='0' ");
                  $select->execute();

                  while ($row = $select->fetch(PDO::FETCH_OBJ)) {

                    echo '
                        <tr>
                        <td>' . $row->barcode . '</td>
                        <td>' . $row->tools_name . '</td>
                        <td>' . $row->problem . '</td>
                        <td>' . $row->status. '</td>
                        <td>' . $row->date_report. '</td>
                        <td>

                            <div class="btn-group">
                                    
                            <a href="M_editmaintenance.php?id=' . $row->mid . '" class="btn btn-success btn-xs" role="button"><span class="fa fa-edit" style="color:#ffffff" data-toggle="tooltip" title="Edit Report"></span></a>

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
                <h4 class="modal-title">Create Report</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>


              <div class="modal-body">
              <form action="" method="post">

                    <div class="form-group">
                        <label for="exampleInputEmail1">Barcode</label>
                        <input type="text" class="form-control" placeholder="Enter ID" name="txtbarcode" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Problem</label>
                        <textarea class="form-control" placeholder="Enter Problem" name="txtproblem" rows="3" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Status</label>
                        <input type="text" class="form-control" placeholder="Maintenance" name="txtstatus" value="Maintenance" required readonly>
                    </div>

                    <div class="form-group">
                      <label>Date</label>
                        <div class="input-group date" data-target-input="nearest">
                              <input type="date" class="form-control datetimepicker-input" placeholder="Date" name="txtdate_report" required>
                        </div>
                    </div>
                    <input type="hidden" name="txtdate_r" value="0">
                    <input type="hidden" name="txtsolution" value="0">
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
<script>
  $(document).ready(function() {
    $('#table_tool').DataTable({
    });
  });
  
</script>
<script>
  $(document).ready(function() {
    $('#table_tool1').DataTable();
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
            url: 'M_deletereport.php',
            type: 'post',
            data: {
              mid: id
            },
            success: function(data) {
              tdh.parents('tr').hide();
            }
        });
        Swal.fire(
          'Deleted!',
          'Your Maintenance Report has been deleted.',
          'success'
        )
      }
    })

  });
            
});
</script>
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