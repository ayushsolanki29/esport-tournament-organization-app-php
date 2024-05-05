<?php
include "assets/php/config.php";
session_start();


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Aimgod eSports - Tornaments</title>
  <?php include "assets/pages/header.php"; ?>
</head>

<body id="top">
  <?php include "assets/pages/navbar.php"; ?>
  <main>
    <article>
      <section class="hero" id="hero">
        <div class="container">

          <p class="hero-subtitle">Tornament of</p>

          <h2 class="h1 hero-title">FreeFire</h2>

          <div class="btn-group">
            <a href="<?= $registion_url ?>">
              <button class="btn btn-primary">
                <span>Register</span>
                <ion-icon name="arrow-forward-outline"></ion-icon>
                <!-- <ion-icon name="play-circle"></ion-icon> -->
              </button>
            </a>
            <a href="tornament.php">
              <button class="btn btn-link">Learn More</button>
            </a>
          </div>

        </div>
      </section>





      <div class="section-wrapper">

        <!-- 
          - #ABOUT
        -->

        <section class="about" id="about">
          <div class="container">

            <figure class="about-banner">

              <img src="./assets/images/about-img.png" alt="M shape" class="about-img">

              <img src="./assets/images/character-1.png" alt="Game character" class="character character-1">

              <img src="./assets/images/character-2.png" alt="Game character" class="character character-2">

              <img src="./assets/images/character-3.png" alt="Game character" class="character character-3">

            </figure>

            <div class="about-content">

              <p class="about-subtitle">Who WE Are?</p>

              <h2 class="about-title">eSports org. <strong>in KALOL</strong> </h2>

              <p class="about-text">

                "Discover AIMGOD eSports: Kalol's premier gaming destination where players compete, earn, and champion
                sportsmanship. Join us as we transform gaming into a thrilling sport, offering opportunities to play,
                win, and spread the joy of eSports across the city." </p>

              <a href="who-we-are.php">
                <p class="about-bottom-text">
                  <ion-icon name="arrow-forward-circle-outline"></ion-icon>
                  <span>Explore Our Story</span>
                </p>
              </a>
            </div>

          </div>
        </section>





        <!-- 
          - #TOURNAMENT
        -->

        <section class="tournament" id="tournament">
          <div class="container">

            <div class="tournament-content">
              <p class="tournament-subtitle">Discover Our Next</p>
              <h2 class="h3 tournament-title">BGMI Tournaments!</h2>
              <p class="tournament-text">Experience thrilling competitions with top players. Join now!</p>
              <button class="btn btn-primary" onclick="window.location.href = '<?= $registion_url?>'">Register Now</button>
            </div>


            <div class="tournament-prize">

              <h2 class="h3 tournament-prize-title">Prize pool</h2>

              <data value="5000">₹5000</data>

              <figure>
                <img src="./assets/images/prize-img.png" alt="Prize image">
              </figure>

            </div>

            <div class="tournament-winners">

              <h2 class="h3 tournament-winners-title">Latest Submissions</h2>
              <!-- <h2 class="h3 tournament-winners-title">#Top 2 Teams</h2> -->

              <ul class="tournament-winners-list">
                <?php

                // $query = "SELECT * FROM `winners` ORDER BY `winners`.`position` ASC   LIMIT 2";
                $query = "SELECT *   FROM `teams`  WHERE `email_verify` = 'verified' AND `payment` = 'success'  ORDER BY `teams`.`id` DESC   LIMIT 2";
                $result = mysqli_query($con, $query);
                if (mysqli_num_rows($result) == 0) {
                  echo '<p class="team_name">No Team Submited</p>';
                } else {
                

                    while ($row = mysqli_fetch_assoc($result)) { ?>
                      <li>
                        <div class="winner-card">
                          <figure class="card-banner">
                            <img src="./assets/images/profile/<?= $row['profile'] ?>"  alt="<?= $row['team_name'] ?>">
                          </figure>
                          <h3 class="h5 card-title">
                            <?= $row['team_name'] ?>
                          </h3>

                        </div>
                      </li>
                    <?php }
              
                } ?>
              </ul>

            </div>

          </div>
        </section>





        <!-- 
          - #GALLERY
        -->

        <section class="gallery">
          <div class="container">
            <h2 class="h2 section-title">Upcomming Tornaments</h2>
            <ul class="gallery-list has-scrollbar">

              <li>
                <figure class="gallery-item">
                  <img src="./assets/images/tornaments/1.png" alt="Gallery image">
                </figure>
              </li>

              <li>
                <figure class="gallery-item">
                  <img src="./assets/images/tornaments/2.png" alt="Gallery image">
                </figure>
              </li>

              <li>
                <figure class="gallery-item">
                  <img src="./assets/images/tornaments/3.png" alt="Gallery image">
                </figure>
              </li>

              <li>
                <figure class="gallery-item">
                  <img src="./assets/images/tornaments/4.png" alt="Gallery image">
                </figure>
              </li>

            </ul>

          </div>
        </section>





        <!-- 
          - #TEAM
        -->

        <section class="team" id="team">
          <div class="container">

            <h2 class="h2 section-title">Verified Teams</h2>
            <!-- <h2 class="h2 section-title">Particiapted Teams</h2> -->

            <ul class="team-list">

              <?php

              $query = "SELECT *   FROM `teams`  WHERE `email_verify` = 'verified' AND `payment` = 'success'  ORDER BY `teams`.`id` DESC LIMIT 9";
              $result = mysqli_query($con, $query);



              if (mysqli_num_rows($result) == 0) {
                echo '<p class="team_name">No Team Submited</p>';
              } else { // Loop through the fetched results and populate the HTML structure
                while ($row = mysqli_fetch_assoc($result)) {

                  echo '<li class="team_details">';
                  echo '<a href="verifed_teams.php" class="team-member">';
                  echo '<figure>';
                  echo '<img src="assets/images/profile/' . $row['profile'] . '" alt=' . $row['team_name'] . '>';
                  echo '</figure>';
                  echo '<ion-icon name="link-outline"></ion-icon>';
                  echo '</a>';
                  echo '<p class="team_name">' . $row['team_name'] . '</p>';
                  echo '</li>';
                }

                // Free the result set
                mysqli_free_result($result);

                // Close the database connection
              } ?>


            </ul>

            <a href="verifed_teams.php">
              <button class="btn btn-primary">
                <!-- view all Teams -->
                Winners List
              </button>
            </a>

          </div>
        </section>





        <!-- - #GEARS-->

        <!-- comming soon  -->





        <!-- 
          - #NEWSLETTER
        -->



      </div>

    </article>
  </main>



  <?php include "assets/pages/footer.php"; ?>

</body>

</html>