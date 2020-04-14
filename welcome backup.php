<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

if($_SESSION['loggedin']==true)
    { 
      echo "Logged in as ". $_SESSION["username"];
    }


   $currentUserName = $_SESSION["username"];
   $HOST = 'tethys.cse.buffalo.edu';
   $USERNAME = 'jling2';
   $USERPASSWORD = "50244515";
   $DBNAME = "cse442_542_2020_spring_teaml_db";

   $conn = new mysqli($HOST, $USERNAME, $USERPASSWORD, $DBNAME);


   $sql = "SELECT wins, losses FROM users WHERE username = '$currentUserName' ";
   $result = $conn->query($sql);

   if ($result->num_rows > 0) {
      // output data of each row
      while (($row = $result->fetch_assoc())) {
         echo "<br> Current Stats: - Wins: ". $row["wins"].  " - Losses: ". $row["losses"].  "<br>";
      } 
         
      
   }
   $conn->close();
?>
 
<!DOCTYPE html>
<html>
<a href="logout.php" class="btn btn-danger">Log Out</a>

<head>
  <link rel="stylesheet" href="style.css">
</head>
<body>


<h1>Connect 4</h1>
<button id="start_button"  type="button" class="start">start!</button>
<img id="start" src="start_screen.jpg"></img>
<div id="container"></div>


<button id="button1" type="button" class="block" style="visibility: hidden;">Col1</button>
<button id="button2" type="button" class="block" style="visibility: hidden;">Col2</button>
<button id="button3" type="button" class="block" style="visibility: hidden;">Col3</button>
<button id="button4" type="button" class="block" style="visibility: hidden;">Col4</button>
<button id="button5" type="button" class="block" style="visibility: hidden;">Col5</button>
<button id="button6" type="button" class="block" style="visibility: hidden;">Col6</button>
<button id="button7" type="button" class="block" style="visibility: hidden;">Col7</button>




<script>


const COLS = 7;
const ROWS = 6;
var board = [];
var turn = 1;
var win = false;

//saves all moves into a "stack"
//ex. if p1 makes a move at positions board[1][2] then [1,2] will be pushed to the stack
var moveHistory = [];

for(x = 0; x < ROWS; x++){
   board[x] = []
   for(y = 0; y < COLS; y++){
      board[x][y] = 0;
   }
}

//displays da board
document.getElementById('start_button').onclick = function() {
   create_board(board);
   print_board();
   document.getElementById('start').src="";
   document.getElementById('button1').style.visibility="visible";
   document.getElementById('button2').style.visibility="visible";
   document.getElementById('button3').style.visibility="visible";
   document.getElementById('button4').style.visibility="visible";
   document.getElementById('button5').style.visibility="visible";
   document.getElementById('button6').style.visibility="visible";
   document.getElementById('button7').style.visibility="visible";
   document.getElementById('start_button').style.visibility="hidden";

}

document.getElementById('button1').onclick = function() {
   place_piece(0);
};
document.getElementById('button2').onclick = function() {
   place_piece(1);
};
document.getElementById('button3').onclick = function() {
   place_piece(2);
};
document.getElementById('button4').onclick = function() {
   place_piece(3);
};
document.getElementById('button5').onclick = function() {
   place_piece(4);
};
document.getElementById('button6').onclick = function() {
   place_piece(5);
};
document.getElementById('button7').onclick = function() {
   place_piece(6);
};


// creates a fresh board
function create_board(board){
   for(x = 0; x < ROWS; x++){
      board[x] = []
      for(y = 0; y < COLS; y++){
         board[x][y] = 0;
   }
}

}
// given a column finds first open spot then puts that players piece into the hole
function place_piece(column){

   if(turn == 1){
       p1_move_number++;
       p1_move_history[p1_move_number] = column + 1;
   }
   else{
       p2_move_number++;
       p2_move_history[p2_move_number] = column + 1;
   }

    // add check here to see if col is full
   for (var i = 0; i < ROWS; i++){
      if(board[i][column] == 1 || board[i][column] == 2){
         if(turn == 1){
            board[i - 1][column] = 1;
            win = determine_win(turn);
            turn = 2;
         }
         else{
            board[i - 1][column] = 2;
            win = determine_win(turn);
            turn = 1;
         }
         print_board();
         return;
      }
   }
   // so if that fully runs then we know there are no pieces in the column
   if(turn == 1){
      board[ROWS - 1][column] = 1;
      win = determine_win(turn);
      turn = 2;
   }
   else{
      board[ROWS - 1][column] = 2;
      win = determine_win(turn);
      turn = 1;
   }

   print_board();

   if(win == true){
      //yeah this code is ass
      <?php
      $currentUserName = $_SESSION["username"];
      $HOST = 'tethys.cse.buffalo.edu';
      $USERNAME = 'jling2';
      $USERPASSWORD = "50244515";
      $DBNAME = "cse442_542_2020_spring_teaml_db";

      $conn = new mysqli($HOST, $USERNAME, $USERPASSWORD, $DBNAME);
      $sql = "UPDATE users SET wins = wins + 1 WHERE  username = '$currentUserName' ";
      $sql2 = "INSERT INTO MatchHistory (player1, player2, win) VALUES ('$currentUserName', 'Placeholder BOT', 1)";
      $conn->query($sql);
      $conn->query($sql2);
      $conn->close();
      ?>

      turn = 1;
   }
}

