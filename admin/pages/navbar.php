
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class=" btn btn-sm btn-danger" href="logout.php" role="button">
                Logout
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

    </ul>
</nav>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index.php" class="brand-link">
        <!-- <img src="../assets/images/logo.png" alt="AdminLTE Logo" class="brand-image"> -->
        <span class="brand-text font-weight-light">Aimgod eSports</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="settings.php" class="d-block">
                    <?= "Admin" ?>
                </a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="index.php" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item" data-toggle="modal" data-target="#searchModal">
                    <a style="cursor:pointer;" class="nav-link">
                        <i class="nav-icon fas fa-search"></i>
                        <p>Search Teams
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="verifed_team.php" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Eligible Teams
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" data-toggle="modal" data-target="#notification" class="nav-link">
                        <?php 
                        $result = mysqli_query($con, "SELECT COUNT(*) AS `unread_count` FROM `notification` WHERE `status` = 'unread'"); 
                        if ($result) {
                            $row = mysqli_fetch_assoc($result);
                        }
                        ?>
                        <span class="un-count position-absolute start-10 translate-middle badge p-1 rounded-pill bg-danger" id="msgcounter">
                            <?= $row['unread_count']?></span>
                        <i class="nav-icon fas fa-bell"></i>
                        <p>
                            Notification
                        </p>
                    </a></a>
                </li>
                <li class="nav-item">
                    <a href="igl_details.php" class="nav-link">
                        <i class="nav-icon fas fa-male"></i>
                        <p>
                            Caption Details
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="winners.php" class="nav-link">
                        <i class="nav-icon fas fa-trophy"></i>
                        <p>Winners Teams
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="contact.php" class="nav-link">
                        <i class="nav-icon fas fa-comment-dots"></i>
                        <p>
                            Contact
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="settings.php" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Settings
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Search Teams</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="verifed_team.php">
                <div class="modal-body">

                    <input type="search" id="searchInput" name="t" class="form-control" oninput="getSuggestions()" placeholder="Type to search">
                    <ul id="suggestionsList" class="list-group mt-2">
                        <div id="autocompleteSuggestions">
                            <div class="dropdown-header">Suggestions</div>
                            <div id="team_data">

                            </div>
                        </div>
                    </ul>
                </div>
                <script>

                </script>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
    </div>
</div>