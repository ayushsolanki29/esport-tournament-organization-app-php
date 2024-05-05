<?php
include "assets/php/config.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Aimgod eSports - Tornaments</title>
    <?php include "assets/pages/header.php"; ?>
</head>

<body id="top">
    <main>
        <article>
            <?php include "assets/pages/navbar.php"; ?>
            <br><br>
            <section class="team section-wrapper" id="team">
                <div class="container">

                    <!-- <h2 class="h2 section-title">Winners List</h2> -->
                    <h2 class="h2 section-title">Verified Teams</h2>

                    <div class="verified-teams">

                        <?php

                        $query = "SELECT * FROM `teams` WHERE `email_verify` = 'verified' AND `payment` = 'success' ORDER BY `teams`.`id` DESC;";
                        // $query = "SELECT * FROM `winners` ORDER BY `winners`.`position` ASC";
                        $result = mysqli_query($con, $query);


                        if (mysqli_num_rows($result) == 0) {
                            echo '<p class="team_name">No Team Submited</p>';
                        } else {

                            while ($row = mysqli_fetch_assoc($result)) {
                                // $team_id_select = $t_data['team_id'];
                                // $select_team = "SELECT * FROM `teams`  WHERE `id` = $team_id_select";
                                // $res_team = mysqli_query($con, $select_team);
                                // $row = mysqli_fetch_assoc($res_team); ?>


                                <div class="accordion section-wrapper ">
                                    <div class="accordion-item accordion-title <?php
                                    if (isset($_COOKIE['team-code'])) {
                                        if ($_COOKIE['team-code'] == $row['team_label']) {
                                            echo "accordion-item-team";
                                        }
                                    }
                                    ?>">
                                        <div class="accordion-head">
                                             <!-- <h2 style="margin-left:5px;"> <?php 
                                // if ($t_data['position'] == 1 ) {
                                //     echo $t_data['position'] . 'st';
                                // }elseif ($t_data['position'] == 2) {
                                //     echo $t_data['position'] . 'nd';
                                // }elseif ($t_data['position'] == 3) {
                                //     echo $t_data['position'] . 'rd';
                                // }else{
                                //     echo $t_data['position'] . 'th';
                                // }
                                
                                ?></h2> -->
                                            <img src="assets/images/profile/<?= $row['profile'] ?>"
                                                alt="<?= $row['team_name'] ?>">
                                            <div class="h3 tournament-title ">
                                                <?= $row['team_name'] ?>
                                            </div>
                                        </div>
                                        <div class="accordion-content">
                                            <ul class="player-list">
                                                <li><b class="player-details"> Player 1 : </b>
                                                    <?= $row['f_player'] ?>
                                                </li>
                                                <li><b class="player-details">Player 2 :</b>
                                                    <?= $row['s_player'] ?>
                                                </li>
                                                <li><b class="player-details"> Player 3 :</b>
                                                    <?= $row['t_player'] ?>
                                                </li>
                                                <li><b class="player-details"> Player 4 :</b>
                                                    <?= $row['frth_player'] ?>
                                                </li>

                                            </ul>
                                            <br>
                                            <p><b class="player-details"> Team Captain: </b>
                                                <?= $row['igl_name'] ?>
                                            </p>
                                            <br>
                                            <p title="<?= $row['date'] ?>"><b class="player-details">Registered : </b>
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
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php }

                            // Free the result set
                            mysqli_free_result($result);

                            // Close the database connection
              
                        } ?>
                    </div>
                </div>
            </section>
        </article>
    </main>
    <?php include "assets/pages/footer.php"; ?>

</body>

</html>