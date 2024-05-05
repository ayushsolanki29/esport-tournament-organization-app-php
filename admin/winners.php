<?php
include '../assets/php/config.php';
include '../assets/php/function.php';
session_start();

if (!isset($_SESSION['admin_auth'])) {
  header("location:login.php");
  exit;
}


if (isset($_GET['deleteteam'], $_GET['id'])) {
  $id = $_GET['id'];

  $delete = "DELETE FROM `winners` WHERE `id`='$id'";

  if (mysqli_query($con, $delete)) {
    echo "<script>alert('Remove successfully!')</script>";
    echo "<script>window.location.href = 'winners.php'</script>";
  }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>

  <title>Aimgod eSports| Winners</title>
  <?php include 'pages/header.php' ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="../assets/favicon/safari-pinned-tab.svg" alt="AdminLTELogo" height="60"
        width="60">
    </div>

    <?php include 'pages/navbar.php' ?>


    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">
                Winners Teams
              </h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
              </ol>
            </div>
          </div>
        </div>
      </div>


      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">

          <div class="row">
            <div class="card w-100 " style="overflow: scroll;">
              <div class="card-header">
                <h3 class="card-title">Winner Teams</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Teams</th>
                      <th>Position</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $query = "SELECT * FROM `winners` ORDER BY `winners`.`position` ASC";
                    $result = mysqli_query($con, $query);
                    if (mysqli_num_rows($result) == 0) {
                      echo '<tr><td colspan="4">No Team Submitted</td></tr>';
                    } else {
                      $count = 1;
                      while ($w_select = mysqli_fetch_assoc($result)) {
                        $team_id_select = $w_select['team_id'];
                        $select_team = "SELECT * FROM `teams`  WHERE `id` = $team_id_select";
                        $res_team = mysqli_query($con, $select_team);
                        $t_data = mysqli_fetch_assoc($res_team); ?>

                        <tr>
                          <td>
                            <?= $count++ . "." ?>
                          </td>
                          <td>
                            <?= $t_data['team_name'] ?><br />
                          </td>

                          <td>
                            <p class="bg-success d-inline p-1 rounded w-25">
                              <?php
                              if ($w_select['position'] == 1) {
                                echo $w_select['position'] . 'st';
                              } elseif ($w_select['position'] == 2) {
                                echo $w_select['position'] . 'nd';
                              } elseif ($w_select['position'] == 3) {
                                echo $w_select['position'] . 'rd';
                              } else {
                                echo $w_select['position'] . 'th';
                              }

                              ?>
                            </p>
                          </td>
                          <td>

                            <button class="btn btn-danger btn-sm mt-2" onclick="deleteteam('<?= $w_select['id'] ?>')"
                              type="button">Revoke Position</button>
                            <script>
                              function deleteteam(teamcode) {
                                var confirm_box = confirm("Are you sure you want to remove position?");
                                if (confirm_box) {
                                  window.location = 'winners.php?deleteteam&id=' + teamcode;
                                }
                              }
                            </script>
                          </td>
                        </tr>

                        <?php


                      }
                    }
                    ?>
                  </tbody>

                </table>
              </div>

            </div>
      </section>
    </div>
    <?php include 'pages/footer.php' ?>

</body>

</html>