<?php
#example: this should echo something like this: [Logged in as: raygay]   Wins: 292 | Losses: 15
ini_set('display_errors', 1); 
error_reporting(E_ALL);
include 'config.php';
session_start();
$currentUserName = $_SESSION["username"];

$d = $_REQUEST["d"];
$winningPlayer = (int)$d;
if($winningPlayer == 1){
    $link->query("UPDATE `users` SET wins = wins + 1 WHERE  username = '$currentUserName' ");//updates your win (increments it by 1)
}elseif($winningPlayer == 2){
    $link->query("UPDATE `users` SET losses = losses + 1 WHERE  username = '$currentUserName' ");
}

$link->query("INSERT INTO `MatchHistory` (player1, player2, win) VALUES ('$currentUserName', 'Player 2', $winningPlayer)");

echo $d;
?>