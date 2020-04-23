<?php
   ini_set('display_errors', 1); 
   error_reporting(E_ALL);
   // Initialize the session
   session_start();

   include 'config.php';
   // Check if the user is logged in, if not then redirect him to login page
   if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
      header("location: login.php");
      exit;
   }
   //displays your username at the top of page
   if($_SESSION['loggedin']==true){ 
         echo "Logged in as ". $_SESSION["username"];
   }
   $currentUserName = $_SESSION["username"];

   $sql = "SELECT wins, losses FROM users WHERE username = '$currentUserName' ";
   $result = $link->query($sql);

   //displays your game stats i.e. wins and losses
   if ($result->num_rows > 0) {
      // output data of each row
      while (($row = $result->fetch_assoc())) {
         echo "<br> Current Stats: Wins: ". $row["wins"].  " Losses: ". $row["losses"].  "<br>";
      } 
   }
   
?>
 
<!DOCTYPE html>
<html>

<a href="logout.php" class="btn btn-danger">Log Out</a><!--logout button-->

<head>
  
</head>
<!--loads the board first thing when page refreshes -->
<body onload="loadBoard()">


<H1>Neck 4 - Local Multiplayer Mode</H1>

<!--links to css file-->
<link rel="stylesheet" href="style.css">



<div id="colorTurn">Yellow Turn (YOU)</div>
<div id="board">
<div class="row">
  <div class="cell" id="cell00" onclick="selectColumn(0)"></div>
  <div class="cell" id="cell01" onclick="selectColumn(1)"></div>
  <div class="cell" id="cell02" onclick="selectColumn(2)"></div>
  <div class="cell" id="cell03" onclick="selectColumn(3)"></div>
  <div class="cell" id="cell04" onclick="selectColumn(4)"></div>
  <div class="cell" id="cell05" onclick="selectColumn(5)"></div>
  <div class="cell" id="cell06" onclick="selectColumn(6)"></div>
</div>
<div class="row">  
  <div class="cell" id="cell10" onclick="selectColumn(0)"></div>
  <div class="cell" id="cell11" onclick="selectColumn(1)"></div>
  <div class="cell" id="cell12" onclick="selectColumn(2)"></div>
  <div class="cell" id="cell13" onclick="selectColumn(3)"></div>
  <div class="cell" id="cell14" onclick="selectColumn(4)"></div>
  <div class="cell" id="cell15" onclick="selectColumn(5)"></div>
  <div class="cell" id="cell16" onclick="selectColumn(6)"></div>
</div>
<div class="row">  
  <div class="cell" id="cell20" onclick="selectColumn(0)"></div>
  <div class="cell" id="cell21" onclick="selectColumn(1)"></div>
  <div class="cell" id="cell22" onclick="selectColumn(2)"></div>
  <div class="cell" id="cell23" onclick="selectColumn(3)"></div>
  <div class="cell" id="cell24" onclick="selectColumn(4)"></div>
  <div class="cell" id="cell25" onclick="selectColumn(5)"></div>
  <div class="cell" id="cell26" onclick="selectColumn(6)"></div>
</div>
<div class="row">  
  <div class="cell" id="cell30" onclick="selectColumn(0)"></div>
  <div class="cell" id="cell31" onclick="selectColumn(1)"></div>
  <div class="cell" id="cell32" onclick="selectColumn(2)"></div>
  <div class="cell" id="cell33" onclick="selectColumn(3)"></div>
  <div class="cell" id="cell34" onclick="selectColumn(4)"></div>
  <div class="cell" id="cell35" onclick="selectColumn(5)"></div>
  <div class="cell" id="cell36" onclick="selectColumn(6)"></div>
</div>
<div class="row">
  <div class="cell" id="cell40" onclick="selectColumn(0)"></div>
  <div class="cell" id="cell41" onclick="selectColumn(1)"></div>
  <div class="cell" id="cell42" onclick="selectColumn(2)"></div>
  <div class="cell" id="cell43" onclick="selectColumn(3)"></div>
  <div class="cell" id="cell44" onclick="selectColumn(4)"></div>
  <div class="cell" id="cell45" onclick="selectColumn(5)"></div>
  <div class="cell" id="cell46" onclick="selectColumn(6)"></div>
</div>
<div class="row">
  <div class="cell" id="cell50" onclick="selectColumn(0)"></div>
  <div class="cell" id="cell51" onclick="selectColumn(1)"></div>
  <div class="cell" id="cell52" onclick="selectColumn(2)"></div>
  <div class="cell" id="cell53" onclick="selectColumn(3)"></div>
  <div class="cell" id="cell54" onclick="selectColumn(4)"></div>
  <div class="cell" id="cell55" onclick="selectColumn(5)"></div>
  <div class="cell" id="cell56" onclick="selectColumn(6)"></div>
