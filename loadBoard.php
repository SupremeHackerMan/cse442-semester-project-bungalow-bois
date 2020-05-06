<?php
include 'config.php';
session_start();
//$currentUserName = "raygay";
$currentUserName = $_SESSION["username"];
$result = $link->query("SELECT * FROM `OnlinePlay` WHERE (`Player1` = '$currentUserName' OR  `Player2` = '$currentUserName' ) ");//checks if players saved game is there or not
$together =" ";
if ($result->num_rows == 1) {  
    while ($row = $result->fetch_assoc()) {
        $together = $row["row0"]. $row["row1"]. $row["row2"].$row["row3"].$row["row4"].$row["row5"];
    }  
}
echo $together;
?>