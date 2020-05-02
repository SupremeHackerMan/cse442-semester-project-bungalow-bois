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

   /*
   $timeywimey = time();
   echo "current time: ". $timeywimey . "<br>";

   $result = $link->query("SELECT `timestamp` FROM `Status` WHERE `player` = '$currentUserName' ");
   if ($result->num_rows == 1) {
      
      while ($row = $result->fetch_assoc()) {
         echo checkIfOnline($row["timestamp"]);
         echo $row["timestamp"];
         
      }  
   }
*/



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
function acceptFriendRequest(friendId) {
   var xmlhttp = new XMLHttpRequest();
   xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
         console.log(this.responseText);
      }
   };
   xmlhttp.open("GET", "acceptFriendRequest.php?f="+friendId, true);
   xmlhttp.send();

}
function denyFriendRequest(friendId) {
   var xmlhttp = new XMLHttpRequest();
   xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
         console.log(this.responseText);
      }
   };
   xmlhttp.open("GET", "denyFriendRequest.php?f="+friendId, true);
   xmlhttp.send();

}
function funky (yes) {
   console.log(yes);
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

<h1 style = "text-align: center">Notifications</h1>
<table id="leaderboard" >
   <!--“Uncaught SyntaxError: Unexpected end of input” with onclick CAUSED BY THE QUOTES BEING WRONG WATCH YO QUOTES-->
   <?php
      $requests= $link->query("SELECT * FROM `FriendRequests` WHERE `requestee` = '$currentUserName' ");//
      $invitations = $link->query("SELECT * FROM `GameInvites` WHERE `invitee` = '$currentUserName' ");//
      $playerId = 0;
      $requester = "error";
     
      if ($requests->num_rows > 0) {
         while ($row = $requests->fetch_assoc()) {
            $requester = $row["requester"];
            //grabs the requester's id
            $playerInfo = $link->query("SELECT `id` FROM `Status` WHERE `player` = '$requester'");
            if ($playerInfo->num_rows == 1) {
               while($row = $playerInfo->fetch_assoc()) {
                  $playerId = $row["id"];
               }
            }   
            $accept = "acceptFriendRequest(". "$playerId" . ")";
            $deny = "denyFriendRequest(". "$playerId" . ")";
            echo "<tr>".  
                     "<td>You Have a Friend Request from: ". $requester .  "</td>" . 
                     "<td>". "<button onclick = \" " .$accept. "\">Accept</button> </td>" .
                     "<td>". "<button onclick = \" " .$deny. "\">Deny</button> </td>" .
                  "</tr>";  
         } 
      }else {
         echo "<tr>".  
                  "<td>No Friend Requests :(</td>" . 
                  "<td></td>" . 
                  "<td></td>" . 
               "</tr>";  
      }
      
      $inviter = "error";
      if($invitations->num_rows > 0){
         while ($row = $invitations->fetch_assoc() ) {
            $inviter = $row["inviter"];
            //grabs the inviter's id info 
            $playerInfo = $link->query("SELECT `id` FROM `Status` WHERE `player` = '$inviter'");
            if ($playerInfo->num_rows == 1) {
               while($row = $playerInfo->fetch_assoc()) {
                  $playerId = $row["id"];
               }
            }   
            $funko = "funky(". "$playerId" . ")";
            echo "<tr>".  
                     "<td>You Have a Game Invite from: ". $inviter .  "</td>" . 
                     "<td>". "<button onclick = \" " .$funko. "\">Accept</button> </td>" .
                     "<td>". "<button onclick = \" " .$funko. "\">Deny</button> </td>" .
                  "</tr>"; 
         } 
      }else {
         echo "<tr>".  
                  "<td>No Game Invites</td>" . 
                  "<td></td>" . 
                  "<td></td>" . 
               "</tr>";  
      }   
            
                  
         
      
   ?>
</table>


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
            $funky = "sendFriendRequest(". "$plid" . ")";
            //SELECT * FROM `Friends` WHERE ((`friend1Username` = 'mayflower' AND  `Friend2Username` = 'raygay' ) OR (`friend1Username` = 'raygay' AND  `Friend2Username` = 'mayflower' ))
            
            //checks if already friends so it can disable add friend button
            $alreadyFriends = $link->query("SELECT * FROM `Friends` WHERE ( (`friend1Username` = '$currentUserName' AND  `Friend2Username` = '$friendo' ) 
                                                                        OR  (`friend1Username` = '$friendo' AND  `Friend2Username` = '$currentUserName' ))");
            $friendshipCheck =($alreadyFriends->num_rows) != 0;
            //checks if a friend invite has already been sent
            $alreadySent = $link->query("SELECT * FROM `FriendRequests` WHERE ( (`requester` = '$currentUserName' AND  `requestee` = '$friendo' )
                                                                              OR (`requester` = '$friendo' AND  `requestee` = '$currentUserName' ))");
            $sentCheck =($alreadySent->num_rows) != 0;
            echo "<tr>".  
                     "<td>". $row["player"].  "</td>" .
                     "<td>". checkIfOnline($row["timestamp"]) .  "</td>";
            if($currentUserName === $row["player"]){
               echo  "<td>You</td>" ;
            }elseif($friendshipCheck){
               echo  "<td>Friends</td>" ;
            }elseif($sentCheck){
               echo  "<td>Request Pending...</td>" ;
            }else{
               echo "<td>". "<button onclick = \" " .$funky. "\">add friend</button> </td>";
            }
            echo "</tr>";   
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



</body>
</html>
