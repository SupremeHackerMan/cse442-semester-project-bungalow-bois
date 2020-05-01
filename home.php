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
   
?>
 
<!DOCTYPE html>
<html>

<link rel="stylesheet" href="css/navigationBar.css">
<link rel="stylesheet" href="css/leaderboard.css">
<script type="text/javascript" src="scripts.js"></script>

<script>
function loadEmIn(){
   getPlayerInfo();
   getRankings();
   pingServer();
   var interval = setInterval(function () { pingServer(); }, 15*1000);
}
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
   <meta name="viewport" content="width=device-width, initial-scale=1">

  <!--Navigation bar-->
  <div class="topnav">
      <a href="logout.php" class="btn btn-danger">Log Out</a><!--logout button-->
      <a href="settings.php">Settings</a>
      <a href="connect4.php">Play Game</a>
      <a href="friends.php">Friends</a>
      <a href="profile.php">Profile</a>
      <a class="active" href="#home">Home</a>

      <!--shows player name and wins/losses-->
      <div class = "playInfo" id = "pInfo" > </div>
   </div>
   
</head>


<!--NOTE onload can only be used on certain tags-->
<body onload = "loadEmIn()" >

  

</body>
<h1 style = "text-align: center">LeaderBoard</h1>
<table id="leaderboard">
   <tr>
      <th>Ranking</th>
      <th>Player</th>
      <th>Wins</th>
      <th>Losses</th>
      <th>Win/Loss Ratio</th>
   </tr>
   <tr>
      <td>#1</th>
      <td id = "pl1">Alfreds Futterkiste</td>
      <td id = "win1">:(</td>
      <td id = "lose1">:(((((</td>
      <td id = "ratio1">:((((((((</td>
   </tr>
   <tr>
      <td>#2</th>
      <td id = "pl2">Berglunds snabbköp</td>
      <td id = "win2">:(</td>
      <td id = "lose2">:(((((</td>
      <td id = "ratio2">:((((((((</td>
   </tr>
   <tr>
      <td>#3</th>
      <td id = "pl3">Centro comercial Moctezuma</td>
      <td id = "win3">:(</td>
      <td id = "lose3">:(((((</td>
      <td id = "ratio3">:((((((((</td>
   </tr>
   <tr>
      <td>#4</th>
      <td id = "pl4">Ernst Handel</td>
      <td id = "win4">:(</td>
      <td id = "lose4">:(((((</td>
      <td id = "ratio4">:((((((((</td>
   </tr>
   <tr>
      <td>#5</th>
      <td id = "pl5">Island Trading</td>
      <td id = "win5">:(</td>
      <td id = "lose5">:(((((</td>
      <td id = "ratio5">:((((((((</td>
   </tr>
   <tr>
      <td>#6</th>
      <td id = "pl6">Königlich Essen</td>
      <td id = "win6">:(</td>
      <td id = "lose6">:(((((</td>
      <td id = "ratio6">:((((((((</td>
   </tr>
   <tr>
      <td>#7</th> 
      <td id = "pl7">Laughing Bacchus Winecellars</td>
      <td id = "win7">:(</td>
      <td id = "lose7">:(((((</td>
      <td id = "ratio7">:((((((((</td>
   </tr>
   <tr>
      <td>#8</th>
      <td id = "pl8">Magazzini Alimentari Riuniti</td>
      <td id = "win8">:(</td>
      <td id = "lose8">:(((((</td>
      <td id = "ratio8">:((((((((</td>
   </tr>
   <tr>
      <td>#9</th>
      <td id = "pl9">North/South</td>
      <td id = "win9">:(</td>
      <td id = "lose9">:(((((</td>
      <td id = "ratio9">:((((((((</td>
   </tr>
   <tr>
      <td>#10</th>
      <td id = "pl10">Paris spécialités</td>
      <td id = "win10">:(</td>
      <td id = "lose10">:(((((</td>
      <td id = "ratio10">:((((((((</td>
   </tr>
</table>
</html>
