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
  
}
</script>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <!--Navigation bar-->
  <div class="topnav">
      <a href="logout.php" class="btn btn-danger">Log Out</a><!--logout button-->
      <a class="active" href="#settings">Settings</a>
      <a href="connect4.php">Play Game</a>
      <a href="friends.php">Friends</a>
      <a href="profile.php">Profile</a>
      <a href="home.php">Home</a>

      <!--shows player name and wins/losses-->
      <div class = "playInfo" id = "pInfo" > </div>
   </div>
   <h1 style = "text-align: center">Settings</h1>
</head>

<!--NOTE onload can only be used on certain tags-->
<body onload = "loadEmIn()" >
   <div class = "settingsMenu">
      <p>Local Play<br/>
         <a href = "connect4.php">Connect 4</a><br/>
         <a href = "connect5.php">Connect 5</a><br/>
         <a href = "connect6.php">Connect 6</a><br/>
         <a href = "connect8.php">Connect 8</a><br/><br/>
      
         vs CPU<br/>
         <a href = "playvsbot.php">Easy</a><br/>
         <a href = "playvsbot.php">Medium</a><br/>
         <a href = "playvsbot.php">Hard</a><br/><br/>
   
         Multiplayer<br/>
         <a href = "createOnlineGame.php">Play</a>
      </p>
   </div>
  

</body>


</table>
</html>
