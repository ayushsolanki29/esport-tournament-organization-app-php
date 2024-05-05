<?php
include "assets/php/config.php";
include "assets/php/function.php";
session_start();
$response = "";

if (isset($_POST['update_team'])) {
    $unique_code22 = $_COOKIE['team-code'];
    $p1 = mysqli_real_escape_string($con, $_POST['p1']);
    $p2 = mysqli_real_escape_string($con, $_POST['p2']);
    $p3 = mysqli_real_escape_string($con, $_POST['p3']);
    $p4 = mysqli_real_escape_string($con, $_POST['p4']);

    $update_team = mysqli_query($con, "UPDATE `teams` SET `f_player`='$p1',`s_player`='$p2',`t_player`='$p3',`frth_player`='$p4' WHERE `team_label`='$unique_code22'");
    if ($update_team) {
        echo "<script>alert('Updated successfull!')</script";
        header("location:profile.php");
        sendNotification("$unique_code22", "Just update Team Name");
    } else {
        echo "<script>alert('Faild  to update team profile! please contact admin')</script>";
        header("location:profile.php");
    }
}

if (isset($_GET['delete_team_cookies'])) {
    setcookie("team-code", "", time() + (86400 * 30), "/");
    header("location:profile.php");
}
if (isset($_POST['uniquecode-btn'])) {
    $unique_code = mysqli_real_escape_string($con, $_POST['uniquecode']);
    $select_query = "SELECT `team_label` FROM `teams` WHERE `team_label`='$unique_code'";
    if ($result = mysqli_query($con, $select_query)) {
        $row = mysqli_fetch_array($result);
        if (!empty($row["team_label"])) {
            setcookie("team-code", $row['team_label'], time() + (86400 * 30), "/");
            header("Refresh:0");
        } else {
            $response = "Invalid Code";
        }
    }
}

