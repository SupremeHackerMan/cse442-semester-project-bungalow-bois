<?php
   ini_set('display_errors', 1); 
   error_reporting(E_ALL);
   include 'config.php';
   // Initialize the session
   session_start();
   // Check if the user is logged in, if not then redirect him to login page
   if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
      header("location: login.php");
      exit;
   }
   $currentUserName = $_SESSION["username"];
?>
 
<!DOCTYPE html>

<link rel="stylesheet" href="css/gameBoard.css">
<link rel="stylesheet" href="css/navigationBar.css">
<script type="text/javascript" src="scripts.js"></script>

<html>

<script>
function loadEmIn(){
   loadBoard();//loads board data that was saved in local storage
   getPlayerInfo();//retrives current players rankings and displays it top left
}
</script>

<head>
   <!--Navigation bar-->
   <div class="topnav">
      <a href="logout.php" class="btn btn-danger">Log Out</a><!--logout button-->
      <a href="settings.php">Settings</a>
      <a class="active" href="#game">Play Game</a>
      <a href="friends.php">Friends</a>
      <a href="profile.php">Profile</a>
      <a href="home.php">Home</a>

      <!--shows player name and wins/losses-->
      <div class = "playInfo" id = "pInfo" > </div>
   </div> 
</head>
<body>
<body onload="loadEmIn()">

<H1>Neck 8 - Local Multiplayer Mode</H1>


<div id="colorTurn">Yellow Turn (Thats You)</div>
<div id="board8">
<div class="row">
  <div class="cell" id="cell0-0" onclick="selectColumn(0)"></div>
  <div class="cell" id="cell0-1" onclick="selectColumn(1)"></div>
  <div class="cell" id="cell0-2" onclick="selectColumn(2)"></div>
  <div class="cell" id="cell0-3" onclick="selectColumn(3)"></div>
  <div class="cell" id="cell0-4" onclick="selectColumn(4)"></div>
  <div class="cell" id="cell0-5" onclick="selectColumn(5)"></div>
  <div class="cell" id="cell0-6" onclick="selectColumn(6)"></div>
  <div class="cell" id="cell0-7" onclick="selectColumn(7)"></div>
  <div class="cell" id="cell0-8" onclick="selectColumn(8)"></div>
  <div class="cell" id="cell0-9" onclick="selectColumn(9)"></div>
  <div class="cell" id="cell0-10" onclick="selectColumn(10)"></div>
  <div class="cell" id="cell0-11" onclick="selectColumn(11)"></div>

</div>
<div class="row">  
  <div class="cell" id="cell1-0" onclick="selectColumn(0)"></div>
  <div class="cell" id="cell1-1" onclick="selectColumn(1)"></div>
  <div class="cell" id="cell1-2" onclick="selectColumn(2)"></div>
  <div class="cell" id="cell1-3" onclick="selectColumn(3)"></div>
  <div class="cell" id="cell1-4" onclick="selectColumn(4)"></div>
  <div class="cell" id="cell1-5" onclick="selectColumn(5)"></div>
  <div class="cell" id="cell1-6" onclick="selectColumn(6)"></div>
  <div class="cell" id="cell1-7" onclick="selectColumn(7)"></div>
  <div class="cell" id="cell1-8" onclick="selectColumn(8)"></div>
  <div class="cell" id="cell1-9" onclick="selectColumn(9)"></div>
  <div class="cell" id="cell1-10" onclick="selectColumn(10)"></div>
  <div class="cell" id="cell1-11" onclick="selectColumn(11)"></div>

</div>
<div class="row">  
  <div class="cell" id="cell2-0" onclick="selectColumn(0)"></div>
  <div class="cell" id="cell2-1" onclick="selectColumn(1)"></div>
  <div class="cell" id="cell2-2" onclick="selectColumn(2)"></div>
  <div class="cell" id="cell2-3" onclick="selectColumn(3)"></div>
  <div class="cell" id="cell2-4" onclick="selectColumn(4)"></div>
  <div class="cell" id="cell2-5" onclick="selectColumn(5)"></div>
  <div class="cell" id="cell2-6" onclick="selectColumn(6)"></div>
  <div class="cell" id="cell2-7" onclick="selectColumn(7)"></div>
  <div class="cell" id="cell2-8" onclick="selectColumn(8)"></div>
  <div class="cell" id="cell2-9" onclick="selectColumn(9)"></div>
  <div class="cell" id="cell2-10" onclick="selectColumn(10)"></div>
  <div class="cell" id="cell2-11" onclick="selectColumn(11)"></div>

