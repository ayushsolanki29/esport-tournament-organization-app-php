<?php
include "assets/php/config.php";
include "assets/php/function.php";
$response = "";
session_start();
if (isset($_POST['contact'])) {
    $name= mysqli_real_escape_string($con, $_POST['name']);
    $email= mysqli_real_escape_string($con, $_POST['email']);
    $query= mysqli_real_escape_string($con, $_POST['query']);
    $message= mysqli_real_escape_string($con, $_POST['message']);

    $instert = "INSERT INTO `contact`( `name`, `email`, `query`, `message`) VALUES ('$name','$email','$query','$message')";
    $run = mysqli_query($con, $instert);
    if ($run) {
        $response = "true";
        sendNotification("$name", "Trying to Contact");
    }else{
        $response = "false";
        sendNotification("$name", "Trying to Contact");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Aimgod eSports - Tornaments</title>
    <?php include "assets/pages/header.php"; ?>
    <style>
        .contact-us {
            display: flex;
            justify-content: space-around;
            padding: 20px;
            color: white;
        }

        .contact-form {
            flex: 1;
            max-width: 400px;
        }

        .contact-form h2 {
            margin-top: 0;
        }

        .contact-form form {
            display: flex;
            flex-direction: column;
        }

        .contact-form .form-group {
            margin-bottom: 20px;
        }

        .contact-form label {
            font-weight: bold;
        }

        .contact-form input[type="text"],
        .contact-form input[type="email"],
        .contact-form textarea,
        .contact-form select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .contact-form select, .contact-form option{
            font-size: 16px;
            margin-top: 2px;
        }
        .contact-form textarea {
            resize: vertical;
        }

        .contact-form button {
            padding: 10px 20px;
            background-color: hsl(31, 100%, 51%);
            ;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .contact-info {
            flex: 1;
            max-width: 400px;
        }

        .contact-info h2 {
            margin-top: 0;
        }

        .contact-info ul {
            list-style: none;
            padding: 0;
        }

        .contact-info ul li {
            margin-bottom: 10px;
        }
        .highlighter {
            color: hsl(31, 100%, 51%);
        }
        .alert{
            padding: 10px;
            color: #fff;
            border-radius: 10px;
            width: 500px;
            margin: 0 auto;
        }
        .success{
            background:#14A44D;
        }
        .danger{
            background:  #DC3545;
        }
    </style>
</head>

<body id="top">
    <main>
        <article>
            <?php include "assets/pages/navbar.php"; ?>
            <br><br>
            <section class="team section-wrapper" id="team">
                <div class="container">

                    <h2 class="h2 section-title">contact us</h2>
                    <?php if ($response == "true") { ?>
                        <div class="alert success">
                        <p>Form Submited Successfully !!</p>
                    </div>
                   <?php }else if($response == "false"){
                    ?>
                    <div class="alert danger">
                    <p>Faild To Submit !!</p>
                </div>
               <?php
                   } ?>
                    
                    <div class="contact-us">
                        <section class="contact-form ">
                            <h2  class="highlighter">Send us a Message</h2>
                            <br>
                            <form  method="POST">
                                <div class="form-group">
                                    <label for="name">Your Name:</label>
                                    <input type="text" id="name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Your Email:</label>
                                    <input type="email" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Query:</label>
                                    <select name="query" >
                                        <option selected disabled>Select you Query</option>
                                        <option value="contact admin">Contact admin</option>
                                        <option value="registration  issue">Registration  issue</option>
                                        <option value="Entry Fees">Entry Fees</option>
                                        <option value="Report a Bug">Report a Bug</option>
                                        <option value="other">other</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="message">Message:</label>
                                    <textarea id="message" name="message" rows="4" required></textarea>
                                </div>
                                <button type="submit" name="contact">Send Message</button>
                            </form>
                        </section>
                        <section class="contact-info">
                            <h2 class="highlighter">Contact Information</h2>
                            <br>
                            <ul>
                                <li><strong>Whatsapp Group : </strong><a  style="display:inline-block" href="#"> Join Group</a></li>
                                <li><strong>Email : </strong> <a   style="display:inline-block" href="mailto:aimgodmanagement@gmail.com"> aimgodmanagement@gmail.com</a></li>
                            </ul>
                        </section>
                    </div>
                </div>
            </section>
        </article>
    </main>

    <?php include "assets/pages/footer.php"; ?>

</body>

</html>