<?php
#example: this should echo something like this: [Logged in as: raygay]   Wins: 292 | Losses: 15
ini_set('display_errors', 1); 
error_reporting(E_ALL);
include 'config.php';
session_start();
$currentUserName = $_SESSION["username"];


$timeywimey = time();
$link->query("UPDATE `Status` SET `timestamp`= $timeywimey WHERE `player` = '$currentUserName'");

echo "pinged ". $currentUserName . " at time:" . $timeywimey;
?>