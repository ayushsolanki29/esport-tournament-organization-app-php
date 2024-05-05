<?php
include '../assets/php/config.php';
session_start();

if (isset($_SESSION['admin_auth'])) {
  header("location:index.php");
  exit;
}

if (isset($_COOKIE['adminlogincheck'])) {
  $_SESSION['admin_auth'] = true;
  header("location:index.php");
}

if (isset($_POST['login_admin'])) {
  $username = mysqli_real_escape_string($con, $_POST['username']);
  $password = mysqli_real_escape_string($con, $_POST['password']);

  $select_admindata = "SELECT  `data1`, `data2` FROM `settings` WHERE id= 3";
  $run_select_admindata = mysqli_query($con, $select_admindata);
  while ($row_admin = mysqli_fetch_assoc($run_select_admindata)) {
    $fetch_username = $row_admin["data1"];
    $fetch_password = $row_admin["data2"];
    if ($username == $fetch_username && $password == $fetch_password) {
      setcookie("adminlogincheck", "$2y$10lEf1JRggX.1BmuuXIPexjuWGOcJh7fIUHPpgmnQGmXrHu5p4pDyN.", strtotime('+30 days'), '/', '', false, true);
      $_SESSION['admin_auth'] = true;
      $_SESSION['username'] = $username;
      header("location:index.php");
    } else {
      $response = "<b> Unauthorized Access Detected.</b> <br> <span class='font-italic'> Avoid further attempts to prevent system damage.</span>";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Aimgod eSports | Login</title>
  <?php include 'pages/header.php' ?>
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="index.php"><b>Aimgod </b> eSports</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Login Panel For admin only</p>
        <?php if (isset($response)) { ?>
          <p class="bg-danger p-2 rounded">
            <?= $response ?>
          </p>
        <?php } ?>

        <form method="post">
          <div class="input-group mb-3">
            <input type="text" name="username" class="form-control" placeholder="Username" minlength="6" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" minlength="8" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>

          <div class="row">

            <!-- /.col -->
            <div class="col-4">
              <button type="submit" name="login_admin" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>





      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.min.js"></script>
</body>

</html>