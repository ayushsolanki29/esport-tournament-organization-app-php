<?php
include "assets/php/config.php";
include "assets/php/function.php";
session_start();

if (isset($_COOKIE['team-code'])) {
    $team_code = $_COOKIE['team-code'];
    sendNotification("$team_code", "Just Readed Rules");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Aimgod eSports - Rules</title>
    <?php include "assets/pages/header.php"; ?>
    <style>
        .rules-of-party {
            list-style-type: none;
            padding: 0;
            color: #fff;
        }

        .rules-of-party li {
            margin-bottom: 15px;
        }

        .rules-of-party li:before {
            content: "•";
            color: #ff6f61;
            display: inline-block;
            width: 1em;
            margin-left: -1em;
        }

        .highlighter {
            color: hsl(31, 100%, 51%);
            ;
        }
    </style>

</head>

<body id="top">
    <main>
        <article>
            <?php include "assets/pages/navbar.php"; ?>
            <br><br><br><br>
            <section class="team section-wrapper" id="team">
                <div class="container">

                    <h2 class="h2 section-title">rules of participate</h2>
                    <ul class="rules-of-party">
                        <li><strong class="highlighter">Entry Fee:</strong> Each team must pay an entry fee of <strong
                                class="highlighter"> 50 INR</strong> to participate in the tournament.</li>
                        <li><strong class="highlighter">Team Composition:</strong> Each team must consist of a minimum
                            of <strong class="highlighter"> 4 players and a maximum of 5 players. </strong></li>
                        <li><strong class="highlighter">Registration:</strong> Teams must register before the specified
                            deadline to be eligible for participation. Late registrations may not be accepted.</li>
                        <li><strong class="highlighter">Payment:</strong> The entry fee must be paid in full at the time
                            of registration. Failure to pay the entry fee will result in disqualification.</li>
                        <li><strong class="highlighter">Fair Play:</strong> Participants are expected to uphold the
                            principles of fair play and sportsmanship throughout the tournament. Cheating, hacking, or
                            exploiting game bugs will result in immediate disqualification.</li>
                        <li><strong class="highlighter">Match Schedule:</strong> The tournament schedule, including
                            match timings and brackets, will be provided to all registered teams prior to the start of
                            the tournament. Teams must adhere to the schedule and be present for their matches on time.
                        </li>
                        <li><strong class="highlighter">Streaming and Recording:</strong> Participants may be required
                            to stream or record their gameplay for verification purposes. Failure to do so may result in
                            disqualification.</li>
                        <li><strong class="highlighter">Prize Distribution:</strong> Prizes will be awarded to the
                            winning team(s) as per the tournament organizer's discretion. The distribution of prizes
                            will be announced prior to the start of the tournament.</li>
                        <li><strong class="highlighter">Disputes:</strong> Any disputes or disagreements regarding
                            gameplay, rules, or conduct must be brought to the attention of the tournament organizers
                            immediately. Decisions made by the organizers are final and binding.</li>
                        <li  ><strong class="highlighter">Code of Conduct:</strong> Participants are expected to behave
                            respectfully towards fellow competitors, organizers, and spectators. Any form of harassment
                            or unsportsmanlike behavior will not be tolerated and may result in disqualification.</li>
                        <li id="for-after-match-rules"><strong class="highlighter">Changes to Rules:</strong> The tournament organizers reserve the
                            right to make changes to the rules or format of the tournament at any time, with or without
                            prior notice, to ensure fair play and smooth operation.</li>
                        <li ><strong class="highlighter">Liability:</strong> The organizers are not responsible for any
                            injuries, damages, or losses incurred by participants during the course of the tournament.
                        </li>
                        <li><strong class="highlighter">Agreement:</strong> By registering for the tournament,
                            participants agree to abide by all the rules and conditions outlined herein.</li>
                      <br>
                      <h3 >For Final Match Day</h3><br>
                            <li><strong class="highlighter">Payment Method:</strong> Prize winnings will be transferred via
                            UPI (Unified Payments Interface) only.
                            Teams must provide their UPI ID at the time of registration. Failure to provide a valid UPI
                            ID
                            will result in disqualification from prize eligibility.</li>
                        <li><strong class="highlighter"> Verification Code:</strong>For teams ranking in the top 10, a
                            verification code will be sent to the
                            email address provided during registration. Teams must provide this code upon request for
                            prize
                            distribution. Failure to provide the verification code will result in forfeiture of prize
                            winnings. </li>
                        <li><strong class="highlighter">Additional Prize Rules:</strong> Prize winnings are
                            non-transferable and non-exchangeable.
                        <li>
                            Prize distribution is subject to verification of eligibility and compliance with tournament
                            rules. </li>
                        <li> The organizers reserve the right to withhold prize winnings if any discrepancies or
                            violations
                            of rules are found.</li>
                        <li> Prize distribution timelines may vary and are subject to change at the discretion of the
                            organizers.
                        <li> Taxes, if applicable, are the responsibility of the prize winners.
                            By accepting prize winnings, participants grant permission for their team name and likeness
                            to
                            be used for promotional purposes by the tournament organizers.
                            In the event of a tie or dispute regarding prize distribution, the decision of the
                            tournament
                            organizers is final and binding. </li>
                        <li> Participants are advised to review and understand all rules and conditions before
                            registering
                            for the tournament. </li>








                    </ul>
                </div>
            </section>
        </article>
    </main>

    <?php include "assets/pages/footer.php"; ?>

</body>

</html>