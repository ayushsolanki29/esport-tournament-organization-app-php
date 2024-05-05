<?php
include '../assets/php/config.php';
include '../assets/php/function.php';

session_start();

if (!isset($_SESSION['admin_auth'])) {
  header("location:login.php");
  exit;
}
if (isset($_GET['notification'])) {
  if ($_GET['notification'] == "readall") {
    seenNotification();
    header("location:index.php");
  }
}
if (isset($_POST['email_verify'])) {
 $team_id = $_POST['id'];
 $update = "UPDATE `teams` SET `email_verify`='verified' WHERE id=$team_id ";

 if ($con->query($update) === TRUE) {
   echo "<script>alert('Email Verification Successful!')</script>";
   echo "<script>window.location.href = 'index.php' </script>";

 } else {
   echo "<script>alert('Faild verification')</script>" ;
   echo "<script>window.location.href = 'index.php' </script>";
 }
}
if (isset($_POST['payment'])) {
 $team_id = $_POST['id'];
 $update = "UPDATE `teams` SET `payment`='success' WHERE id=$team_id ";

 if ($con->query($update) === TRUE) {
   echo "<script>alert('Payment Successful!')</script>";
   echo "<script>window.location.href = 'index.php' </script>";
 } else {
   echo "<script>alert('Faild payment')</script>" ;
   echo "<script>window.location.href = 'index.php' </script>";
 }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>

  <title>Aimgod eSports| Dashboard</title>
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
                Dashboard
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
          <!-- Small boxes (Stat box) -->


          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <?php
                  $select_views = "SELECT `data1` FROM `settings` WHERE id=1";
                  $run_select_view = mysqli_query($con, $select_views);

                  while ($row = mysqli_fetch_assoc($run_select_view)) {
                    $views = $row['data1'];
                  }

                  ?>
                  <h3>
                    <?= $views ?>
                  </h3>

                  <p>Total Views</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <?php   // Fetch the count of records where payment_status is 'Paid'
                  $select_teams = "SELECT COUNT(*) AS totalteams FROM `teams` WHERE 1";
                  $run_select_teams = mysqli_query($con, $select_teams);

                  if ($run_select_teams) {
                    $row = mysqli_fetch_assoc($run_select_teams);
                    $totalteams = $row['totalteams'];
                  } else {
                    $totalteams = 0;
                  } ?>
                  <h3>
                    <?= $totalteams ?>
                  </h3>
                  <p>Total Teams</p>
                </div>

                <div class="icon">

                </div>

              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <?php   // Fetch the count of records where payment_status is 'Paid'
              $select_players = "SELECT COUNT(*) AS totalplayer FROM `teams` WHERE `email_verify`='verified' AND `payment`='success'";
              $run_select_players = mysqli_query($con, $select_players);
              
                  if ($run_select_players) {
                    $row = mysqli_fetch_assoc($run_select_players);
                    $players = $row['totalplayer'] * 50;
                  } else {
                    $players = 0;
                  } ?>
                  <h3>
                    <?= $players .'₹'?>
                  </h3>
                  <p>Total Revanue</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>

              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <?php
                  $select_veryfied_teams = "SELECT COUNT(*) AS veryfied_teams FROM `teams` WHERE email_verify='verified' && payment='success'";
                  $run_veryfied_teams = mysqli_query($con, $select_veryfied_teams);

                  if ($run_veryfied_teams) {
                    $row = mysqli_fetch_assoc($run_veryfied_teams);
                    $veryfied_teams = $row['veryfied_teams'];
                  } else {
                    $veryfied_teams = 0;
                  } ?>
                  <h3>
                    <?= $veryfied_teams ?>
                  </h3>
                  <p>Verified Teams</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
          </div>


          <div class="row">
            <div class="card w-100 " style="overflow: scroll;">
              <div class="card-header">
                <h3 class="card-title">All Teams</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Teams</th>
                      <th>Screenshots</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                 $query = "SELECT * FROM `teams` ORDER BY 
                 CASE 
                     WHEN payment = 'pending' THEN 1 
                     WHEN email_verify = 'unverified' THEN 2 
                     ELSE 3 
                 END, `id` DESC";
     
                    $result = mysqli_query($con, $query);
                    if (mysqli_num_rows($result) == 0) {
                      echo '<tr><td colspan="4">No Team Submitted</td></tr>';
                    } else {
                      $count = 1;
                      while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                          <td>
                            <?= $count++ . "." ?>
                          </td>
                          <td>
                            <div class="team-details row align-items-center">
                              <div class="col-auto">
                                <img src="../assets/images/profile/<?= $row['profile'] ?>" alt="Team Logo"
                                  class="team-logo rounded-circle my-2" width="50">
                              </div>
                              <div class="col">
                                <div class="team-info">
                                  <h5>
                                    <?= $row['team_name'] ?> <span class="text-muted">@
                                      <?= $row['igl_name'] ?>
                                    </span>
                                  </h5>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="text-center">
                            <?php if (!empty($row['screenshot'])) { ?>
                              <a href="../assets/images/payment/<?= $row['screenshot'] ?>"
                                class="d-flex align-items-center justify-content-center">
                                <img src="../assets/images/payment/<?= $row['screenshot'] ?>" class="team-logo rounded"
                                  width="40" alt="<?= $row['team_name'] ?>">
                              </a>
                            <?php } else {
                              echo "No Screenshot";
                            } ?>
                          </td>
                          <td>
                            <form method="post">

                          <input type="hidden" name="id" value="<?= $row['id']?>">
                            <?php if ($row['email_verify'] != "verified") { ?>
                              <button class="btn btn-warning btn-sm mt-2" type="submit" name="email_verify">Email Verify</button>
                            <?php } ?>
                            <?php if ($row['payment'] != "success") { ?>
                              <button class="btn btn-success btn-sm mt-2" type="submit" name="payment">Payment Verify</button>
                            <?php } ?>
                           
                            <button type="button" class="btn btn-info btn-sm mt-2" data-toggle="modal" data-target="#teamdetails<?= $row['id'] ?>">View Details</button>
                            

                            </form>
                          </td>
                        </tr>


                        <div class="modal fade" id="teamdetails<?= $row['id']?>" tabindex="-1" role="dialog"
                          aria-labelledby="teamDetailsLabel<?= $row['id'] ?>" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="teamDetailsLabel<?= $row['id'] ?>">Team Details</h5>
                             
                              </div>
                              <div class="modal-body container">
                                <img src="../assets/images/profile/<?= $row['profile'] ?>" alt="Team Logo"
                                  class="rounded-circle mx-auto d-block my-3" width="100">
                                <h4 class="text-center">
                                  <?= $row['team_name'] ?>
                                </h4>
                                <h5 class="text-center text-muted">Team Leader : 
                                  <?= $row['igl_name'] ?>
                                </h5>
                                <h4>Status</h4>
                                <ul>
                                  <li>Team code : <?= $row['team_label'] ?></li>
                                  <li>Payement : <p class="bg-<?= $row['payment'] =="success" ? 'success' : 'danger' ?> d-inline p-1 rounded w-25"><?= $row['payment'] ?></p></li>
                                  <li title="<?= $row['date']?>">Joinded :   <?php $ratingDate = strtotime($row['date']);
                                                        $currentDate = time();
                                                        $differenceInSeconds = $currentDate - $ratingDate;
                                                        $differenceInDays = floor($differenceInSeconds / (60 * 60 * 24));
                                                        if ($differenceInDays == 0) {
                                                            echo 'Today';
                                                        } elseif ($differenceInDays == 1) {
                                                            echo 'Yesterday';
                                                        } elseif ($differenceInDays <= 60) {
                                                            echo $differenceInDays . ' days ago';
                                                        } else {
                                                            $differenceInWeeks = ceil($differenceInDays / 7);
                                                            echo $differenceInWeeks . ' weeks ago';
                                                        } ?></li>
                                  <li>Email : <p class="bg-<?= $row['email_verify'] =="verified" ? 'success' : 'danger' ?> d-inline p-1 rounded w-25"><?= $row['email_verify'] ?></p></li>
                              
                                
                                </ul>
                                <hr>
                                <h4>Players Details</h4>
                                <ul>
                                  <li>Player 1 : <?= $row['f_player'] ?></li>
                                  <li>Player 2 : <?= $row['s_player'] ?></li>
                                  <li>Player 3 : <?= $row['t_player'] ?></li>
                                  <li>Player 4 : <?= $row['frth_player'] ?></li>
                                </ul>
                                <hr>
                                <h4>Contact Details</h4>
                                <ul>
                                  <li> Whatsapp : <?= $row['igl_wa'] ?></li>
                                  <li>Email : <?= $row['igl_email'] ?></li>
                            
                                </ul>
                                <hr>
                                <h4>Payment Proof</h4>
                                <?php if (!empty($row['screenshot'])) { ?>
                              <a href="../assets/images/payment/<?= $row['screenshot'] ?>">
                                <div class="text-center">
                                  <img src="../assets/images/payment/<?= $row['screenshot'] ?>" alt="Screenshot"
                                    class="img-thumbnail" width="150">
                                </div>
                                <?php } else {
                              echo "No Screenshot";
                            } ?>
                              </div>
                              <div class="modal-footer">
                                <a href="index.php">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></a>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        
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