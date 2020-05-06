<?php
#example: this should echo something like this: [Logged in as: raygay]   Wins: 292 | Losses: 15
ini_set('display_errors', 1); 
error_reporting(E_ALL);
include 'config.php';
session_start();
$currentUserName = $_SESSION["username"];
$currentUser = "[logged in as ";
$info = ":(";
if($_SESSION['loggedin']==true){ 
    $currentUser .= $_SESSION["username"]. "]";
}
$result = $link->query("SELECT wins, losses FROM users WHERE username = '$currentUserName' ");


if ($result->num_rows == 1) {

    while (($row = $result->fetch_assoc())) {
        $info = $currentUser . "   Wins: " . $row["wins"] . " | " . " Losses: ". $row["losses"];
    } 
}
echo $info;
?>