</div>
<div class="row">  
  <div class="cell" id="cell3-0" onclick="selectColumn(0)"></div>
  <div class="cell" id="cell3-1" onclick="selectColumn(1)"></div>
  <div class="cell" id="cell3-2" onclick="selectColumn(2)"></div>
  <div class="cell" id="cell3-3" onclick="selectColumn(3)"></div>
  <div class="cell" id="cell3-4" onclick="selectColumn(4)"></div>
  <div class="cell" id="cell3-5" onclick="selectColumn(5)"></div>
  <div class="cell" id="cell3-6" onclick="selectColumn(6)"></div>
  <div class="cell" id="cell3-7" onclick="selectColumn(7)"></div>
  <div class="cell" id="cell3-8" onclick="selectColumn(8)"></div>
  <div class="cell" id="cell3-9" onclick="selectColumn(9)"></div>
  <div class="cell" id="cell3-10" onclick="selectColumn(10)"></div>
  <div class="cell" id="cell3-11" onclick="selectColumn(11)"></div>

</div>
<div class="row">
  <div class="cell" id="cell4-0" onclick="selectColumn(0)"></div>
  <div class="cell" id="cell4-1" onclick="selectColumn(1)"></div>
  <div class="cell" id="cell4-2" onclick="selectColumn(2)"></div>
  <div class="cell" id="cell4-3" onclick="selectColumn(3)"></div>
  <div class="cell" id="cell4-4" onclick="selectColumn(4)"></div>
  <div class="cell" id="cell4-5" onclick="selectColumn(5)"></div>
  <div class="cell" id="cell4-6" onclick="selectColumn(6)"></div>
  <div class="cell" id="cell4-7" onclick="selectColumn(7)"></div>
  <div class="cell" id="cell4-8" onclick="selectColumn(8)"></div>
  <div class="cell" id="cell4-9" onclick="selectColumn(9)"></div>
  <div class="cell" id="cell4-10" onclick="selectColumn(10)"></div>
  <div class="cell" id="cell4-11" onclick="selectColumn(11)"></div>

</div>
<div class="row">
  <div class="cell" id="cell5-0" onclick="selectColumn(0)"></div>
  <div class="cell" id="cell5-1" onclick="selectColumn(1)"></div>
  <div class="cell" id="cell5-2" onclick="selectColumn(2)"></div>
  <div class="cell" id="cell5-3" onclick="selectColumn(3)"></div>
  <div class="cell" id="cell5-4" onclick="selectColumn(4)"></div>
  <div class="cell" id="cell5-5" onclick="selectColumn(5)"></div>
  <div class="cell" id="cell5-6" onclick="selectColumn(6)"></div>
  <div class="cell" id="cell5-7" onclick="selectColumn(7)"></div>
  <div class="cell" id="cell5-8" onclick="selectColumn(8)"></div>
  <div class="cell" id="cell5-9" onclick="selectColumn(9)"></div>
  <div class="cell" id="cell5-10" onclick="selectColumn(10)"></div>
  <div class="cell" id="cell5-11" onclick="selectColumn(11)"></div>

