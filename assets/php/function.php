<?php 
function sendNotification($team_name , $message) {
    global $con;
    $query = "INSERT INTO `notification`(`team_name`, `message`) VALUES ('$team_name','$message')";
    mysqli_query($con, $query);
}
function seenNotification() {
    global $con;
    $query = "UPDATE `notification` SET `status`='read' WHERE 1";
    mysqli_query($con, $query);
}
function teamname($code) {
    global $con;
    $query = "SELECT * FROM `teams` WHERE `team_label`= '$code' ";
    $result = mysqli_query($con, $query);
    // Check if team exists
    if(mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result); // Return team details if found
    } else {
        //Return some value if team is not found

        return null; // Return null if team is not found
    }
}


?>