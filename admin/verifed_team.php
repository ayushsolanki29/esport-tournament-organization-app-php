<?php
include '../assets/php/config.php';
include '../assets/php/function.php';
session_start();

if (!isset($_SESSION['admin_auth'])) {
    header("location:login.php");
    exit;
}

if (isset($_POST['set_winner'])) {
    $team_id = $_POST['team_id'];
    $position = $_POST['position'];

    $set_winner = mysqli_query($con, "INSERT INTO `winners`(`team_id`, `position`) VALUES ($team_id,'$position')");
    if ($set_winner) {
        echo "<script>alert('winner set success')</script>";
        echo "<script>window.location.href = 'verifed_team.php'</script>";
    } else {
        echo "<script>alert('winner faild to set!')</script>";
        echo "<script>window.location.href = 'verifed_team.php'</script>";
    }
}
if (isset($_POST['update_team'])) {
    $unique_code22 = $_POST['team-code'];
    $p1 = mysqli_real_escape_string($con, $_POST['p1']);
    $p2 = mysqli_real_escape_string($con, $_POST['p2']);
    $p3 = mysqli_real_escape_string($con, $_POST['p3']);
    $p4 = mysqli_real_escape_string($con, $_POST['p4']);

    $update_team = mysqli_query($con, "UPDATE `teams` SET `f_player`='$p1',`s_player`='$p2',`t_player`='$p3',`frth_player`='$p4' WHERE `team_label`='$unique_code22'");
    if ($update_team) {
        echo "<script>alert('Updated successfull!')</script";
        header("location:verifed_team.php");
    } else {
        echo "<script>alert('Faild  to update team profile!')</script>";
        header("location:verifed_team.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Aimgod eSports| Verifed Teams</title>
    <?php include 'pages/header.php' ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="../assets/favicon/safari-pinned-tab.svg" alt="AdminLTELogo" height="60" width="60">
        </div>

        <?php include 'pages/navbar.php' ?>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Eligible Teams</h1>
                            <div class="d-grid gap-2">

                            </div>

                        </div>
                    </div>
                    <hr>
                    <div class="row justify-content-start">
                        <div class="col">
                            <div id="accordion">
                                <?php
                                if (isset($_GET['t'])) {
                                    // Use mysqli_real_escape_string to prevent SQL injection
                                    $team_name_f = mysqli_real_escape_string($con, $_GET['t']);
                                    $query = "SELECT * FROM `teams` WHERE `payment`='success' AND `email_verify`='verified' AND `team_name` = '$team_name_f'";
                                } else {
                                    $query = "SELECT * FROM `teams` WHERE `payment`='success' AND `email_verify`='verified' ORDER BY `id` DESC";
                                }




                                $result = mysqli_query($con, $query);
                                if (mysqli_num_rows($result) == 0) {
                                    echo '<div class="card"><div class="card-header">No Team Submitted</div></div>';
                                } else {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                        <div class="card mb-3">
                                            <div class="card-header" id="heading<?= $row['id'] ?>">
                                                <div style="cursor:pointer;" class="d-flex  justify-content-between align-items-center w-100" data-toggle="collapse" data-target="#collapse<?= $row['id'] ?>" aria-expanded="true" aria-controls="collapse<?= $row['id'] ?>">
                                                    <button class="btn " type="button">
                                                        <div class="d-flex align-items-center">
                                                            <div class="mr-3">
                                                                <img src="../assets/images/profile/<?= $row['profile'] ?>" alt="Team Logo" class="team-logo rounded-circle" width="50">
                                                            </div>
                                                            <div>
                                                                <h5 class="mb-0">
                                                                    <?= $row['team_name'] ?>
                                                                </h5>
                                                                <span class="text-muted">Team Leader:
                                                                    <?= $row['igl_name'] ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </button>
                                                    <div>
                                                        <p class="bg-primary text-center p-2 rounded" data-toggle="modal" data-target="#editteamname<?= $row['id'] ?>">Edit Name</p>
                                                        <?php

                                                        $winnerQuery = "SELECT * FROM `winners` WHERE team_id = " . $row['id'];
                                                        $winnerResult = mysqli_query($con, $winnerQuery);
                                                        if (mysqli_num_rows($winnerResult) > 0) {
                                                            $row1 = mysqli_fetch_assoc($winnerResult) // If team ID exists in winners
                                                        ?>
                                                            <p class="bg-success text-center p-2 rounded">
                                                                <?php
                                                                if ($row1['position'] == 1) {
                                                                    echo $row1['position'] . 'st';
                                                                } elseif ($row1['position'] == 2) {
                                                                    echo $row1['position'] . 'nd';
                                                                } elseif ($row1['position'] == 3) {
                                                                    echo $row1['position'] . 'rd';
                                                                } else {
                                                                    echo $row1['position'] . 'th';
                                                                }

                                                                ?>

                                                            </p>
                                                        <?php } else { ?>
                                                            <p class="bg-warning text-center p-2 rounded" data-toggle="modal" data-target="#teamdetails<?= $row['id'] ?>">
                                                                Set Winner
                                                            </p>
                                                        <?php } ?>



                                                    </div>
                                                    <div class="modal fade" id="editteamname<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="Whatsapplabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Team : <?= $row['team_name'] ?></h5>
                                                                </div>
                                                                <form method="post">
                                                                    <div class="modal-body container">
                                                                        <div class="mb-3">
                                                                            <label for="" class="form-label">Player 1</label>
                                                                            <input type="text" name="p1" id="" value="<?= $row['f_player'] ?>" class="form-control" placeholder="Place here New URL" aria-describedby="helpId" />
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="" class="form-label">Player 2</label>
                                                                            <input type="text" name="p2" id="" value="<?= $row['s_player'] ?>" class="form-control" placeholder="Place here New URL" aria-describedby="helpId" />
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="" class="form-label">Player 3</label>
                                                                            <input type="text" name="p3" id="" value="<?= $row['t_player'] ?>" class="form-control" placeholder="Place here New URL" aria-describedby="helpId" />
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="" class="form-label">Player 4</label>
                                                                            <input type="text" name="p4" id="" value="<?= $row['frth_player'] ?>" class="form-control" placeholder="Place here New URL" aria-describedby="helpId" />
                                                                        </div>
                                                                        <input type="hidden" name="team-code" value=<?= $row['team_label'] ?>>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">close</button>
                                                                        <button type="submit" name="update_team" class="btn btn-primary">update name</button>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="teamdetails<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="teamDetailsLabel<?= $row['id'] ?>" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="teamDetailsLabel<?= $row['id'] ?>">
                                                                        <?= $row['team_name'] ?>
                                                                    </h5>

                                                                </div>
                                                                <div class="modal-body container">
                                                                    <form method="post">
                                                                        <input type="hidden" name="team_id" value="<?= $row['id'] ?>">
                                                                        <div class="mb-3">
                                                                            <label for="" class="form-label">Add
                                                                                Position</label>
                                                                            <input type="number" min="1" max="40" inputmode="numburic" required name="position" class="form-control" placeholder="Enter Position Number" aria-describedby="helpId" />
                                                                            <small id="helpId" class="text-muted">in this
                                                                                Formate 1,2, 3,4,.... Format</small>
                                                                        </div>



                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                            <button type="submit" name="set_winner" class="btn btn-primary">Save</button></a>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div id="collapse<?= $row['id'] ?>" class="collapse" aria-labelledby="heading<?= $row['id'] ?>" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h4>Status</h4>
                                                            <ul>
                                                                <li>Team code:
                                                                    <?= $row['team_label'] ?>
                                                                </li>
                                                                <li>Payment: <span class="badge badge-<?= $row['payment'] == "success" ? 'success' : 'danger' ?>">
                                                                        <?= $row['payment'] ?>
                                                                    </span></li>
                                                                <li>Joined:
                                                                    <?= $row['date'] ?>
                                                                </li>
                                                                <li>Email: <span class="badge badge-<?= $row['email_verify'] == "verified" ? 'success' : 'danger' ?>">
                                                                        <?= $row['email_verify'] ?>
                                                                    </span></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h4>Players Details</h4>
                                                            <ul>
                                                                <li>Player 1:
                                                                    <?= $row['f_player'] ?>
                                                                </li>
                                                                <li>Player 2:
                                                                    <?= $row['s_player'] ?>
                                                                </li>
                                                                <li>Player 3:
                                                                    <?= $row['t_player'] ?>
                                                                </li>
                                                                <li>Player 4:
                                                                    <?= $row['frth_player'] ?>
                                                                </li>
                                                            </ul>
                                                            <h4>Contact Details</h4>
                                                            <ul>
                                                                <li>WhatsApp:
                                                                    <?= $row['igl_wa'] ?>
                                                                </li>
                                                                <li>Email:
                                                                    <?= $row['igl_email'] ?>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <h4 class="mt-4">Payment Proof</h4>
                                                    <?php if (!empty($row['screenshot'])) { ?>
                                                        <div class="text-center">
                                                            <img src="../assets/images/payment/<?= $row['screenshot'] ?>" alt="Screenshot" class="img-thumbnail" width="150">
                                                        </div>
                                                    <?php } else {
                                                        echo "No Screenshot";
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <?php include 'pages/footer.php' ?>

</body>

</html>