<?php
#example: this should echo something like this: [Logged in as: raygay]   Wins: 292 | Losses: 15
ini_set('display_errors', 1); 
error_reporting(E_ALL);
include 'config.php';
session_start();
$currentUserName = $_SESSION["username"];
//search through FriendRequests table for current username

$requests= $link->query("SELECT * FROM `FriendRequests` WHERE `requestee` = '$currentUserName' ");//

$invitations = $link->query("SELECT * FROM `GameInvites` WHERE `invitee` = '$currentUserName' ");//


if ($requests->num_rows > 0) {
   while ($row = $requests->fetch_assoc()) {
      echo "<br>Your friend request to " . $row["requester"].  " is pending <br>";
   } 
}

if($result3->num_rows > 0){
   while ($row = $result3->fetch_assoc() ) {
      echo "<br>Your invitation to " . $row["inviter"].  " is pending <br>";
   } 
}
if($result4->num_rows > 0){
   while ($row = $result4->fetch_assoc() ) {
      echo "<br>You have an invitation from " . $row["invitee"].  "<br>";
   }          
}
?>