<?php
include "assets/php/config.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Aimgod eSports - Who we are</title>
    <?php include "assets/pages/header.php"; ?>
    <style>
        .about-us-page {
            color: #fff;
        }

        .highlighter {
            color: hsl(31, 100%, 51%);
            padding: 10px;
        }
    </style>
</head>

<body id="top">
    <main>
        <article>
            <?php include "assets/pages/navbar.php"; ?>
            <br><br>
            <section class="team section-wrapper" id="team">
                <div class="container about-us-page">

                    <h2 class="h2 section-title">Welcome to AIMGOD eSports</h2>
                    <p>At AIMGOD eSports, we're passionate about gaming and committed to fostering a vibrant gaming
                        community in Kalol and beyond. We believe that gaming is more than just a pastime; it's a
                        thrilling sport that brings people together, fosters camaraderie, and promotes healthy
                        competition.</p>

                    <section>
                        <h2 class="highlighter">Our Mission</h2>
                        <p>Our mission is to provide Kalol's gaming enthusiasts with a premier destination where they
                            can unleash their skills, compete at the highest level, and experience the excitement of
                            eSports. We aim to create a platform that not only offers thrilling gaming experiences but
                            also promotes sportsmanship, integrity, and fair play.</p>
                    </section>
                    <section>
                        <h2 class="highlighter">What We Offer</h2>
                        <p>At AIMGOD eSports, we offer a wide range of gaming opportunities for players of all skill
                            levels. Whether you're a casual gamer looking to have fun with friends or a seasoned
                            competitor aiming for glory, we have something for everyone. From regular tournaments and
                            leagues to casual gaming sessions and community events, there's always something happening
                            at AIMGOD eSports.</p>
                    </section>
                    <section>
                        <h2 class="highlighter">Join Us</h2>
                        <p>We invite you to join us on our journey as we transform gaming into a thrilling sport and
                            spread the joy of eSports across Kalol and beyond. Whether you're a player, a fan, or simply
                            curious about the world of eSports, there's a place for you at AIMGOD eSports. Come be a
                            part of our growing community and experience the excitement of competitive gaming like never
                            before!</p>
                    </section>
                </div>
            </section>
        </article>
    </main>

    <?php include "assets/pages/footer.php"; ?>

</body>

</html>