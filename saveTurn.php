<?php
//only uncommment TEST ECHOS ONE AT A TIME
ini_set('display_errors', 1); 
error_reporting(E_ALL);
include 'config.php';
session_start();

$currentUserName = $_SESSION["username"];

// get the board data from the parameter from URL called by saveBoard()
$turn = $_REQUEST["b"];
$link->query("UPDATE `OnlinePlay` SET Turn = '$turn' WHERE (`Player1` = '$currentUserName' OR  `Player2` = '$currentUserName' )");

echo "changed turn to ". $turn;
?>