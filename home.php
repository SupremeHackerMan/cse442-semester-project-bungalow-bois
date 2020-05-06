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
      <a id = "playDaGamez" href="connect4.php">Play Game</a>
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

<h1 style = "text-align: center">How to play Connect 4!</h1>
<dl>
  <dt>Playing the game</dt>
  <dd>Welcome to our version of Connect 4! A game of Connect 4 can be played by pressing the play game button at the top right hand side of the screen. 
  Players can take turns placing one piece during their turns by pressing on a board column. 
  Your turns and your opponent's turns will be displayed at the top portion of your screen. 
  When a player has aligned 4 pieces of the same color in a row of any direction (diagonals included), then that player wins! 
  (By default, our initial board state and play state for your games will be on local play.)</dd>
  <dt>Your Profile</dt>
  <dd>Not sure on how many games you played? Don't know who you played against? Want to see how many wins and losses you have? 
   Just access the Profile tab! Your Profile can also be accessed by a button on the top right hand side of the screen! (By now, I think you are witnessing a pattern...) 
   The Profile section is simple and straightforward, with you being able to see your match history in all of it splendor and glory.
  </dd>
  <dt>Your Friends</dt>
  <dd>Friends! Now, every game is better with friends. We know that. You know that. And what else do we know you know? How to access your Friends tab! 
  (If not, then its located at the top right hand side of the screen.) With the friends section, you can manage who you want to be friends with and well...who you don't! 
  Experience the joy of adding friends with the notification features on display for you. 
  All players registered in our game can be seen and are shown whether they are online or offline. 
  Not only that, you can also challenge your friends to an online game! Pit yourselves in the hot, spicy, thrilling, action of placing digital pieces on a fixed graphical board! 
  (Note that you cannot challenge people who are not your friends. Sorry.)
  </dd>
  <dt>The Settings</dt>
  <dd>Within settings lies the various features for play! Settings can also be accessed by a button. Where is it, you may ask? Why, you already know! 
  (If not, then its located at the top right hand side of the screen.) 
  If you want to play on a different size board and win condition (only for local play), then you may choose from a few options within settings. 
  If so desired, one can embark on offline play against a bot! 
  Choose between the various difficulties such as easy, medium, and hard. 
  However, if you are feeling up for it, you can embark on an adventure of multiplayer with your friends again! This too can be accessed within settings. 
  Just load in a saved game and enjoy having your game resume from where you last left off with your friends!</dd>
  <dt>Logging Out</dt>
  <dd>Tired of playing? Scared of losing account secrecy? Want a fresh new start with a different account? Then log out with the log out button! 
  You know where this is folks. (If not, then you should know that it is located at the top right hand side of the screen.) 
  Logging out is so simple, that one click is all it takes.
  </dd>
</dl>
</html>
