<?php
include_once 'connectdb.php';
session_start();


if($_SESSION['useremail']==""){

header('location:../index.php');

}
include_once "header.php";

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tools Usage Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">Menu</li>
              <li class="breadcrumb-item active"><a href="C_Check.php">Check Out</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
             <div class="col-lg-12">    
              <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">History of Tools :</h5>
              </div>
              <div class="card-body">

                <table class="table table-striped table-hover " id="tabletool1">
                  <thead>
                    <tr>
                      <td>Barcode</td>
                      <td>Tool Name</td>
                      <td>Employee ID</td>
                      <td>Status</td>
                      <td>Date Out</td>
                      <td>Date In</td>
                      <td>Remark</td>
                      <td>Action</td>
                    </tr>
                  </thead>
                  <tbody>

                    <?php

                    $select = $pdo->prepare("select * from tbl_borrow_tools JOIN tbl_tools ON tbl_borrow_tools.barcode =
                    tbl_tools.barcode ");
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
                          <td>' . $row->actual_date_returned . '</td>
                          <td>

                            <div class="btn-group">
                                
                          
                            <button id=' . $row->check_id . '  class="btn btn-danger btn-xs btndelete"><span class="fa fa-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete Tool"></span></button>

                            </div>

                          </td>

                          </tr>';
                                            }
                  ?>

                  </tbody>

                </table>

              </div>
          </div>
          <div class="row">
          <div class="col-md-6">
          <!-- Employee Late -->
          <div class="card">
              <div class="card-header">
                <h3 class="card-title">Employee Late Return</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered" id="tblemp">
                  <thead>
                    <tr>
                      <th>Employee ID</th>
                      <th>Status</th>
                      <th>Total</th>
   
                    </tr>
                  </thead>
                  <tbody>
                  <?php

                  $select = $pdo->prepare("SELECT employee_id, actual_date_returned, COUNT(*) AS occurrence FROM tbl_borrow_tools WHERE actual_date_returned = 'Late Return'
                  GROUP BY employee_id, actual_date_returned");
                  $select->execute();

                  while ($row = $select->fetch(PDO::FETCH_OBJ)) {

                      echo '
                          <tr>
                              <td>' . $row->employee_id . '</td>
                              <td>' . $row->actual_date_returned . '</td>
                              <td>' . $row->occurrence . '</td>

                          </tr>';
                                          }
                  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /.col -->
     
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Tool Usage</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered" id="tbl_tool">
                  <thead>
                    <tr>
                      <th>Barcode</th>
                      <th>Tool Usage</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php

                    $select = $pdo->prepare("select barcode, COUNT(*) AS tot_u from tbl_borrow_tools WHERE barcode IS NOT NULL GROUP BY barcode ORDER BY tot_u desc");
                    $select->execute();

                    while ($row = $select->fetch(PDO::FETCH_OBJ)) {

                        echo '
                            <tr>
                                <td>' . $row->barcode . '</td>
                                <td>' . $row->tot_u . '</td>

                            </tr>';
                                            }
                  ?>

                  </tbody>
                </table>
              </div>
            </div>

          </div>
          <!-- /.col -->
        </div>   
        <div class="row">
          <div class="col-md-6">
                                            
          <!-- Late-->
          <div class="card">
              <div class="card-header">
                <h3 class="card-title">Late Return Tool Report</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Status</th>
                      <th>Total</th>
   
                    </tr>
                  </thead>
                  <tbody>

                    <?php


                      $select = $pdo->prepare("select actual_date_returned, COUNT(*) AS emp from tbl_borrow_tools WHERE actual_date_returned IS NOT NULL GROUP BY actual_date_returned ORDER BY emp desc");
                      $select->execute();

                      while ($row = $select->fetch(PDO::FETCH_OBJ)) {

                          echo '
                              <tr>
                                  <td>' . $row->actual_date_returned . '</td>
                                  <td>' . $row->emp . '</td>

                              </tr>';
                                              }
                      ?>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /.col -->
     
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">#</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>#</th>
                    </tr>
                  </thead>
                  <tbody>



                  </tbody>
                </table>
              </div>
            </div>

          </div>
          <!-- /.col -->
        </div>             
        </div>
        </div>
        </div>
    </div>
  </div>
<?php
include_once "footer.php";
?>
<script>
  $(function () {
    $("#tabletool1").DataTable({
      "responsive": true, 
      "autoWidth": false,
      "buttons": ["pdf", "print", "colvis"] ,
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
    }).buttons().container().appendTo('#tabletool1_wrapper .col-md-6:eq(0)');
  });
  $(function () {
    $("#tblemp").DataTable({
      "responsive": true, 
      "autoWidth": false,
      "paging": true,
      "lengthChange": true,
      "searching": false,
      "ordering": true,
      "info": true,
    });
  });
  $(function () {
    $("#tbl_tool").DataTable({
      "responsive": true, 
      "autoWidth": false,
      "paging": true,
      "lengthChange": true,
      "searching": false,
      "ordering": true,
      "info": true,
    });
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
