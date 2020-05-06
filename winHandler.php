<?php
#example: this should echo something like this: [Logged in as: raygay]   Wins: 292 | Losses: 15
ini_set('display_errors', 1); 
error_reporting(E_ALL);
include 'config.php';
session_start();
$currentUserName = $_SESSION["username"];

$d = $_REQUEST["d"];
$winningPlayer = (int)(substr($d, 0, 1));//first character is the player #
$gameMode = substr($d, 1);// the rest is the game mode
if($winningPlayer == 1){
    $link->query("UPDATE `users` SET wins = wins + 1 WHERE  username = '$currentUserName' ");//updates your win (increments it by 1)
}elseif($winningPlayer == 2){
    $link->query("UPDATE `users` SET losses = losses + 1 WHERE  username = '$currentUserName' ");
}



$get = $link->query("SELECT * FROM `MatchHistory` WHERE (`player1` = '$currentUserName' && `gameMode` = '$gameMode' )");
if ($get->num_rows == 1) {
    while ($row = $get->fetch_assoc()) {
        if($winningPlayer == 1){
            $link->query("UPDATE `MatchHistory` SET p1Wins = p1Wins + 1 WHERE (`player1` = '$currentUserName' && `gameMode` = '$gameMode' )");//updates your win (increments it by 1)
        }elseif($winningPlayer == 2){
            $link->query("UPDATE `MatchHistory` SET p1Losses = p1Losses + 1 WHERE  (`player1` = '$currentUserName' && `gameMode` = '$gameMode' )");
        }
    }
}else{//if played against this player/gamemode first time then make new entry
    if($winningPlayer == 1){
        $link->query("INSERT INTO `MatchHistory` (player1, player2, gameMode, p1Wins) VALUES ('$currentUserName', 'Player 2', '$gameMode', 1)");
    }elseif($winningPlayer == 2){
        $link->query("INSERT INTO `MatchHistory` (player1, player2, gameMode, p1Losses) VALUES ('$currentUserName', 'Player 2', '$gameMode', 1)");
    }
}


echo $d;
?>