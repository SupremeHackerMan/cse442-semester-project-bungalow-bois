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


<!--links to css file-->
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="navigationBar.css">
<script type="text/javascript" src="scripts.js"></script>
<head>
</head>
<script>
  
</script>

<!--NOTE onload can only be used on certain tags-->
<body onload = "getPlayerInfo()">
  <!--Navigation bar-->
   <div class="topnav">
      <a href="logout.php" class="btn btn-danger">Log Out</a><!--logout button-->
      <a href="#news">News</a>
      <a href="#contact">Contact</a>
      <a href="#about">About</a>
      <a class="active" href="#home">Home</a>
      <div class = "playInfo" id = "pInfo" > </div>
   </div>
   <div class = "bigTitle" >Connect 4</div>


<!--Every thing in this p tag: Displays a bunch of stuff like leaderboard and player list-->
<p>
   <div id="player_list" class="box">Player List
      <?php
         $currentUserName = $_SESSION["username"];//session is a global variable for current username
         $conn = new mysqli($HOST, $USERNAME, $USERPASSWORD, $DBNAME);
         $sql = "SELECT username FROM users";
         $result = $conn->query($sql);

         if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
               echo "<br>". $row["username"].  "<br>";
            }
         }else {
            echo "<br> 0 results";
         }
         
      ?>
   </div>

   <div id="friends_list" class="box">Friends List
      <?php
         $conn = new mysqli($HOST, $USERNAME, $USERPASSWORD, $DBNAME);
         $sql = "SELECT * FROM `Friends` WHERE `friend1Username` = '$currentUserName'  OR `friend2Username` = '$currentUserName' ";
         $result = $conn->query($sql);

         if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
               if ($row["friend1Username"] === $currentUserName){
                  echo "<br>". $row["friend2Username"].  "<br>";
               }else{
                  echo "<br>". $row["friend1Username"].  "<br>";
               }
            }
         } else {
            echo "<br> 0 results";
         }
  
      ?>
   </div>

   <div id="leaderboard" class="box">Leaderboard
      <?php
         $conn = new mysqli($HOST, $USERNAME, $USERPASSWORD, $DBNAME);
         $sql = "SELECT username, wins, losses FROM users ORDER BY wins DESC";
         $result = $conn->query($sql);
         if ($result->num_rows > 0) {
            // output data of each row
            $counter = 0;
            while (($row = $result->fetch_assoc()) AND ($counter < 10)) {
               echo "<br>". $row["username"]. "<br> Wins: ". $row["wins"].  "   Losses: ". $row["losses"].  "<br>";
               $counter++;
            } 
               
         }
      

      ?>
   </div>

   <div id="match_history" class="box"> Match History
      <?php
         $currentUserName = $_SESSION["username"];
         $conn = new mysqli($HOST, $USERNAME, $USERPASSWORD, $DBNAME);
         $sql = "SELECT * FROM `MatchHistory` WHERE `player1` = '$currentUserName' ";
         $result = $conn->query($sql);
         $outcome = "";
         if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
               if ($row["win"]  == 1) {
                  $outcome = "won.";
               } else {
                  $outcome = "lost.";
               }
               echo "<br>" . $row["player1"]. " played against ". $row["player2"].  " and ". $outcome.  "<br>";
            }  
         }
    

      ?>
   </div>
   <div id="notifications" class="box"> Notifications
      <?php
         $currentUserName = $_SESSION["username"];

         $conn = new mysqli($HOST, $USERNAME, $USERPASSWORD, $DBNAME);

         //search through FriendRequests table for current username
         $result = $conn->query("SELECT * FROM `FriendRequests` WHERE `requester` = '$currentUserName' ");//
         $result2 = $conn->query("SELECT * FROM `FriendRequests` WHERE `requestee` = '$currentUserName' ");//

         $result3 = $conn->query("SELECT * FROM `GameInvites` WHERE `inviter` = '$currentUserName' ");//
         $result4 = $conn->query("SELECT * FROM `GameInvites` WHERE `invitee` = '$currentUserName' ");//

         /*initialized to be empty
         $cantFindUserError = "";*/

         if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
               echo "<br>Your friend request to " . $row["requestee"].  " is pending <br>";
            } 
         }
         if($result2->num_rows > 0){
            while ($row = $result2->fetch_assoc()) {
               echo "<br>You have a friend request from " . $row["requester"].  "<br>";
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
         $conn->close();

      ?>
   </div>


   <h3>Send Friend Request </h3>
      <form action = "friendsAndInvites\friendRequest.php" method= "post">
         <b>Type their username:</b> <input type = "text" name = "user_name">
         <input type = "submit" value="Send">
      </form>
      <!--<span class="help-block"><?php //echo $username_err; ?></span>-->
   <h3>Invite Friend to Game</h3>
      <form action = "friendsAndInvites\inviteFriend.php" method= "post">
         <b>Type their username:</b> <input type = "text" name = "user_name">
         <input type = "submit" value="Invite">
      </form>

   <div>Respond to Friend Request
   
      <form action = "friendsAndInvites\acceptFriendRequest.php" method= "post">
         <b>Type their username:</b> <input type = "text" name = "user_name">
         <input type = "submit" value="Accept">
      </form>
      <form action = "friendsAndInvites\denyFriendRequest.php" method= "post">
         <b>Type their username:</b> <input type = "text" name = "user_name">
         <input type = "submit" value="Deny">
      </form>
   </div>
   <h3>Respond to Invite</h3>
      <form action = "friendsAndInvites\acceptInviteFriend.php" method= "post">
         <b>Type their username:</b> <input type = "text" name = "user_name">
         <input type = "submit" value="Accept">
      </form>
      <form action = "friendsAndInvites\denyInviteFriend.php" method= "post">
         <b>Type their username:</b> <input type = "text" name = "user_name">
         <input type = "submit" value="Deny">
      </form>
         
</p>

<!-- 
   UPDATE user SET wins = wins + 1 WHERE username = 'jackie'
            -->
</body>
</html>
