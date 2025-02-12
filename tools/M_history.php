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
                <li class="breadcrumb-item active"><a href="M_maintenance.php">Menu</a></li>
                <li class="breadcrumb-item">Maintenance History</li>
              </ol>
            </div>

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
              <h5 class="m-0">History of Tool Maintenance :</h5>
            </div>

            
            <div class="card-body">

              <table class="table table-striped table-hover " id="tablereport">
                <thead>
                  <tr>
                    <td>Barcode</td>
                    <td>Tool Name</td>
                    <td>Problem</td>
                    <td>Date Reported</td>
                    <td>Date Released</td>
                    <td>Remark</td>
                    <td>Action</td>
                  </tr>
                </thead>
                <tbody>

                  <?php

                  $select = $pdo->prepare("select * from tbl_tools JOIN tbl_maintenance ON tbl_tools.barcode = tbl_maintenance.barcode");
                  $select->execute();

                  while ($row = $select->fetch(PDO::FETCH_OBJ)) {

                    echo '
                        <tr>
                          <td>' . $row->barcode . '</td>
                          <td>' . $row->tools_name . '</td>
                          <td>' . $row->problem . '</td>
                          <td>' . $row->date_report. '</td>
                          <td>' . $row->date_released. '</td>
                          <td>' . $row->solution. '</td>
                          <td>

                              <div class="btn-group">    
                                <button id=' . $row->mid . '  class="btn btn-danger btn-xs btndelete"><span class="fa fa-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete Tool"></span></button>
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

</div>
<?php
include_once "footer.php";
?>
<script>
  $(function () {
    $("#tablereport").DataTable({
      "responsive": true, 
      "autoWidth": false,
      "buttons": ["pdf", "print", "colvis"] ,
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
    }).buttons().container().appendTo('#tablereport_wrapper .col-md-6:eq(0)');
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