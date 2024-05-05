<?php
include "assets/php/config.php";
include "assets/php/function.php";
include "assets/php/send_code.php";
session_start();
$response = "";

if (isset($_POST['uniquecode-btn'])) {
    $unique_code = mysqli_real_escape_string($con, $_POST['uniquecode']);

    if ($unique_code == $_SESSION['team_label']) {
        $update_email = "UPDATE `teams` SET `email_verify`='verified' WHERE team_label='$unique_code'";
        $run_update_email = mysqli_query($con, $update_email);
        $response = "email verifed";
        $payment = "eligibale";
        setcookie("team-code", $unique_code, time() + (86400 * 30), "/"); // 86400 = 1 day
    } else {
        $response = "Code Not Match! Try Again.";
        $team_label = $_SESSION['team_label'];
    }
}
if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] === 0) {
    $filename = $_FILES['screenshot']['name'];
    $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
    $valid_extensions = ['png', 'jpg', 'jpeg'];
    $team_label = $_SESSION['team_label'];
    if (in_array(strtolower($file_ext), $valid_extensions)) {
        $destfile = 'assets/images/payment/' . $team_label . '.' . $file_ext;
        $new_file = $team_label . '.' . $file_ext;
        move_uploaded_file($_FILES['screenshot']['tmp_name'], $destfile);
        $update = "UPDATE `teams` SET `screenshot`= '$new_file' WHERE `team_label`='$team_label'";
        $result = mysqli_query($con, $update);
        if ($result) {
            sendNotification($team_label, "Just Complate Payment");
            header("location:profile.php");
        } else {
            $response = "Screenshot Not Uploaded";
        }
    } else {
        $response = "Only supported extensions are JPG, PNG, JPEG.";
    }
}
if (isset($_POST['register'])) {
    // Validate team name length (3 to 15 characters)
    $team_name = mysqli_real_escape_string($con, $_POST['team-name']);
    if (strlen($team_name) < 3 || strlen($team_name) > 25) {
        $response = "Team name must be between 3 and 25 characters long";
    } else {
        // Validate player names length (3 to 15 characters)
        $igl_name = mysqli_real_escape_string($con, $_POST['IGL_Name']);
        $first_player = mysqli_real_escape_string($con, $_POST['first_p']);
        $second_player = mysqli_real_escape_string($con, $_POST['second_p']);
        $third_player = mysqli_real_escape_string($con, $_POST['third_p']);
        $fourth_player = mysqli_real_escape_string($con, $_POST['forth_p']);
        $igl_email = mysqli_real_escape_string($con, $_POST['IGL_email']);
        $profile = mysqli_real_escape_string($con, $_POST['logo-image']);
        $player_names = array($igl_name, $first_player, $second_player, $third_player, $fourth_player);

        foreach ($player_names as $player) {
            if (strlen($player) < 3 || strlen($player) > 15) {
                $response = "Player names must be between 3 and 15 characters long";
                break; // Exit the loop if any player name is invalid
            }
        }

        // Validate WhatsApp number format (allow only mobile number)
        $igl_wa = mysqli_real_escape_string($con, $_POST['IGL_wa']);
        if (!preg_match('/^\d{10}$/', $igl_wa)) {
            $response = "Invalid WhatsApp number format";
        } else {
            $select_query = "SELECT `team_name` FROM `teams` WHERE team_name = '$team_name'";
            $select_result = mysqli_query($con, $select_query);

            if (mysqli_num_rows($select_result) > 0) {
                $response = "Team name already exists";
            } else {
                $team_label = generateRandomToken();
                $insert_query = "INSERT INTO `teams`(`team_name`, `igl_name`, `igl_email`, `igl_wa`, `f_player`, `s_player`, `t_player`, `frth_player`, `profile`,`team_label`) 
                VALUES ('$team_name','$igl_name','$igl_email','$igl_wa','$first_player','$second_player','$third_player','$fourth_player','$profile','$team_label')";

                $insert_result = mysqli_query($con, $insert_query);

                $update_profile = "UPDATE `profile` SET `status`='used' WHERE `picture`='$profile'";
                mysqli_query($con, $update_profile);


                if ($insert_result) {
                    $_SESSION['team_label'] = $team_label;
                    sendNotification($team_label, "Just Create a Team");
                    sendOtp($igl_email, 'Team Code - Registation for Tornament', $team_label, $igl_name, 'Feb - 2024', 'send-otp.html');
                    $response = "Team Code sended on your Email";
                } else {
                    $response = "something wrong try again!";
                }
            }
        }
    }
}

