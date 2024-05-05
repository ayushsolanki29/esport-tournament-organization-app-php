<?php
include '../../assets/php/config.php';

$team_name = $_POST['team_name'];

// SQL query to fetch autocomplete suggestions
$sql = "SELECT DISTINCT `team_name` FROM `teams` WHERE `team_name` LIKE '$team_name%'";
$result = $con->query($sql);

// Process and display the autocomplete suggestions
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<a class='dropdown-item' href='verifed_team.php?t=".$row['team_name']."'>".$row['team_name']."</a>";
    }
} else {
    echo "No suggestions found.";
}

?>
