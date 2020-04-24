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
}
</script>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <!--Navigation bar-->
  <div class="topnav">
      <a href="logout.php" class="btn btn-danger">Log Out</a><!--logout button-->
      <a class="active" href="#settings">Settings</a>
      <a href="#frinds">Friends</a>
      <a href="#profile">Profile</a>
      <a href="home.php">Home</a>

      <!--shows player name and wins/losses-->
      <div class = "playInfo" id = "pInfo" > </div>
   </div>
   <h1 style = "text-align: center">Settings</h1>
</head>


<!--NOTE onload can only be used on certain tags-->
<body onload = "loadEmIn()" >


  

</body>


</table>
</html>
