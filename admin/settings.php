<?php
include '../assets/php/config.php';
include '../assets/php/function.php';
session_start();

if (!isset($_SESSION['admin_auth'])) {
    header("location:login.php");
    exit;
}
function generateRandomToken($length = 20)
{
    $token = '';
    $characters = '0123456789ABCXYZabcxyz';
    $max = strlen($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[random_int(0, $max)];
    }
    return $token;
}
if (isset($_POST['torny_start'])) {
    $token = generateRandomToken();
    $update_torny = "UPDATE `settings` SET `data1`='start',`data2`='$token' WHERE id=2";
    mysqli_query($con, $update_torny);
    header('Location: settings.php');
}
if (isset($_POST['torny_end'])) {
    $update_torny = "UPDATE `settings` SET `data1`='ended',`data2`='' WHERE id=2";
    mysqli_query($con, $update_torny);
    header('Location: settings.php');
}
if (isset($_POST['changeurl'])) {
   $newURLwhatsapp = mysqli_real_escape_string($con, $_POST['newwhatsappurl']);
   $run_update_url = mysqli_query($con , " UPDATE `settings` SET `data1`='$newURLwhatsapp' WHERE id= '4'");
   if ($run_update_url) {
    header('Location: settings.php');
   }else{
    header('Location: settings.php');
   }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Aimgod eSports| settings</title>
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
                            <h1 class="m-0">Settings</h1>
                        </div>
                    </div>

                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Tasks</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                    $select_views = "SELECT `data1` FROM `settings` WHERE id=1";
                                    $run_select_view = mysqli_query($con, $select_views);

                                    while ($row_vw = mysqli_fetch_assoc($run_select_view)) {
                                        $views = $row_vw['data1'];
                                    }

                                    ?>


                                    <td>Views</td>
                                    <td>
                                        <?= $views ?>
                                    </td>
                                    <td><button disabled type="button" class="btn btn-danger">Reset</button>
                                        <button disabled type="button" class="btn btn-warning">Edit</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tornament Status</td>
                                    <?php
                                    $select_tr_st = "SELECT  `data1`, `data2` FROM `settings` WHERE id=2";
                                    $run_select_tr_st = mysqli_query($con, $select_tr_st);
                                    while ($row = mysqli_fetch_assoc($run_select_tr_st)) {
                                        $t_status = $row["data1"];
                                    }
                                    ?>
                                    <?php if ($t_status == "start") {
                                        echo " <td class='bg-success'> Running</td>";
                                    } else {
                                        echo "<td class='bg-danger'> Ended</td>";
                                    } ?>
                                    <form method="post">


                                        <?php if ($t_status == "start") {
                                            echo "<td><button type='submit' name='torny_end' class='btn btn-danger'>End</button> </td>";
                                        } else {
                                            echo "<td><button type='submit' name='torny_start' class='btn btn-success'>Start</button> </td>";
                                        } ?>
                                    </form>
                                </tr>
                                <tr>
                                    <td>Whatsapp URL</td>

                                    <?php
                                    $select_whatsapp = mysqli_query($con, "SELECT `data1` FROM `settings` WHERE id= '4'");
                                    while ($row_whatsapp = mysqli_fetch_assoc($select_whatsapp)) {
                                        $group_url = $row_whatsapp["data1"];
                                    }
                                    ?>
                                    <td><?= $group_url ?></td>
                                    <td>
                                        <button type="button" data-toggle="modal" data-target="#Whatsapp" class="btn btn-warning"> Update</button>
                                    </td>
                                    <div class="modal fade" id="Whatsapp" tabindex="-1" role="dialog" aria-labelledby="Whatsapplabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="Whatsapplabel">Whatsapp Community</h5>

                                                </div>
                                                <form method="post">
                                                    <div class="modal-body container">
                                                        <div class="mb-3">
                                                            <label for="" class="form-label">Whatsapp Group URL</label>
                                                            <input type="text" name="newwhatsappurl" id="" value="<?= $group_url ?>" class="form-control" placeholder="Place here New URL" aria-describedby="helpId" />
                                                            <small id="helpId" class="text-muted">"Reset Old URL if Changes, Otherwise Leave It Untouched"</small>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button"  class="btn btn-danger" data-dismiss="modal">close</button>
                                                        <button type="submit" name="changeurl" class="btn btn-primary" >change url</button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </tr>
                                <tr>
                                    <td>Admin Data</td>
                                    <?php
                                    $select_admindata = "SELECT  `data1`, `data2` FROM `settings` WHERE id= 3";
                                    $run_select_admindata = mysqli_query($con, $select_admindata);
                                    while ($row_admin = mysqli_fetch_assoc($run_select_admindata)) {
                                        $username = $row_admin["data1"];
                                        $password = $row_admin["data2"];
                                    }
                                    ?>
                                    <td>username : <span class="text-success"><?= $username ?> </span> <br> password :<span class="text-success"> <?= $password ?></span> </td>
                                    <td>
                                        <button type="button" name="" disabled class="btn btn-info"> Update</button>

                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>



                </div>
            </div>
        </div>
    </div>
    <?php include 'pages/footer.php' ?>

</body>

</html>