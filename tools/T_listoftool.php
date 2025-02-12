<?php
include_once 'connectdb.php';
session_start();
if($_SESSION['useremail']==""){

  header('location:../index.php');
  
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
          <h1 class="m-0">Tool Inventory</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">Menu</li>
              <li class="breadcrumb-item active"><a href="T_addtool.php">Add Tool</a></li> 
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
              <h5 class="m-0">Tool List :</h5>
            </div>
            <div class="card-body">

              <table class="table table-striped table-hover " id="table_tool">
                <thead>
                  <tr>
                    <td>Barcode</td>
                    <td>Tool Name</td>
                    <td>Location</td>
                    <td>Price</td>
                    <td>Status</td>
                    <td>Available Qty</td>
                    <td>Image</td>
                    <td>Action</td>
                  </tr>
                </thead>
                <tbody>

                  <?php

                  $select = $pdo->prepare("select * from tbl_tools order by barcode asc");
                  $select->execute();

                  while ($row = $select->fetch(PDO::FETCH_OBJ)) {

                    echo '
                        <tr>
                        <td>' . $row->barcode . '</td>
                        <td>' . $row->tools_name . '</td>
                        <td>' . $row->location . '</td>
                        <td>' . $row->price . '</td>
                        <td>' . $row->status . '</td>
                        <td>' . $row->available_quantity . '</td>
                        <td><image src="tool_images/' . $row->image . '" class="img-rounded" width="40px" height="40px/"></td>

                        <td>

                        <div class="btn-group">
                                
                        <a href="T_printbarcode.php?id=' . $row->barcode . '" class="btn btn-dark btn-xs" role="button"><span class="fa fa-barcode" style="color:#ffffff" data-toggle="tooltip" title="Print Barcode"></span></a>

                        <a href="T_viewtool.php?id=' . $row->barcode . '" class="btn btn-warning btn-xs" role="button"><span class="fa fa-eye" style="color:#ffffff" data-toggle="tooltip" title="View Tool"></span></a>

                        <a href="T_edittool.php?id=' . $row->barcode . '" class="btn btn-success btn-xs" role="button"><span class="fa fa-edit" style="color:#ffffff" data-toggle="tooltip" title="Edit Tool"></span></a>

                        <button id=' . $row->barcode . '  class="btn btn-danger btn-xs btndelete"><span class="fa fa-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete Tool"></span></button>

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
  $(function () {
    $("#table_tool").DataTable({
      "responsive": true, 
      "lengthChange": false, 
      "autoWidth": false,
      "buttons": ["csv"] ,
      "paging": true,
      "searching": true,
      "ordering": true,
      "info": true,
    }).buttons().container().appendTo('#table_tool_wrapper .col-md-6:eq(0)');
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
            url: 'T_deletetool.php',
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
          'Your Tool has been deleted.',
          'success'
        )
      }
    })

  });
            
});
</script>
