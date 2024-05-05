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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Aimgod eSports| settings</title>
    <?php include 'pages/header.php' ?>
    <style>
    .message-column {
        max-width: 300px; /* Adjust the value as needed */
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
</style>
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
                            <h1 class="m-0">Contacts</h1>
                        </div>
                    </div>

                    <hr>
                    <div class="table-responsive">
                    <style>
    .message-column {
        max-width: 300px; /* Adjust the value as needed */
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
</style>

<table class="table table-bordered table-hover">
    <thead class="thead-light">
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Query</th>
            <th scope="col">Message</th>
            <th scope="col">Date</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $select_contact = "SELECT * FROM `contact`";
        $run_select_contact = mysqli_query($con, $select_contact);

        while ($row_ct = mysqli_fetch_assoc($run_select_contact)) {
            ?>
            <tr>
                <td><?= $row_ct['name'] ?></td>
                <td><?= $row_ct['email'] ?></td>
                <td><?= $row_ct['query'] ?></td>
                <td class="message-column" title="<?= $row_ct['message'] ?>"><?= $row_ct['message'] ?></td>
                <td><?= $row_ct['date'] ?></td>
                <td>
                    <button disabled type="button" class="btn btn-danger">Delete</button>
                   <a href="mailto:<?= $row_ct['email'] ?>"> <button type="button" class="btn btn-info">Reply</button></a>
                </td>
            </tr>
            <?php
        }
        ?>
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