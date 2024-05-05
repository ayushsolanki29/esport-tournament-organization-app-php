
<?php 
$select_settings = "SELECT `data1`, `data2` FROM `settings` WHERE id=2";
$result_settings = mysqli_query($con, $select_settings);
if(mysqli_num_rows($result_settings) == 0){
    die("Error: No registation found!");
}else{
    while ($row = mysqli_fetch_assoc($result_settings)) {
        $status = stripslashes($row['data1']);
        if ($status == "start") {
          $token = stripslashes($row['data2']);
          $_SESSION['register-token'] = urlencode($token);
          $registion_url = "register.php?active=yes&t=" . urlencode($token);
        }else{
          $registion_url = "register.php";
        }
    }
}?>
<header class="header">

    <!-- 
      - overlay
    -->
    <div class="overlay" data-overlay></div>

    <div class="container">

      <a href="index.php" class="logo">
        <img src="./assets/images/logo.png" alt="GameX logo">
      </a>

      <button class="nav-open-btn" data-nav-open-btn>
        <ion-icon name="menu-outline"></ion-icon>
      </button>

      <nav class="navbar" data-nav>

        <div class="navbar-top">

          <a href="index.php" class="logo">
            <img src="./assets/images/logo.svg" alt="GameX logo">
          </a>

          <button class="nav-close-btn" data-nav-close-btn>
            <ion-icon name="close-outline"></ion-icon>
          </button>

        </div>

        <ul class="navbar-list">

          <li>
            <a href="index.php#hero" class="navbar-link">Home</a>
          </li>

          <li>
            <a href="index.php#about" class="navbar-link">About</a>
          </li>

          <li>
            <a href="index.php#tournament" class="navbar-link">Tournament</a>
          </li>

          <li>
            <a href="index.php#team" class="navbar-link">Team</a>
          </li>

          <li>
            <a href="profile.php" class="navbar-link">My Team</a>
          </li>
          <li>
            <a href="contact.php" class="navbar-link">Contact</a>
          </li>

        </ul>

        <ul class="nav-social-list">

          <li>
            <a href="https://chat.whatsapp.com/GTAcQ60U1OsC6sN9uFdGYT" class="social-link">
              <ion-icon name="logo-whatsapp"></ion-icon>
            </a>
          </li>

          <li>
            <a href="https://www.instagram.com/org_aimgod?utm_source=qr&igsh=MTM5MTlseDlpOWx3dQ==" class="social-link">
              <ion-icon name="logo-instagram"></ion-icon>
            </a>
          </li>

          <li>
            <a href="https://youtube.com/@AimgodE-Sports?si=gywXm1OM6wdPWvaf" class="social-link">
              <ion-icon name="logo-youtube"></ion-icon>
            </a>
          </li>

          <li>
            <a href="https://discord.gg/FckbdBgD7g" class="social-link">
              <ion-icon name="logo-discord"></ion-icon>
            </a>
          </li>

        </ul>

      </nav>

      <div class="header-actions">
<a href="profile.php">
        <button class="search">
          <ion-icon name="game-controller-outline"></ion-icon>
        </button>
        </a>
        <a href="<?= $registion_url?>" target="blank">
        <button class="btn-sign_in">

          <div class="icon-box">
            <ion-icon name="log-in-outline"></ion-icon>
          </div>

         <span>Register</span>

        </button>
        </a> 
      </div>

    </div>

  </header>