//increments the wins by
function update_datatbase_wins_and_stuff(){
   <?php
      $currentUserName = $_SESSION["username"];
      $HOST = 'tethys.cse.buffalo.edu';
      $USERNAME = 'jling2';
      $USERPASSWORD = "50244515";
      $DBNAME = "cse442_542_2020_spring_teaml_db";

      $conn = new mysqli($HOST, $USERNAME, $USERPASSWORD, $DBNAME);
      $sql = "UPDATE users SET wins = wins + 1 WHERE  username = '$currentUserName' ";
      $sql2 = "INSERT INTO MatchHistory (player1, player2, win) VALUES ('$currentUserName', 'Placeholder BOT', 1)";
      $conn->query($sql);
      $conn->query($sql2);
      $conn->close();
      ?>

}

function update_board() {
   let s='';

   for(let i=0; i<ROWS; i++) {
      s+= '<div class="row">'
      for(let j=0; j<COLS; j++) {
         if(board[i][j] == 0){
            s+= `<div class="cell"> ${""} </div>`;
         }
         else if(board[i][j] == 1){
            s+= `<div class="player1"> ${""} </div>`;
         }
         else{
            s+= `<div class="player2"> ${""} </div>`;
         }
      }

      s+= '</div>'


   document.getElementById("container").innerHTML = s
}


}
// prints board to website
function print_board() {

   console.log(p1_move_history);
   console.log(p2_move_history);
   update_board();
   return;
}

// determines if that player just won the game player == what number piece they're using
// the runtime on this is currently disgusting
// todo make this ambiguous that goes through all chains looking for chains of 4 -> won't have to double loop through board so many times
function determine_win(player){

   //so we first check in the horizontal direction if they won
   //we need 4 in a row so we go from 0 -> max_rows then 0 -> max_cols - 3 bc max_cols - 3 is the last piece that can be the start of a 4 chain
   for (var row = 0; row < ROWS; row++){
      for(var col = 0; col < COLS - 3; col++){
         piece = board[row][col];
         var chain_size = 0;
         // while the current piece is the right piece increase the chain_size check if we have 4 in a row then move on to next piece
         while(piece == player){
            chain_size++;

            if(chain_size == 4){
               alert("you win!");
               update_datatbase_wins_and_stuff();
               create_board(board);
               return true;
            }

            piece = board[row][col + chain_size];
         }
      }
   }

   //now we check vertical direction pretty much same as last part but now its rows - 3 instead of cols - 3
   for (var row = 0; row < ROWS - 3; row++){
      for(var col = 0; col < COLS; col++){
         piece = board[row][col];
         var chain_size = 0;
         while(piece == player){
            chain_size++;

            if(chain_size == 4){
               alert("you win!");
               update_datatbase_wins_and_stuff();
               create_board(board);
               return true;
            }

            piece = board[row + chain_size][col];
         }
      }
   }

   //now time for 2 vertical directions now both have -3

   for (var row = 0; row < ROWS - 3; row++){
      for(var col = 0; col < COLS - 3; col++){
         piece = board[row][col];
         var chain_size = 0;
         while(piece == player){
            chain_size++;

            if(chain_size == 4){
               alert("you win!");
               update_datatbase_wins_and_stuff();
               create_board(board);
               return true;
            }

            piece = board[row + chain_size][col + chain_size];
         }
      }
   }

   for (var row = 0; row < ROWS - 3; row++){
      for(var col = COLS - 3; col > 0; col--){
         piece = board[row][col];
         var chain_size = 0;
         while(piece == player){
            chain_size++;

            if(chain_size == 4){
               alert("you win!");
               update_datatbase_wins_and_stuff();
               



               create_board(board);
               return true;
            }

            piece = board[row + chain_size][col - chain_size];
         }
      }
   }


   return false;


}
</script>


<!--Every thing in this p tag: Displays a bunch of stuff like leaderboard and player list-->
<p>
   <div id="player_list" class="box">Player List
      <?php
         $currentUserName = $_SESSION["username"];


         $conn = new mysqli($HOST, $USERNAME, $USERPASSWORD, $DBNAME);


         $sql = "SELECT username FROM users";
         $result = $conn->query($sql);

         if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
               echo "<br> Name: ". $row["username"].  "<br>";
               
            }
         } else {
            echo "<br> 0 results";
         }
         $conn->close();
      
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
         $conn->close();

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
         $conn->close();

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
         $conn->close();

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
       
         while ($row = $result->fetch_assoc()) {
            echo "<br>Your friend request to " . $row["requestee"].  " is pending <br>";
         } 
         while ($row = $result2->fetch_assoc()) {
            echo "<br>You have a friend request from " . $row["requester"].  "<br>";
         }   

         while ($row = $result3->fetch_assoc()) {
            echo "<br>Your invitation to " . $row["inviter"].  " is pending <br>";
         } 
         while ($row = $result4->fetch_assoc()) {
            echo "<br>You have an from " . $row["invitee"].  "<br>";
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

   <div class="box">Respond to Friend Request
   
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