</div>
<div class="row">
  <div class="cell" id="cell6-0" onclick="selectColumn(0)"></div>
  <div class="cell" id="cell6-1" onclick="selectColumn(1)"></div>
  <div class="cell" id="cell6-2" onclick="selectColumn(2)"></div>
  <div class="cell" id="cell6-3" onclick="selectColumn(3)"></div>
  <div class="cell" id="cell6-4" onclick="selectColumn(4)"></div>
  <div class="cell" id="cell6-5" onclick="selectColumn(5)"></div>
  <div class="cell" id="cell6-6" onclick="selectColumn(6)"></div>
  <div class="cell" id="cell6-7" onclick="selectColumn(7)"></div>
  <div class="cell" id="cell6-8" onclick="selectColumn(8)"></div>
  <div class="cell" id="cell6-9" onclick="selectColumn(9)"></div>
  <div class="cell" id="cell6-10" onclick="selectColumn(10)"></div>
  <div class="cell" id="cell6-11" onclick="selectColumn(11)"></div>

</div>

<div class="row">
  <div class="cell" id="cell7-0" onclick="selectColumn(0)"></div>
  <div class="cell" id="cell7-1" onclick="selectColumn(1)"></div>
  <div class="cell" id="cell7-2" onclick="selectColumn(2)"></div>
  <div class="cell" id="cell7-3" onclick="selectColumn(3)"></div>
  <div class="cell" id="cell7-4" onclick="selectColumn(4)"></div>
  <div class="cell" id="cell7-5" onclick="selectColumn(5)"></div>
  <div class="cell" id="cell7-6" onclick="selectColumn(6)"></div>
  <div class="cell" id="cell7-7" onclick="selectColumn(7)"></div>
  <div class="cell" id="cell7-8" onclick="selectColumn(8)"></div>
  <div class="cell" id="cell7-9" onclick="selectColumn(9)"></div>
  <div class="cell" id="cell7-10" onclick="selectColumn(10)"></div>
  <div class="cell" id="cell7-11" onclick="selectColumn(11)"></div>

</div>
<div class="row">  
  <div class="cell" id="cell8-0" onclick="selectColumn(0)"></div>
  <div class="cell" id="cell8-1" onclick="selectColumn(1)"></div>
  <div class="cell" id="cell8-2" onclick="selectColumn(2)"></div>
  <div class="cell" id="cell8-3" onclick="selectColumn(3)"></div>
  <div class="cell" id="cell8-4" onclick="selectColumn(4)"></div>
  <div class="cell" id="cell8-5" onclick="selectColumn(5)"></div>
  <div class="cell" id="cell8-6" onclick="selectColumn(6)"></div>
  <div class="cell" id="cell8-7" onclick="selectColumn(7)"></div>
  <div class="cell" id="cell8-8" onclick="selectColumn(8)"></div>
  <div class="cell" id="cell8-9" onclick="selectColumn(9)"></div>
  <div class="cell" id="cell8-10" onclick="selectColumn(10)"></div>
  <div class="cell" id="cell8-11" onclick="selectColumn(11)"></div>

</div>
<div class="row">  
  <div class="cell" id="cell9-0" onclick="selectColumn(0)"></div>
  <div class="cell" id="cell9-1" onclick="selectColumn(1)"></div>
  <div class="cell" id="cell9-2" onclick="selectColumn(2)"></div>
  <div class="cell" id="cell9-3" onclick="selectColumn(3)"></div>
  <div class="cell" id="cell9-4" onclick="selectColumn(4)"></div>
  <div class="cell" id="cell9-5" onclick="selectColumn(5)"></div>
  <div class="cell" id="cell9-6" onclick="selectColumn(6)"></div>
  <div class="cell" id="cell9-7" onclick="selectColumn(7)"></div>
  <div class="cell" id="cell9-8" onclick="selectColumn(8)"></div>
  <div class="cell" id="cell9-9" onclick="selectColumn(9)"></div>
  <div class="cell" id="cell9-10" onclick="selectColumn(10)"></div>
  <div class="cell" id="cell9-11" onclick="selectColumn(11)"></div>

