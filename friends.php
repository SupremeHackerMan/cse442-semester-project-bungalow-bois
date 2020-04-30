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


   $timeywimey = time();
   echo "current time: ". $timeywimey . "<br>";
   //$link->query("UPDATE `Status` SET `timestamp`= $timeywimey WHERE `player` = '$currentUserName'");

   $result = $link->query("SELECT `timestamp` FROM `Status` WHERE `player` = '$currentUserName' ");
   if ($result->num_rows == 1) {
      
      while ($row = $result->fetch_assoc()) {
         echo checkIfOnline($row["timestamp"]);
         echo $row["timestamp"];
         
      }  
   }




   //checks if the timestamp was created within a minute
   //if not then the player is offline 
   function checkIfOnline($timeStuff){
      if(abs($timeStuff - time()) > 60) {
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
//pings the server with current timestamp so we can check if a player is online or not 
function pingServer() {
   console.log('pinged!');
   <?php
      $timeywimey = time();
      $link->query("UPDATE `Status` SET `timestamp`= $timeywimey WHERE `player` = '$currentUserName'")
   ?>
}
var interval = setInterval(function () { pingServer(); }, 10*1000);

function loadEmIn() {
   pingServer();
   getPlayerInfo();
}

function funky (yes) {
   console.log(yes);
}

function sendFriendRequest(friendId) {
   var xmlhttp = new XMLHttpRequest();
   xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
         console.log(this.responseText);
         
      }
   };
   xmlhttp.open("GET", "sendFriendRequest.php?f="+friendId, true);
   xmlhttp.send();

}
function sendFrReq(id) {
   sendFriendRequest(id);
}

</script>






<head>
   <!--Navigation bar-->
   <div class="topnav">
      <a href="logout.php" class="btn btn-danger">Log Out</a><!--logout button-->
      <a href="settings.php">Settings</a>
      <a href="connect4.php">Play Game</a>
      <a class="active" href="#friend">Friends</a>
      <a href="profile.php">Profile</a>
      <a href="home.php">Home</a>

      <!--shows player name and wins/losses-->
      <div class = "playInfo" id = "pInfo" > </div>
   </div>
</head>
<!--loads the board first thing when page refreshes -->
<body onload="loadEmIn()">



<h1 style = "text-align: center">Friends</h1>
<table id="leaderboard" >
   <!--“Uncaught SyntaxError: Unexpected end of input” with onclick CAUSED BY THE QUOTES BEING WRONG WATCH YO QUOTES-->
   <?php
      $result = $link->query("SELECT * FROM `Friends` WHERE `friend1Username` = '$currentUserName'  OR `friend2Username` = '$currentUserName' ");
      if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
            $frienddd = ($row["friend1Username"] === $currentUserName? $row["friend2Username"]:$row["friend1Username"]);
            $friendTimestamp = 0;
            $friendId = 0;
            //grabs the timestamp and id info about the friend
            $friendInfo = $link->query("SELECT `id`, `timestamp` FROM `Status` WHERE `player` = '$frienddd'");
            if ($friendInfo->num_rows == 1) {
               while($row = $friendInfo->fetch_assoc()) {
                  $friendTimestamp = $row["timestamp"];
                  $friendId = $row["id"];
                 
               }
            }
            $funko = "funky(". "$friendId" . ")";
            echo "<tr>".  
                     "<td>". $frienddd.  "</td>" . 
                     "<td>". checkIfOnline($friendTimestamp) .  "</td>" . 
                     "<td>". "<button onclick = \" " .$funko. "\">Invite To Game</button> </td>" .
                  "</tr>";        
         }
      }else {
         echo "<tr>".  
                  "<td>You Have No Friends :(</td>" . 
                  "<td></td>" . 
                  "<td></td>" .
               "</tr>";  
      }
   ?>
</table>



<h1 style = "text-align: center">All Registered Players</h1>
<table id="leaderboard" >
   <!--“Uncaught SyntaxError: Unexpected end of input” with onclick CAUSED BY THE QUOTES BEING WRONG WATCH YO QUOTES-->
   <?php
      //$result = $link->query("SELECT * FROM `Status` WHERE `player` != '$currentUserName' ");
      $result = $link->query("SELECT * FROM `Status` ");
      if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
            $friendo = $row["player"];
            $plid = $row["id"];
            $funky = "sendFrReq(". "$plid" . ")";
            //SELECT * FROM `Friends` WHERE ((`friend1Username` = 'mayflower' AND  `Friend2Username` = 'raygay' ) OR (`friend1Username` = 'raygay' AND  `Friend2Username` = 'mayflower' ))
            
            //checks if already friends so it can disable add friend button
            $alreadyFriends = $link->query("SELECT * FROM `Friends` WHERE ( (`friend1Username` = '$currentUserName' AND  `Friend2Username` = '$friendo' ) 
                                                                        OR  (`friend1Username` = '$friendo' AND  `Friend2Username` = '$currentUserName' ))");
           
            $yay =($alreadyFriends->num_rows) != 0;

            if($currentUserName === $row["player"] || $yay){
               echo "<tr>".  
                     "<td>". $row["player"].  "</td>" . 
                     "<td>". checkIfOnline($row["timestamp"]) .  "</td>" . 
                     "<td></td>" .
                  "</tr>";   
            }else{
               echo "<tr>".  
                        "<td>". $row["player"].  "</td>" . 
                        "<td>". checkIfOnline($row["timestamp"]) .  "</td>" . 
                        "<td>". "<button onclick = \" " .$funky. "\">add friend</button> </td>" .
                     "</tr>";    
            }    
         }
      }else {
         echo "<tr>".  
                  "<td>There are no players</td>" . 
                  "<td></td>" . 
                  "<td></td>" .
               "</tr>";  
      }
   ?>
</table>







<p>
   

   <div id="friends_list" class="box">Friends List
      <?php
         $result = $link->query("SELECT * FROM `Friends` WHERE `friend1Username` = '$currentUserName'  OR `friend2Username` = '$currentUserName' ");

         if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
               $frienddd = ($row["friend1Username"] === $currentUserName? $row["friend2Username"]:$row["friend1Username"]);
            
               echo $frienddd;
            }
         } else {
            echo "<tr> You Have No Friends:( </tr>";
         }
  
      ?>
   </div>


   <div id="match_history" class="box"> Match History
      <?php
         $currentUserName = $_SESSION["username"];
  
         $sql = "SELECT * FROM `MatchHistory` WHERE `player1` = '$currentUserName' ";
         $result = $link->query($sql);
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

   

         //search through FriendRequests table for current username
         $result = $link->query("SELECT * FROM `FriendRequests` WHERE `requester` = '$currentUserName' ");//
         $result2 = $link->query("SELECT * FROM `FriendRequests` WHERE `requestee` = '$currentUserName' ");//

         $result3 = $link->query("SELECT * FROM `GameInvites` WHERE `inviter` = '$currentUserName' ");//
         $result4 = $link->query("SELECT * FROM `GameInvites` WHERE `invitee` = '$currentUserName' ");//

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
         $link->close();

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
