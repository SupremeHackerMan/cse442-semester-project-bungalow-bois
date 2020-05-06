<?php
   ini_set('display_errors', 1); 
   error_reporting(E_ALL);
   // Initialize the session
   session_start();

   include 'config.php';
   // Check if the user is logged in, if not then redirect him to login page
   if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
      header("location: index.php");
      exit;
   }
   $currentUserName = $_SESSION["username"];


   //checks if the timestamp was created within 45 secs
   //if not then the player is offline 
   function checkIfOnline($timeStuff){
      if(abs($timeStuff - time()) > 45) {
         return "<span style='color: red;'>offline</span>";
         
      }else{
         return "<span style='color: green;'>online</span>";
      }
   }
   
?>
 
<!DOCTYPE html>
<html>

<!--links to css file-->
<link rel="stylesheet" href="css/navigationBar.css">
<link rel="stylesheet" href="css/leaderboard.css">
<script type="text/javascript" src="scripts.js"></script>


<script type="text/javascript">

function loadEmIn() {
   pingServer();
   var interval = setInterval(function () { pingServer(); }, 15*1000);
   getPlayerInfo();
}
//pings the server with current timestamp so we can check if a player is online or not
function pingServer() {
   var xmlhttp = new XMLHttpRequest();
   xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
         console.log(this.responseText);
         
      }
   };
   xmlhttp.open("GET", "pingServer.php", true);
   xmlhttp.send();
}

</script>




<head>
   <!--Navigation bar-->
   <div class="topnav">
      <a href="logout.php" class="btn btn-danger">Log Out</a><!--logout button-->
      <a href="settings.php">Settings</a>
      <a href="connect4.php">Play Game</a>
      <a href="friends.php">Friends</a>
      <a class="active" href="#profile">Profile</a>
      <a href="home.php">Home</a>

      <!--shows player name and wins/losses-->
      <div class = "playInfo" id = "pInfo" > </div>
   </div>
</head>
<!--loads the board first thing when page refreshes -->
<body onload="loadEmIn()">


<h1 style = "text-align: center">Match History</h1>
<table id="leaderboard" >
   <!--“Uncaught SyntaxError: Unexpected end of input” with onclick CAUSED BY THE QUOTES BEING WRONG WATCH YO QUOTES-->
   <tr>
      <th></th>
      <th>Game Mode</th>
      <th>Your Wins</th>
      <th>Your Losses</th>
   </tr>
   <?php
      $result = $link->query("SELECT * FROM `MatchHistory` WHERE `player1` = '$currentUserName' ");
      
      if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
            echo "<tr>".  
                     "<td>". $row["player1"]. " vs " . $row["player2"] . "</td>" . 
                     "<td>". $row["gameMode"] .  "</td>" . 
                     "<td>". $row["p1Wins"]. "</td>" .
                     "<td>". $row["p1Losses"]. "</td>" .
                  "</tr>";        
         }
      }else {
         echo "<tr>".  
                  "<td>You Haven't Played Any Games Yet.</td>" . 
                  "<td>Click The [Play Game] Tab to Start</td>" . 
                  "<td></td>" .
                  "<td></td>" .
               "</tr>";  
      }
   ?>
</table>


</body>
</html>
