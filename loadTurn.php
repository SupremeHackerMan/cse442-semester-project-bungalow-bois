<?php
include 'config.php';
session_start();
$currentUserName = $_SESSION["username"];
$result = $link->query("SELECT Turn FROM `OnlinePlay` WHERE (`Player1` = '$currentUserName' OR  `Player2` = '$currentUserName' ) ");//checks if players saved game is there or not
if ($result->num_rows == 1) {  
    while ($row = $result->fetch_assoc()){
        $turn = $row["Turn"];
    }
    
}
echo $turn;
?>