function generateRandomToken($length = 6)
{
    $token = '';
    $characters = '0123456789ABCXYZ';

    $max = strlen($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[random_int(0, $max)];
    }
    return $token;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="login-assets/css/swiper.css" />
    <link rel="stylesheet" href="login-assets/css/style.css" />
    <script src="login-assets/js/swiper.js"></script>
    <script src="login-assets/js/script.js" defer></script>
    <title>Register | Aimgod eSports Tornaments</title>
    <?php include "assets/pages/header.php"; ?>
</head>

<body>
    <?php if (!isset($_COOKIE['confirmation'])) { ?>

        <div class="popup-overlay" id="popupOverlay">
            <div class="popup-content">
                <div class="entry-fees-section">
                    <h2>ENTRY FEES : 50₹</h2>
                    <p>Full Team Entry</p>
                    <p>Please confirm that you agree to the <a href="tornament.php" class="rules-agree">terms & conditions.</a> </p>
                    <div class="btn-for-confirm">
                        <button class="continue-button" onclick="showRulesSection()">Continue</button>
                    </div>
                </div>
                <div class="rules-section">
                    <h2>Rules Confirmation</h2>
                    <p>Please confirm that you have read and agree to <a href="rules.php" class="rules-agree"> the rules. </a></p>
                    <div class="btn-for-confirm">
                        <button class="confirm-button" onclick="closePopup()">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php include "assets/pages/navbar.php"; ?>
    <?php if (isset($_GET['t']) && isset($_SESSION['register-token'])) {
        $get_token = $_GET['t'];
        $store_token = $_SESSION['register-token'];

        if ($get_token == $store_token) { ?>
            <div class="app apex">
                <div class="app__slider swiper">
                    <div class="app__slider swiper">
                        <div class="app__slider-wrapper swiper-wrapper">
                            <div class="app__slider-slide swiper-slide">
                                <img src="login-assets/images/ApexLegends.jpg" alt="Apex Legends" />
                            </div>
                            <div class="app__slider-slide swiper-slide">
                                <img src="login-assets/images/Valorant.jpg" alt="Valorant" />
                            </div>
                            <div class="app__slider-slide swiper-slide">
                                <img src="login-assets/images/CyberPunk.jpg" alt="CyberPunk" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="app__form-wrapper">
                    <div class="app__form-container d-flex align-center">

                        <form class="form login-form d-flex f-column show" method="post">


                            <div class="form__header">
                                <p class="form__title">Register Team</p>
                                <p class="form__subtitle">Create a Team For Tornament</p>
                            </div>
                            <?php if ($response) { ?>
                                <div class="notificion">
                                    <div class="info">
                                        <div class="info__icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" height="24" fill="none">
                                                <path fill="#393a37" d="m12 1.5c-5.79844 0-10.5 4.70156-10.5 10.5 0 5.7984 4.70156 10.5 10.5 10.5 5.7984 0 10.5-4.7016 10.5-10.5 0-5.79844-4.7016-10.5-10.5-10.5zm.75 15.5625c0 .1031-.0844.1875-.1875.1875h-1.125c-.1031 0-.1875-.0844-.1875-.1875v-6.375c0-.1031.0844-.1875.1875-.1875h1.125c.1031 0 .1875.0844.1875.1875zm-.75-8.0625c-.2944-.00601-.5747-.12718-.7808-.3375-.206-.21032-.3215-.49305-.3215-.7875s.1155-.57718.3215-.7875c.2061-.21032.4864-.33149.7808-.3375.2944.00601.5747.12718.7808.3375.206.21032.3215.49305.3215.7875s-.1155.57718-.3215.7875c-.2061.21032-.4864.33149-.7808.3375z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="info__title">
                                            <?= $response; ?>
                                        </div>
                                        <div class="info__close"><svg height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="m15.8333 5.34166-1.175-1.175-4.6583 4.65834-4.65833-4.65834-1.175 1.175 4.65833 4.65834-4.65833 4.6583 1.175 1.175 4.65833-4.6583 4.6583 4.6583 1.175-1.175-4.6583-4.6583z" fill="#393a37"></path>
                                            </svg></div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php
                            $team_image = "";
                            $select_img = "SELECT picture FROM profile WHERE status = 'unused' ORDER BY RAND() LIMIT 1;";
                            $run_select_img = mysqli_query($con, $select_img);
                            while ($row_image = mysqli_fetch_assoc($run_select_img)) {
                                $team_image = $row_image['picture'];
                            }

                            ?>
                            <div class="team-logo-reg">
                                <p class="form__subtitle">Team Logo :</p>
                                <img src="assets/images/profile/<?= $team_image ?>" id="team-logo-reg" alt="Logo">
                                <input type="hidden" id="team-logo-reg-input" name="logo-image" value="<?= $team_image ?>">
                            </div>
                            <div class="form__group d-flex f-column r-gap-1">
                                <div class="form__group d-flex f-column r-gap-2">
                                    <div class="form__field">
                                        <input type="text" class="form__input" name="team-name" required placeholder="Enter Team Name" />
                                        <div class="form__input-border"></div>
                                    </div>
                                    <p class="form__subtitle">In Game Leader's Details</p>
                                    <div class="form__field">
                                        <input type="text" class="form__input" name="IGL_Name" required placeholder="Enter IGL Name" />
                                        <div class="form__input-border"></div>
                                    </div>
                                    <div class="form__field">
                                        <input type="email" class="form__input" required name="IGL_email" placeholder="Enter IGL's Email" />
                                        <div class="form__input-border"></div>
                                    </div>
                                    <div class="form__field">
                                        <input type="text" class="form__input" required name="IGL_wa" placeholder="Enter IGL's whatsapp" />
                                        <div class="form__input-border"></div>
                                    </div>
                                    <p class="form__subtitle">Team Details</p>
                                    <div class="form__field">
                                        <input type="text" required class="form__input" name="first_p" placeholder="Enter 1st Player Name" />
                                        <div class="form__input-border"></div>
                                    </div>
                                    <div class="form__field">
                                        <input type="text" required class="form__input" name="second_p" placeholder="Enter 2nd Player Name" />
                                        <div class="form__input-border"></div>
                                    </div>
                                    <div class="form__field">
                                        <input type="text" required class="form__input" name="third_p" placeholder="Enter 3rd Player Name" />
                                        <div class="form__input-border"></div>
                                    </div>
                                    <div class="form__field">
                                        <input type="text" required class="form__input" name="forth_p" placeholder="Enter 4th Player Name" />
                                        <div class="form__input-border"></div>
                                    </div>
                                </div>
                                <div class="form__group d-flex align-center c-gap-1">
                                    <div class="form__check">
                                        <input type="checkbox" required class="form__checkbox d-flex align-center justify-center" id="terms" required />
                                        <div class="form__checkbox-border"></div>
                                    </div>
                                    <label for="terms" class="form__label"> I agree the <a href="rules.php" class="form__link" style="display:inline-block">terms & privacy</a> </label>
                                </div>
                                <!-- <a href="#" class="form__link">forgot password?</a> -->
                            </div>
                            <div class="form__group d-flex f-column r-gap-2">
                                <!-- <button class="form__button filled d-flex align-center justify-center" id="login-btn">
<div class="form__button-bg d-flex align-center justify-center"><p>log in</p></div>
<div class="form__button-border"></div>
</button> -->
                                <button type="submit" name="register" class="form__button outlined d-flex align-center justify-center" id="signup-btn">
                                    <div class="form__button-bg d-flex align-center justify-center">
                                        <p>Register Now</p>
                                    </div>
                                    <div class="form__button-border"></div>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Popup overlays -->
            <?php
            if (isset($team_label)) { ?>
                <div class="popup-overlay">
                    <div class="popup-content">
                        <div class="entry-fees-section">
                            <h2>Team Code</h2>
                            <br>
                            <p style="color:red;">
                                <?= $response ?>
                            </p>
                            <br>
                            <form method="post">
                                <div class="footer-input-wrapper unique-code">
                                    <input type="text" name="uniquecode" required placeholder="Enter Your Code" style="width: auto;" class="footer-input">
                                </div>
                                <div class="btn-for-confirm">
                                    <button class="confirm-button" name="uniquecode-btn" type="submit">verify</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php
            if (isset($payment)) {
            ?>
                <div class="popup-overlay">
                    <div class="popup-content">
                        <div class="entry-fees-section">
                            <h2>Pay 50₹</h2>
                            <p>Entry Fees for Your Team</p>

                            <div class="qr-code">
                                <img src="assets/images/payment/qr.png" alt="qr">

                            </div>
                            <br>
                            or
                            <div class="btn-for-confirm">
                                <a href="upi://pay?pa=nayakvraj0303@okicici&pn=Vraj%20Nayak&am=50.00&cu=INR&aid=uGICAgIDLnsTJag">
                                    <button class="confirm-button" type="button">Pay Now 50₹</button>
                                </a>
                            </div>
                            <br>
                            <p id="countdown-payment">60 secounds</p>
                            <script>
                                var seconds = 60;

                                function updateCountdown() {
                                    document.getElementById('countdown-payment').innerHTML = seconds + ' seconds Left';
                                    seconds--;

                                    if (seconds < 0) {
                                        window.location.href = "register.php?t=<?= $get_token ?>&fileupload=true";
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
                            <h2>Screenshot Upload</h2>
                            <p>Please Upload Screenshot of your Payment</p>
                            <br>
                            <p style="color:red;">
                                <?= $response ?>
                            </p>
                            <br>
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

        <?php } else { ?>
            <script>
                alert('Token Not Match');
                alert('Redirecting to Home page');
                window.location.href = 'index.php';
            </script>
        <?php }
    } else { ?>
        <!-- Registration Closed Section -->
        <div class="section-wrapper">
            <section class="about" id="about">
                <div class="container">
                    <div class="about-content registation-close">

                        <p class="about-subtitle registation-close-subtitle">Registration Closed</p>

                        <h2 class="about-title registation-close-title">WE ARE <strong>SORRY!!</strong> </h2>

                        <p class="about-text">
                            We apologize, but the registration process is currently closed. Thank you for your
                            understanding.
                        </p>

                        <p class="about-bottom-text">
                            <ion-icon name="arrow-forward-circle-outline"></ion-icon>
                            <a href="verifed_teams.php">
                                <span>Check Winners List</span></a>
                        </p>
                    </div>
                </div>
            </section>
        </div>
    <?php } ?>

    <?php include "assets/pages/footer.php"; ?>
</body>

</html>