
  <!-- 
    - #FOOTER
  -->

  <footer>

    <div class="footer-top">
      <div class="container">

        <div class="footer-brand-wrapper">

          <a href="#" class="logo">
            <img src="./assets/images/logo.svg" alt="GameX logo">
          </a>

          <div class="footer-menu-wrapper">

            <ul class="footer-menu-list">

              <li>
                <a href="rules.php" class="footer-menu-link">Rules</a>
              </li>

              <li>
                <a href="who-we-are.php" class="footer-menu-link">Who we are?</a>
              </li>

              <li>
                <a href="tornament.php" class="footer-menu-link">Tournament Details</a>
              </li>

              <li>
                <a href="verifed_teams.php" class="footer-menu-link">Verifed Teams</a>
              </li>
              <li>
                <a href="profile.php" class="footer-menu-link">My Team Status</a>
              </li>

              <li>
                <a href="contact.php" class="footer-menu-link">Contact us</a>
              </li>

            </ul>

          </div>

        </div>

        <div class="footer-quicklinks">

          <ul class="quicklink-list">

            <li>
              <a href="#" class="quicklink-item">Faq</a>
            </li>

            <li>
              <a href="#" class="quicklink-item">Help center</a>
            </li>

            <li>
              <a href="#" class="quicklink-item">Terms of use</a>
            </li>

            <li>
              <a href="#" class="quicklink-item">Privacy</a>
            </li>

          </ul>

          <ul class="footer-social-list">

            <li>
              <a href="https://discord.gg/FckbdBgD7g" class="footer-social-link">
                <ion-icon name="logo-discord"></ion-icon>
              </a>
            </li>

            <li>
              <?php 
               $whatsappJoin = mysqli_query($con, "SELECT  `data1` FROM `settings` WHERE `id`='4'");
               $joinURL = mysqli_fetch_assoc($whatsappJoin);?>
              <a href="<?=  $joinURL['data1']?>" class="footer-social-link">
                <ion-icon name="logo-whatsapp"></ion-icon>
              </a>
            </li>

            <li>
              <a href="https://www.instagram.com/org_aimgod?utm_source=qr&igsh=MTM5MTlseDlpOWx3dQ==" class="footer-social-link">
                <ion-icon name="logo-instagram"></ion-icon>
              </a>
            </li>

            <li>
              <a href="https://youtube.com/@AimgodE-Sports?si=gywXm1OM6wdPWvaf" class="footer-social-link">
                <ion-icon name="logo-youtube"></ion-icon>
              </a>
            </li>

          </ul>

        </div>

      </div>
    </div>

    <div class="footer-bottom">
      <div class="container">
        <p class="copyright">
          Copyright &copy; 2024 <a href="#">aimgodesports</a>. all rights reserved
        </p>

        <figure class="footer-bottom-img">
          <img src="./assets/images/footer-bottom-img.png" alt="Online payment companies logo">
        </figure>
      </div>
    </div>

  </footer>





  <!-- 
    - #GO TO TOP
  -->

  <a href="#top" class="btn btn-primary go-top" data-go-top>
    <ion-icon name="chevron-up-outline"></ion-icon>
  </a>





  <!-- 
    - custom js link
  -->
  <script src="./assets/js/script.js"></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