</div>
<div class="row">  
  <div class="cell" id="cell10-0" onclick="selectColumn(0)"></div>
  <div class="cell" id="cell10-1" onclick="selectColumn(1)"></div>
  <div class="cell" id="cell10-2" onclick="selectColumn(2)"></div>
  <div class="cell" id="cell10-3" onclick="selectColumn(3)"></div>
  <div class="cell" id="cell10-4" onclick="selectColumn(4)"></div>
  <div class="cell" id="cell10-5" onclick="selectColumn(5)"></div>
  <div class="cell" id="cell10-6" onclick="selectColumn(6)"></div>
  <div class="cell" id="cell10-7" onclick="selectColumn(7)"></div>
  <div class="cell" id="cell10-8" onclick="selectColumn(8)"></div>
  <div class="cell" id="cell10-9" onclick="selectColumn(9)"></div>
  <div class="cell" id="cell10-10" onclick="selectColumn(10)"></div>
  <div class="cell" id="cell10-11" onclick="selectColumn(11)"></div>

</div>

</div>
<input id="resetButton" type="button" value="Undo" onclick="undoMove()" /></br></br><!--button to undo a move-->
<input id="resetButton" type="button" value="Clear/Start New Game" onclick="clearBoard()" /></br></br><!--resets the board button-->


<!--*************************************JAVASCRIPT***********Start**********************************************-->
<script>
var p1Color = "Yellow";
var p2Color = "Red";
var p1Colorhex = "#FFFF00";
var p2Colorhex = "#FF0000";

const COLS = 12;
const ROWS = 11;
const chainSize = 8// default is 4 consecutive pieces to win

var board = [];
var turn = 1; //1 for Yellow, 2 for Red
var win = false;

//saves all moves into a "stack"    -   this is for the undo button
//ex. if p1 makes a move at positions board[1][2] then [1,2] will be pushed to the stack
var moveHistory = [];