if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] === 0) {
    $filename = $_FILES['screenshot']['name'];
    $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
    $valid_extensions = ['png', 'jpg', 'jpeg'];
    $team_label = $_COOKIE['team-code'];
    if (in_array(strtolower($file_ext), $valid_extensions)) {
        $destfile = 'assets/images/payment/' .  $team_label . '.' . $file_ext;
        $new_file = $team_label . '.' . $file_ext;
        move_uploaded_file($_FILES['screenshot']['tmp_name'], $destfile);
        $update = "UPDATE `teams` SET `screenshot`= '$new_file' WHERE `team_label`='$team_label'";
        $result = mysqli_query($con, $update);
        if ($result) {
            $response = "Screenshot Uploaded";
            header("location:profile.php?file=uploaded");
        } else {
            header("location:profile.php?fileupload");
            $response = "Screenshot Not Uploaded";
        }
    } else {
        header("location:profile?fileupload");
        $response = "Only supported extensions are JPG, PNG, JPEG.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Aimgod eSports - Tornaments</title>
    <?php include "assets/pages/header.php"; ?>
    <link rel="stylesheet" href="login-assets/css/style.css" />
    <style>
        .edit-icon {
            float: right;
            margin-top: -30px;
        }

        .edit-icon ion-icon {
            font-size: 26px;
            color: #fff;
            cursor: pointer;
            /* Add a pointer cursor to indicate interactivity */
            transition: color 0.3s ease;
            /* Add a smooth transition for color change */
        }

        .edit-icon ion-icon:hover {
            color: #444;
            /* Darken the color on hover for visual feedback */
        }

        .update_team {
            flex-direction: column;
        }
    </style>
</head>

<body id="top">

    <main>
        <article>
            <?php include "assets/pages/navbar.php"; ?>
            <br><br>

            <?php if (isset($_COOKIE['team-code'])) {
                $team_code = $_COOKIE['team-code'];
                $select_query = "SELECT * FROM teams WHERE team_label='$team_code'";
                $result = mysqli_query($con, $select_query);
                if (mysqli_num_rows($result) == 0) {
                    echo '<script>alert("Team Code Not Found!!")</script>';
                    echo '<script>window.location.href = "profile.php?delete_team_cookies"</script>';
                } else { // Loop through the fetched results and populate the HTML structure
                    while ($row = mysqli_fetch_assoc($result)) {

                        $payment_status = $row["payment"];
                        $payment_success = ($payment_status == "success");

                        $status_message = $payment_success ? "Success" : "Pending";
                        $class_list = $payment_success ? "" : "danger";
                        $payment_message = $payment_success ? "Your Payment is Done" : "Payment status is Pending";
                        $button_text = $payment_success ? "Check Another Team" : "Pay Now";
                        $link_url = $payment_success ? "verifed_teams.php" : "contact.php";
                        $top_url = $payment_success ? "profile.php?delete_team_cookies=true" : "profile.php?paynow=true&active=hash";
                        $payment_url = $payment_success ? "verifed_teams.php" : "profile.php?paynow=true&active=hash";
                        $footer_text = $payment_success ? "Check List" : "Need Help??";
                        $footer_message = $payment_success ? "You are Now eligable For Tornament" : "We are working on your Payment";
            ?>
                        <section class="team section-wrapper" id="team">
                            <div class="container">
                                <div class="payment-coiunter">
                                    <section class="alert-for-payment-status">
                                        <header>
                                            <p class>Payment status</p>
                                            <a href="<?= $top_url ?>"> <?= $button_text ?></a>
                                        </header>
                                        <main>

                                            <h2 class="<?= $class_list ?>"><?= $status_message ?> <a href="<?= $payment_url ?>"><?= $payment_message ?></a></h2>
                                        </main>
                                        <footer>
                                            <a href="<?= $link_url ?>"><?= $footer_text ?></a>
                                            <p><?= $footer_message ?></p> <br>
                                            <div>
                                                
                                                <a href="profile.php?delete_team_cookies=true">Clear Team</a>
                                            </div>
                                        </footer>
                                    </section>
                                </div>

                                <?php if (!isset($_COOKIE['joinedwa'])) { ?>
                                    <div class="Join-wa-card-container" id="jounwacard">
                                        <div class="join-wa-card">
                                            <p class="cookie-heading">Join Whatsapp Group</p>
                                            <p class="cookie-para">
                                                Join Whatsapp Group for Future updates
                                            </p>
                                            <div class="button-wrapper">
                                                <button class="accept cookie-button" type="button" onclick="joinwa()">Join Now</button>
                                                <button class="reject cookie-button" type="button" onclick="leterjoin()">Leter</button>
                                            </div>
                                        </div>
                                    </div>
                                <?php  } ?>
                                <?php
                                $whatsappJoin = mysqli_query($con, "SELECT  `data1` FROM `settings` WHERE `id`='4'");
                                $joinURL = mysqli_fetch_assoc($whatsappJoin);

                                ?>
                                <script>
                                    function joinwa() {
                                        var url = "<?= $joinURL['data1']; ?>";
                                        window.open(url, "_blank");
                                        setCookie("joinedwa", "true", 5);
                                    }
                                </script>
                                <h2 class="h2 section-title">
                                    <?= $row["team_name"] ?>
                                </h2>

                                <section class="about" id="about" style="padding-top: 0px">
                                    <div class="container">

                                        <figure class="about-banner">

                                            <img src="./assets/images/profile/<?= $row['profile'] ?>" alt="M shape" class="about-img" style="border-radius: 50%;">
                                        </figure>

                                        <div class="about-content">
                                            <div class="edit-icon">
                                                <ion-icon onclick="window.location.href = 'profile.php?update_profile'" name="create-outline"></ion-icon>
                                            </div>
                                            <p class="about-subtitle">Team Details</p>

                                            <h2 class="about-title">Leader : <strong>
                                                    <?= $row['igl_name'] ?>
                                                </strong> </h2>

                                            <p class="about-text">
                                                <li>Player 1: <strong class="player-details-profile">
                                                        <?= $row['f_player'] ?>
                                                    </strong> </li>
                                                <li>Player 2: <strong class="player-details-profile">
                                                        <?= $row['s_player'] ?>
                                                    </strong> </li>
                                                <li>Player 3: <strong class="player-details-profile">
                                                        <?= $row['t_player'] ?>
                                                    </strong> </li>
                                                <li>Player 4: <strong class="player-details-profile">
                                                        <?= $row['frth_player'] ?>
                                                    </strong> </li>
                                                <br>
                                                <li>Email : <strong class="player-details-profile">
                                                        <?= $row['igl_email'] ?>
                                                    </strong> </li>
                                                <li>whatsapp : <strong class="player-details-profile">
                                                        <?= $row['igl_wa'] ?>
                                                    </strong> </li>
                                                <br>
                                                <?php if (!empty($row['screenshot'])) {
                                                ?><li><a href="assets/images/payment/<?= $row['screenshot'] ?>" download="payment">Download Payment Screenshot</a></li> <?php
                                                                                                                                                                    } ?>




                                                <br>
                                                <li>Registed : <strong class="player-details-profile"><b class="player-details"></b>
                                                        <?php $ratingDate = strtotime($row['date']);
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
                                                        } ?>
                                                    </strong> </li>
                                            </p>



                                        </div>

                                    </div>
                                </section>
                                <?php if (isset($_GET['update_profile'])) { ?>

                                    <div class="popup-overlay">
                                        <div class="popup-content">
                                            <div class="entry-fees-section">
                                                <h2>Update Team</h2>
                                                <br>
                                                <form method="post">
                                                    <div class="footer-input-wrapper update_team unique-code">
                                                        <input type="text" name="p1" value="<?= $row['f_player'] ?>" required placeholder="Enter Player 1" style="width: auto;" class="footer-input">
                                                        <br>
                                                        <input type="text" name="p2" value="<?= $row['s_player'] ?>" required placeholder="Enter Player 2" style="width: auto;" class="footer-input">
                                                        <br>
                                                        <input type="text" name="p3" value="<?= $row['t_player'] ?>" required placeholder="Enter Player 3" style="width: auto;" class="footer-input">
                                                        <br>
                                                        <input type="text" name="p4" value="<?= $row['frth_player'] ?>" required placeholder="Enter Player 4" style="width: auto;" class="footer-input">
                                                        <br>
                                                    </div>
                                                    <div class="btn-for-confirm" style="flex-direction: column;">
                                                        <button class="confirm-button" name="update_team" type="submit">Update Team</button>
                                                        <a class="later-upload" href="profile.php">I Don't want to update</a>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                <?php      } ?>
                                <?php
                                if (isset($_GET['paynow'])) {
                                ?>
                                    <div class="popup-overlay">
                                        <div class="popup-content">
                                            <div class="entry-fees-section">
                                                <h2>Pay 50₹</h2>
                                                <p>Entry Fees for Your Team</p>
                                                <div class="qr-code">
                                                    <img src="assets/images/payment/qr.png" alt="">

                                                </div>
                                                <br>
                                                or
                                                <div class="btn-for-confirm">
                                                    <button class="confirm-button" type="button">Pay Now 50₹</button>
                                                </div>
                                                <br>
                                                <p id="countdown-payment">60 secounds</p>
                                                <script>
                                                    var seconds = 60;

                                                    function updateCountdown() {
                                                        document.getElementById('countdown-payment').innerHTML = seconds + ' seconds Left';
                                                        seconds--;

                                                        if (seconds < 0) {
                                                            window.location.href = "profile.php?fileupload=true";
                                                        } else {
                                                            setTimeout(updateCountdown, 1000);
                                                        }
                                                    }

                                                    updateCountdown();
                                                </script>
                                            </div>
                                            <div class="rules-section">
                                                <h2>Rules Confirmation</h2>
                                                <p>Please confirm that you have read and agree to <a href="#" class="rules-agree"> the rules. </a></p>
                                                <div class="btn-for-confirm">
                                                    <button class="confirm-button" onclick="closePopup()">Confirm</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>

                                <?php
                                if (isset($_GET['fileupload'])) { ?>
                                    <div class="popup-overlay">
                                        <div class="popup-content">
                                            <div class="entry-fees-section">
                                                <h2>Upload</h2>
                                                <p>Please Upload Screenshot of your Payment</p>
                                                <p><?= $response ?></p>
                                                <form class="form login-form d-flex f-column show" enctype="multipart/form-data" method="post">
                                                    <div class="cust_file_upload">
                                                        <input type="file" accept="image/png, image/jpeg, image/jpg" name="screenshot">
                                                    </div>
                                                    <div class="btn-for-confirm">
                                                        <button class="confirm-button" name="sharess" type="submit">Upload Now</button>
                                                        <a class="later-upload" href="profile.php">I will upload Leter</a>
                                                    </div>
                                                </form>
                                            </div>
                                            <br>
                                        </div>
                                    </div>

                                <?php } ?>
                        <?php
                    }
                }
            } else {
                        ?>
                        <div class="popup-overlay">
                            <div class="popup-content">
                                <div class="entry-fees-section">
                                    <h2>Unique Code</h2>
                                    <p>
                                        Please enter the unique code that was sent to your email during registration.
                                    </p>
                                    <form method="post">
                                        <div class="footer-input-wrapper unique-code">
                                            <input type="text" name="uniquecode" required placeholder="Enter Your Code" style="width: auto;" class="footer-input">
                                        </div>
                                        <div class="btn-for-confirm" style="flex-direction: column;">
                                            <button class="confirm-button" name="uniquecode-btn" type="submit">verify</button>
                                            <a class="later-upload" href="<?= $registion_url?>">I don't have code</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                            </div>
                        </section>
        </article>
    </main>
    <?php include "assets/pages/footer.php"; ?>
</body>

</html>