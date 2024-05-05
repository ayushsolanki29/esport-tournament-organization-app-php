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
  $select = "SELECT `profile` FROM `teams` WHERE `team_label`='$id'";
  $result = mysqli_query($con, $select);
  
  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      $profile = $row['profile'];
      $removePR = "UPDATE `profile` SET `status`='unused' WHERE `picture`='$profile'";
      $delete = "DELETE FROM `teams` WHERE `team_label`='$id'";
      
      if (mysqli_query($con, $removePR) && mysqli_query($con, $delete)) {
        echo "<script>alert('Deleted successfully!')</script>";
        echo "<script>window.location.href = 'igl_details.php'</script>";
      }
    }
  }
} 


?>
<!DOCTYPE html>
<html lang="en">

<head>

  <title>Aimgod eSports| IGL Details</title>
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

          <div class="row">
            <div class="card w-100 " style="overflow: scroll;">
              <div class="card-header">
                <h3 class="card-title">Team Caption Details</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Teams</th>
                      <th>Person Name</th>
                      <th>Screenshots</th>
                      <th>Status</th>
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
                            <?= $row['team_name'] ?><br />
                          </td>
                          <td>
                            <?= $row['igl_name'] ?><br />
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
                            <p
                              class="bg-<?= $row['payment'] == "success" ? 'success' : 'danger' ?> d-inline p-1 rounded w-25">
                              <?= $row['payment'] ?>
                            </p><br><br>
                            <p
                              class="bg-<?= $row['email_verify'] == "verified" ? 'success' : 'danger' ?> d-inline p-1 rounded w-25">
                              <?= $row['email_verify'] ?>
                            </p>
                          </td>
                          <td>
                          
                              <?php
                              $message = urlencode("*Attention " . $row['team_name'] . "!*\n\nPlease complete your payment until today using this link: https://esports.mypoetry.in/profile.php \notherwise your team will Disqualify.\n\nTeam AIMGOD");
                              $whatsapp_url = "https://wa.me/" . $row['igl_wa'] . "?text=" . $message;
                              ?>

                              <a target="bank" href="<?= $whatsapp_url ?>"><button class="btn btn-success btn-sm mt-2"
                                 ><i class="fab fa-whatsapp"></i></button></a>
                              <a target="bank" href="tel:+91<?= $row['igl_wa'] ?>"><button
                                  class="btn btn-primary btn-sm mt-2" ><i
                                    class="fas fa-phone-alt"></i></button></a>
                              <a target="bank" href="mailto:<?= $row['igl_email'] ?>"><button
                                  class="btn btn-info btn-sm mt-2"><i
                                    class="fas fa-envelope"></i></button></a>
                              <button class="btn btn-danger btn-sm mt-2" onclick="deleteteam('<?= $row['team_label'] ?>')"
                                type="button"><i class="fas fa-trash"></i> Delete Team</button>
                              <script>
                                function deleteteam(teamcode) {
                                  var confirm_box = confirm("Are you sure you want to delete the team?");
                                  if (confirm_box) {
                                    window.location = 'igl_details.php?deleteteam&id=' + teamcode;
                                  }
                                }
                              </script>


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