/*
INITIALIZE A NEW BOARD
should look like this
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
//loads the board from local storage
function loadBoard() {
   //localStorage.setItem('init',JSON.stringify("done"));//initializes it only once
   //if(JSON.parse(localStorage.getItem('init')))
   if(localStorage.getItem('boardo'+chainSize)){//checks if save exists or not
      board = JSON.parse(localStorage.getItem('boardo'+chainSize));
      turn = parseInt(JSON.parse(localStorage.getItem('turno'+chainSize)));
      document.getElementById("colorTurn").innerHTML= turn==1? p1Color+" Turn (YOU)":p2Color+" Turn";
   }else{//if not start a new game
      newBoard(board);
      saveBoard();
   }
   console.log("loaded turn: "+turn);
   console.log(board);
   updateBoard();
}
function saveBoard(){
   if(!win){
      localStorage.setItem('boardo'+chainSize,JSON.stringify(board));
      localStorage.setItem('turno'+chainSize,JSON.stringify(turn));

      console.log("saved turn: "+JSON.stringify(turn));
      console.log(JSON.stringify(board));
   }
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
         document.getElementById("colorTurn").innerHTML="Yellow Turn";//changes the on top of board to display yellow players turn 
      }
      
      //checks if player1/yellow won
      if(determineWin(board) == 1){
         document.getElementById("colorTurn").innerHTML="Yellow/You Win!";
         win = true;
         winHandler("1");//updates the database on the win
      //checks if player2/red won   
      }if(determineWin(board) == 2){
         document.getElementById("colorTurn").innerHTML="Red Wins!";
         win = true;
         winHandler("2");
      }
      getPlayerInfo();
      saveBoard();
      updateBoard();//updates the display for the board
   }
   
}

//refreshes the connect 4 board after each turn
function updateBoard() {
  for (var row = 0; row < ROWS; row++) {
    for (var col = 0; col < COLS; col++) {
      if (board[row][col]==0) { 
                document.getElementById("cell"+row+"-"+col).style.backgroundColor="#FFFFFF";
      } else if (board[row][col]==1) { //1 for yellow
                document.getElementById("cell"+row+"-"+col).style.backgroundColor="#FFFF00";
      } else if (board[row][col]==2) { //1 for yellow
                document.getElementById("cell"+row+"-"+col).style.backgroundColor="#FF0000";
       }
    }
  }  
}

//ray
//HELPERS to check win conditions
function checkRows(matrix){//check horizontal ex. [0 0 0 1 1 1 1]
   for (var row = 0; row < matrix.length; row++){
       for (var col = 0; col < matrix[row].length - 7; col++){
           var element = matrix[row][col];
           if (element == matrix[row][col + 1] && 
               element == matrix[row][col + 2] && 
               element == matrix[row][col + 3] &&
               element == matrix[row][col + 4] &&
               element == matrix[row][col + 5] &&
               element == matrix[row][col + 6] &&
               element == matrix[row][col + 7] &&
               element == 1){
               return 1;
           }if (element == matrix[row][col + 1] && 
               element == matrix[row][col + 2] && 
               element == matrix[row][col + 3] &&
               element == matrix[row][col + 4] &&
               element == matrix[row][col + 5] &&
               element == matrix[row][col + 6] &&
               element == matrix[row][col + 7] &&
               element == 2){
               return 2;
           }
       }
   }
   return 0;
}
//ray
function checkColumns(matrix){//check vertical
   for (var row = 0; row < matrix.length - 7; row++){
       for (var col = 0; col < matrix[row].length; col++){
           var element = matrix[row][col];
           if (element == matrix[row + 1][col] && 
               element == matrix[row + 2][col] && 
               element == matrix[row + 3][col] &&
               element == matrix[row + 4][col] &&
               element == matrix[row + 5][col] &&
               element == matrix[row + 6][col] &&
               element == matrix[row + 7][col] &&
               element == 1){
               return 1;
           }if (element == matrix[row + 1][col] && 
               element == matrix[row + 2][col] && 
               element == matrix[row + 3][col] &&
               element == matrix[row + 4][col] &&
               element == matrix[row + 5][col] &&
               element == matrix[row + 6][col] &&
               element == matrix[row + 7][col] &&
               element == 2){
               return 2;
           }
       }
   }
   return 0;
}
//ray
function checkMainDiagonal(matrix){//checks for a positive slope diagonal
   for (var row = 0; row < matrix.length - 7; row++){
       for (var col = 0; col < matrix[row].length - 5; col++){
           var element = matrix[row][col];
           if (element == matrix[row + 1][col + 1] && 
               element == matrix[row + 2][col + 2] && 
               element == matrix[row + 3][col + 3] &&
               element == matrix[row + 4][col + 4] &&
               element == matrix[row + 5][col + 5] &&
               element == matrix[row + 6][col + 6] &&
               element == matrix[row + 7][col + 7] &&
               element == 1){
               return 1;
           }if (element == matrix[row + 1][col + 1] && 
               element == matrix[row + 2][col + 2] && 
               element == matrix[row + 3][col + 3] &&
               element == matrix[row + 4][col + 4] &&
               element == matrix[row + 5][col + 5] &&
               element == matrix[row + 6][col + 6] &&
               element == matrix[row + 7][col + 7] &&
               element == 2){
               return 2;
           }
       }
   }
   return 0;
}
//ray
function checkCounterDiagonal(matrix){//checks for a negative slope diagonal
   for (var row = 0; row < matrix.length - 7; row++){
       for (var col = 3; col < matrix[row].length; col++){
           var element = matrix[row][col];
           if (element == matrix[row + 1][col - 1] && 
               element == matrix[row + 2][col - 2] && 
               element == matrix[row + 3][col - 3] &&
               element == matrix[row + 4][col - 4] &&
               element == matrix[row + 5][col - 5] &&
               element == matrix[row + 6][col - 6] &&
               element == matrix[row + 7][col - 7] &&
               element == 1){
               return 1;
           }if (element == matrix[row + 1][col - 1] && 
               element == matrix[row + 2][col - 2] && 
               element == matrix[row + 3][col - 3] &&
               element == matrix[row + 4][col - 4] &&
               element == matrix[row + 5][col - 5] &&
               element == matrix[row + 6][col - 6] &&
               element == matrix[row + 7][col - 7] &&
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
      moveHistory.pop();//pops the top
      saveBoard();
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
   document.getElementById("colorTurn").innerHTML="Yellow/your Turn";//changes the on top of board to display yellow players turn 
   saveBoard();
   updateBoard();
   
}


</script>

</body>
</html>
