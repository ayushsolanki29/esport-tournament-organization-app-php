<?php
include "assets/php/config.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Aimgod eSports - Tornaments</title>
    <?php include "assets/pages/header.php"; ?>
    <style>
        .main {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 20px;
        }

        .tournament-card {
            background-color: hsl(231, 12%, 12%);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            width: 45%;
            color: #fff;
        }

        .card-heading {
            background-color: hsl(231, 12%, 12%);
            color: #fff;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid white;
        }

        .card-heading h2 {
            margin: 0;
        }

        .card-heading img {
            max-width: 50px;
        }

        .card-details {
            padding: 20px;
        }

        .card-details p {
            margin: 0 0 10px;
        }

        .card-details strong {
            font-weight: bold;
        }

        .card-details ul {
            list-style-type: none;
            padding-left: 0;
        }

        .card-actions {
            padding: 20px;
            text-align: center;
        }

        .btn-register {
            background-color: hsl(31, 100%, 51%);
            ;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            padding: 10px 20px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn-register:hover {
            background-color: hsl(25, 100%, 51%);
            ;
        }

        .highlighter {
            color: hsl(31, 100%, 51%);
        }

        .image-container {
            max-width: 100%;
            height: auto;
       
   
        }

        /* Optional: Center the image vertically and horizontally */
        .image-container img {
            display: block;
            margin: 0 auto;
            max-height: 100%;
            max-width: 70%;
        }
        .image-container p{
            text-align: center;
            margin-top: 10px;
            color: white;
            font-weight: 500;
            font-size: 18px;
        }
    </style>
</head>

<body id="top">
    <main>
        <article>
            <?php include "assets/pages/navbar.php"; ?>
            <br><br>
            <section class="team section-wrapper" id="team">
                <div class="container ">

                    <h2 class="h2 section-title">Free Fire - tornament</h2>
                    <div class="main">
                        <section class="tournament-card">
                            <div class="card-heading">
                                <h2>Game: Free Fire MAX</h2>
                            </div>
                            <div class="card-details">
                                <p><strong class="highlighter">Match Date :</strong> April 27, 2024</p>
                                <p><strong class="highlighter">Entry Fee:</strong> 60 INR per team</p>
                                <p><strong class="highlighter">Prize Pool:</strong> 2000 Cash INR + 3000 Worth Rewards</p>
                                <p><strong class="highlighter">Who Can Participate:</strong> Open to all players aged 16
                                    and above</p>
                                <p><strong class="highlighter">Registration Deadline:</strong> April 25, 2024</p>
                            </div>
                            <div class="card-actions">
                                <a href="<?= $registion_url ?>" class="btn-register">Register Now</a>
                            </div>
                        </section>
                        <section class="tournament-card">
                            <div class="card-heading">
                                <h2>Tornamet End Date: April 28, 2024</h2>
                            </div>
                            <div class="card-details">
                                <p><strong class="highlighter">Prize Distribution:</strong> Winners will receive their
                                    prizes within 7 days
                                    of
                                    tournament conclusion</p>
                                <p><strong class="highlighter">Rules:</strong></p>
                                <ul>
                                    <li>All matches will be played in TPP (Third Person Perspective) mode</li>
                                    <li>Teams must adhere to fair play rules and sportsmanship guidelines</li>
                                    <li>Cheating, hacking, or exploiting bugs will result in immediate disqualification
                                    </li>
                                </ul>
                                <p><strong class="highlighter">Contact:</strong> For any inquiries, <a
                                     style="display: inline-block;text-decoration:underline;" class="highlighter"   href="contact.php">contact us</a> </p>
                            </div>
                        </section>
                    </div>
                    <div class="image-container">
                 
                    </div>
                </div>
            </section>
            </div>
        </article>
    </main>

    <?php include "assets/pages/footer.php"; ?>

</body>

</html>