</div>
</div>
<input id="undoButton" type="button" value="Undo" onclick="undoMove()" /></br></br><!--button to undo a move-->
<input id="resetButton" type="button" value="Clear/Start New Game" onclick="clearBoard()" /></br></br><!--resets the board button-->
<!--<input id="loadButton" type="button" value="Load Game" onclick="loadBoard()" /></br></br>-->


<!--*************************************JAVASCRIPT***********Start**********************************************-->
<script>

const COLS = 7;
const ROWS = 6;
const chainSize = 4// default is 4 consecutive pieces to win

var board = [];
var turn = 1; //1 for Yellow, 2 for Red
var win = false;

//saves all moves into a "stack"    -   this is for the undo button
//ex. if p1 makes a move at positions board[1][2] then [1,2] will be pushed to the stack
var moveHistory = [];


//resets the board stored in the database
function clearDbBoard(){
   <?php
    
   
      $sql = "UPDATE `SavedOfflineGames` SET row0 = '0000000', row1 = '0000000', row2 = '0000000', row3 = '00000003', row4 = '0000000', row5 = '0000000' 
                                          WHERE username = '$currentUserName'" ;                          
      $link->query($sql);   
   
   ?>
}


/*
var board = [
   [0, 0, 0, 0, 0, 0, 0],
   [0, 0, 0, 0, 0, 0, 0],
   [0, 0, 0, 0, 0, 0, 0],
   [0, 0, 0, 0, 0, 0, 0],
   [0, 0, 0, 0, 0, 0, 0],
   [0, 0, 0, 0, 0, 0, 0]
 ];*/ 
function newBoard(board){
   for(x = 0; x < ROWS; x++){
      board[x] = []
      for(y = 0; y < COLS; y++){
         board[x][y] = 0;
      }
   }
}
newBoard(board);
//loads the board from the table on tethys. Its stored there as 6 strings, each one corresponds to a row
function loadBoard() {
   
   //localStorage.setItem('init',JSON.stringify("done"));//initializes it only once
   //if(JSON.parse(localStorage.getItem('init')))

   board = JSON.parse(localStorage.getItem('boardo'));
   turn = parseInt(JSON.parse(localStorage.getItem('turno')));
   if(turn == 1){
      document.getElementById("colorTurn").innerHTML="Yellow Turn (YOU)";
   }else{
      document.getElementById("colorTurn").innerHTML="Red Turn";
   }
   
   console.log("loaded turn: "+turn);
   console.log(board);
   updateBoard();
}

function saveBoard(){
   localStorage.setItem('boardo',JSON.stringify(board));
   localStorage.setItem('turno',JSON.stringify(turn));
   console.log("saved turn: "+JSON.stringify(turn));
   console.log(JSON.stringify(board));
}









//this add a game piece to a column and does some other stuff
function selectColumn(col) {
   if(!win){
      if (turn==1) {
         var row = board.length - 1;
         //columns 5 to 0 (default)
         while (row > -1) { 
            if(board[row][col] != 0 ){//if the slot is taken then go up a row
               row--;
            }else{//otherwise the pieces is placed here
               board[row][col]=1;
               
               pushToMoveHistory(row,col);//move is pushed into the move history stack
               break;
            }
         }
         turn=2;//go to next players turn (red)
         document.getElementById("colorTurn").innerHTML="Red Turn";//changes the on top of board to display red players turn
         
      } else {
         var row = board.length - 1;
         while (row > -1) { 
            if(board[row][col] !=0 ){
               row--;
            }else{
               board[row][col]=2;
               
               pushToMoveHistory(row,col);
               break;
            }
         }
         turn=1;
         document.getElementById("colorTurn").innerHTML="Yellow Turn (YOU)";//changes the on top of board to display yellow players turn 
      }
      saveBoard();
      updateBoard();//updates the display for the board
      
      
      //checks if player1/yellow won
      if(determineWin(board) == 1){
         document.getElementById("colorTurn").innerHTML="Yellow (YOU) Win!";
         win = true;
         <?php
            $sql = "UPDATE users SET wins = wins + 1 WHERE  username = '$currentUserName' ";//updates your win (increments it by 1)
            $sql2 = "INSERT INTO `MatchHistory` (player1, player2, win) VALUES ('$currentUserName', 'Player 2', 1)";//updates match history table: 1 means win 0 means lose 
            $link->query($sql);
            $link->query($sql2);
         ?>
      //checks if player2/red won   
      }if(determineWin(board) == 2){
         document.getElementById("colorTurn").innerHTML="Red Wins!";
         win = true;
         <?php
            $sql2 = "INSERT INTO `MatchHistory` (player1, player2, win) VALUES ('$currentUserName', 'Player 2', 0)";//you lost lol
            $link->query($sql2);
         ?>
      }
   }
   
}

