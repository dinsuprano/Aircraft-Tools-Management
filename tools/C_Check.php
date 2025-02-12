<?php

include_once 'connectdb.php';
session_start();



if($_SESSION['useremail']==""){

  header('location:../index.php');
  
}
if(isset($_GET['status'])){
  $_SESSION['status']="Tool Already Checked Out";
}
if(isset($_GET['status1'])){
  $_SESSION['status']="Return Success";
}
if(isset($_GET['status2'])){
  $_SESSION['status']="Already Returned";
}
if(isset($_GET['status3'])){
  $_SESSION['status']="Removed";
}
if(isset($_GET['status4'])){
  $_SESSION['status']="Failed";
}

if($_SESSION['role']=="Admin"){
    include_once'header.php';
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Check Out / IN Tool</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Menu</li>
                    <li class="breadcrumb-item active"><a href="R_toolsusage.php">History</a></li> 
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
            

            <div class="card card-primary card-outline">
                <div class="card-header">
                <h5 class="m-0">Tools Inventory</h5>
                </div>
            
          
                <form action="C_checkOP.php" method="post" enctype="multipart/form-data">
                  <div class="card-body">
                      <div class="row">

                          <div class="col-md-6">
                              <label>Scan Barcode</label>
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fa fa-barcode"></i></span>
                                </div>
                                <input type="number" class="form-control" placeholder="Enter Barcode" name="txtbarcode" autocomplete="off">
                              </div>

                              <div class="form-group">
                                  <label>Employee ID</label>
                                  <select name="txt_employee_id" id="" class="form-control">
                                        <?php
                                            $query="SELECT * FROM tbl_employee order by employee_id asc";
                                            $statement = $pdo->prepare($query);
                                            $statement->execute();
                                            $result=$statement->fetchAll();
                                        ?>
                                        <?php foreach($result as $row) : ?>
                                            <option value="<?php echo $row['employee_id'] ?>"><?php echo $row['employee_name'] ?></option>
                                        <?php endforeach; ?>
                                  </select>
                              </div>
                              
                          </div>
                  </div>

                  </div>
                  <div class="card-footer">
                        <div class="text-center">
                        <button type="submit" class="btn btn-primary" name="btncheck">Check Out</button></div>
                    </div>
                    
                </form>

            </div>
            <div class="card card-primary card-outline">
            <div class="card-header">
              <h5 class="m-0">Check Out :</h5>
            </div>
            <div class="card-body">

              <table class="table table-striped table-hover " id="table_tool">
                <thead>
                  <tr>
                    <td>Barcode</td>
                    <td>Tool Name</td>
                    <td>Employee ID</td>
                    <td>Status</td>
                    <td>Date Out</td>
                    <td>Date In</td>
                    <td>Action</td>
                  </tr>
                </thead>
                <tbody>

                  <?php

                  $select = $pdo->prepare("select * from tbl_borrow_tools JOIN tbl_tools ON tbl_borrow_tools.barcode =
                  tbl_tools.barcode  where status_ ='not returned'");
                  $select->execute();

                  while ($row = $select->fetch(PDO::FETCH_OBJ)) {

                    echo '
                        <tr>
                        <td>' . $row->barcode . '</td>
                        <td>' . $row->tools_name . '</td>
                        <td>' . $row->employee_id . '</td>
                        <td>' . $row->status_ . '</td>
                        <td>' . $row->check_out_date . '</td>
                        <td>' . $row->check_in_date . '</td>
                        <td>

                          <div class="btn-group">
                                  
                          <a href="C_delete.php?id=' . $row->check_id . '" class="btn btn-danger btn-xs" role="button"><span class="far fa-calendar-times" style="color:#ffffff" data-toggle="tooltip" title="Edit Tool"></span></a>
                          </div>

                        </td>

                        </tr>';
                                          }
                ?>

                </tbody>

              </table>

            </div>
          </div>
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h5 class="m-0">Check In :</h5>
            </div>
            <div class="card-body">

              <table class="table table-striped table-hover " id="table_tool1">
                <thead>
                  <tr>
                    <td>Barcode</td>
                    <td>Tool Name</td>
                    <td>Employee ID</td>
                    <td>Status</td>
                    <td>Date Out</td>
                    <td>Date In</td>
                    <td>Action</td>
                  </tr>
                </thead>
                <tbody>

                  <?php

                  $select = $pdo->prepare("select * from tbl_borrow_tools JOIN tbl_tools ON tbl_borrow_tools.barcode =
                  tbl_tools.barcode where status_ ='not returned' order by tbl_borrow_tools.status_ asc limit 20");
                  $select->execute();

                  while ($row = $select->fetch(PDO::FETCH_OBJ)) {

                    echo '
                        <tr>
                        <td>' . $row->barcode . '</td>
                        <td>' . $row->tools_name . '</td>
                        <td>' . $row->employee_id . '</td>
                        <td>' . $row->status_ . '</td>
                        <td>' . $row->check_out_date . '</td>
                        <td>' . $row->check_in_date . '</td>
                        <td>

                          <div class="btn-group">
                                
                          <a href="C_return.php?id=' . $row->check_id . '" class="btn btn-success btn-xs" role="button"><span class="fa fa-check" style="color:#ffffff" data-toggle="tooltip" title="Edit Tool"></span></a>
                        
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
    
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php

include_once "footer.php";

?>
<script>
  $(document).ready(function() {
    $('#table_tool').DataTable();
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
            url: 'C_delete.php',
            type: 'get',
            data: {
              id: id
            },
            success: function(data) {
              tdh.parents('tr').hide();
            }
        });
        Swal.fire(
          'Deleted!',
          'Record Deleted.',
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