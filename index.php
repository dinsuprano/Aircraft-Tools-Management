<?php
include_once "tools/connectdb.php";
session_start();

if (isset($_POST['btn_login'])) {

  $useremail = $_POST['txt_email'];
  $password = $_POST['txt_password'];

  
  $stmt = $pdo->prepare("select * from tbl_user where useremail='$useremail'");
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if(is_array($user)){
    if ($user['useremail'] == $useremail and password_verify($password, $user['userpassword']) and $user['role'] == "Admin") {
      $_SESSION['status']="Login Success By Admin";
      $_SESSION['status_code']="success";

      header('refresh: 1;tools/dashboard.php');

      $_SESSION['userid']=$user['userid'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['useremail'] = $user['useremail'];
      $_SESSION['role'] = $user['role'];

    }else{
      $_SESSION['status']="Wrong Email or Password";
      $_SESSION['status_code']="error";
    }
}
else {
    $_SESSION['status']="Wrong Email or Password";
    $_SESSION['status_code']="error";
  }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aircraft Tools Management Log in</title>
  <link rel="icon" href="dist/img/AdminLTELogo.png" type="image/ico">
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<!-- <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css"> -->

 <!-- SweetAlert2 -->
 <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">

<link rel="stylesheet" href="dist/css/adminlte.min.css">


</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="" class="h1"><b>Log</b>In</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Aircraft Tools Management</p>

        <form action="" method="post">
          <div class="input-group mb-3">

            <input type="email" class="form-control" placeholder="Email" name="txt_email" required>

            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">

            <input type="password" class="form-control" placeholder="Password" name="txt_password" required>


            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <a href="forgotpassword/forgot-password.php">I forgot my password</a>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block" name="btn_login">Login</button>
            </div>
            <!-- /.col -->
          </div>
        </form>


        <!-- /.social-auth-links -->

        <p class="mb-1">

        </p>
        <p class="mb-0">

        </p>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->
 
</body>

</html>
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
  <!-- AdminLTE App -->
 
  <script src="dist/js/adminlte.min.js"></script>
  <?php
  if(isset($_SESSION['status']) && $_SESSION['status']!='')
 
  {
?>
<script>

$(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top',
      showConfirmButton: false,
      timer: 5000
    });

      Toast.fire({
        icon: '<?php echo $_SESSION['status_code'];?>',
        title: '<?php echo $_SESSION['status'];?>'
      })
    });

</script>
<?php
unset($_SESSION['status']);
}
?>









     






   

   