//refreshes the connect 4 board after each turn
function updateBoard() {
  for (var row = 0; row < ROWS; row++) {
    for (var col = 0; col < COLS; col++) {
      if (board[row][col]==0) { 
                document.getElementById("cell"+row+col).style.backgroundColor="#FFFFFF";
      } else if (board[row][col]==1) { //1 for yellow
                document.getElementById("cell"+row+col).style.backgroundColor="#FFFF00";
      } else if (board[row][col]==2) { //1 for yellow
                document.getElementById("cell"+row+col).style.backgroundColor="#FF0000";
       }
    }
  }  
}

//HELPERS to check win conditions
function checkRows(matrix){//check horizontal ex. [0 0 0 1 1 1 1]
   for (var row = 0; row < matrix.length; row++){
       for (var col = 0; col < matrix[row].length - 3; col++){
           var element = matrix[row][col];
           if (element == matrix[row][col + 1] && 
               element == matrix[row][col + 2] && 
               element == matrix[row][col + 3] &&
               element == 1){
               return 1;
           }if (element == matrix[row][col + 1] && 
               element == matrix[row][col + 2] && 
               element == matrix[row][col + 3] &&
               element == 2){
               return 2;
           }
       }
   }
   return 0;
}
function checkColumns(matrix){//check vertical
   for (var row = 0; row < matrix.length - 3; row++){
       for (var col = 0; col < matrix[row].length; col++){
           var element = matrix[row][col];
           if (element == matrix[row + 1][col] && 
               element == matrix[row + 2][col] && 
               element == matrix[row + 3][col] &&
               element == 1){
               return 1;
           }if (element == matrix[row + 1][col] && 
               element == matrix[row + 2][col] && 
               element == matrix[row + 3][col] &&
               element == 2){
               return 2;
           }
       }
   }
   return 0;
}
function checkMainDiagonal(matrix){//checks for a positive slope diagonal
   for (var row = 0; row < matrix.length - 3; row++){
       for (var col = 0; col < matrix[row].length - 3; col++){
           var element = matrix[row][col];
           if (element == matrix[row + 1][col + 1] && 
               element == matrix[row + 2][col + 2] && 
               element == matrix[row + 3][col + 3] &&
               element == 1){
               return 1;
           }if (element == matrix[row + 1][col + 1] && 
               element == matrix[row + 2][col + 2] && 
               element == matrix[row + 3][col + 3] &&
               element == 2){
               return 2;
           }
       }
   }
   return 0;
}
function checkCounterDiagonal(matrix){//checks for a negative slope diagonal
   for (var row = 0; row < matrix.length - 3; row++){
       for (var col = 3; col < matrix[row].length; col++){
           var element = matrix[row][col];
           if (element == matrix[row + 1][col - 1] && 
               element == matrix[row + 2][col - 2] && 
               element == matrix[row + 3][col - 3] &&
               element == 1){
               return 1;
           }if (element == matrix[row + 1][col - 1] && 
               element == matrix[row + 2][col - 2] && 
               element == matrix[row + 3][col - 3] &&
               element == 2){
               return 2;
           }
       }
   }
   return 0;
}
//CALLS ALL HELPERS ABOVE to determine if there is win
//will return 0, 1, 2       0 means no one won just yet
//takes in the board matrix as parameter
function determineWin(matrix){
   return  checkRows(matrix) + checkColumns(matrix) + checkMainDiagonal(matrix) + checkCounterDiagonal(matrix);
}
 

//pushes a move into the move history stack
function pushToMoveHistory(row,col){
   moveHistory.push([row,col]);
}
//removes the last piece that was placed
function undoMove() {
   if(!win){//undo only works when nobody has won
      var top = moveHistory[moveHistory.length -1];//gets the "top" of the stack
      board[top[0]][top[1]] = 0; //removes that piece from the board
      saveBoard();
      moveHistory.pop();//pops the top
      updateBoard();//updates the display
   }
   
}

//resets the board
function clearBoard() {
   //all values back to 0
   for(x = 0; x < ROWS; x++){
      for(y = 0; y < COLS; y++)
         board[x][y] = 0;
   }
   win = false;// nobody won
   turn = 1;// current turn is now player 1
   document.getElementById("colorTurn").innerHTML="Yellow Turn (YOU)";//changes the on top of board to display yellow players turn 
   saveBoard();
   updateBoard();

   //clearDbBoard();//resets the board data in the database
}


</script>
<!--*************************************JAVASCRIPT***********END**********************************************-->




<!--Every thing in this p tag: Displays a bunch of stuff like leaderboard and player list-->
<p>
   <div id="player_list" class="box">Player List
      <?php
         $currentUserName = $_SESSION["username"];//session is a global variable for current username

         $sql = "SELECT username FROM users";
         $result = $link->query($sql);

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
   
         $sql = "SELECT * FROM `Friends` WHERE `friend1Username` = '$currentUserName'  OR `friend2Username` = '$currentUserName' ";
         $result = $link->query($sql);

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

         $sql = "SELECT username, wins, losses FROM users ORDER BY wins DESC";
         $result = $link->query($sql);
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
