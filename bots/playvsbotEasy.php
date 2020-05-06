<?php
   ini_set('display_errors', 1); 
   error_reporting(E_ALL);
   // Initialize the session
   session_start();

   include '../config.php';
   // Check if the user is logged in, if not then redirect him to login page
   if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
      header("location: index.php");
      exit;
   }
   $currentUserName = $_SESSION["username"];
  
?>
 
<!DOCTYPE html>
<html>

<!--links to css file-->
<link rel="stylesheet" href="../css/gameBoard.css">
<link rel="stylesheet" href="../css/navigationBar.css">
<script type="text/javascript" src="scripts.js"></script>

<script>
function loadEmIn(){
   loadBoard();//loads board data that was saved in local storage
   getPlayerInfo();//retrives current players rankings and displays it top left
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
   <!--Navigation bar-->
   <div class="topnav">
      <a href="../logout.php" class="btn btn-danger">Log Out</a><!--logout button-->
      <a href="../settings.php">Settings</a>
      <a class="active" href="#game">Play Game</a>
      <a href="../friends.php">Friends</a>
      <a href="../profile.php">Profile</a>
      <a href="../home.php">Home</a>

      <!--shows player name and wins/losses-->
      <div class = "playInfo" id = "pInfo" > </div>
   </div>
</head>
<!--loads the board first thing when page refreshes -->
<body onload="loadEmIn()">


<H1>Neck 4 - vs Easy CPU Mode</H1>




<div id="colorTurn">Yellow Turn (YOU)</div>
<div id="board">
<div class="row">
  <div class="cell" id="cell00" onclick="placePiece(0)"></div>
  <div class="cell" id="cell01" onclick="placePiece(1)"></div>
  <div class="cell" id="cell02" onclick="placePiece(2)"></div>
  <div class="cell" id="cell03" onclick="placePiece(3)"></div>
  <div class="cell" id="cell04" onclick="placePiece(4)"></div>
  <div class="cell" id="cell05" onclick="placePiece(5)"></div>
  <div class="cell" id="cell06" onclick="placePiece(6)"></div>
</div>
<div class="row">  
  <div class="cell" id="cell10" onclick="placePiece(0)"></div>
  <div class="cell" id="cell11" onclick="placePiece(1)"></div>
  <div class="cell" id="cell12" onclick="placePiece(2)"></div>
  <div class="cell" id="cell13" onclick="placePiece(3)"></div>
  <div class="cell" id="cell14" onclick="placePiece(4)"></div>
  <div class="cell" id="cell15" onclick="placePiece(5)"></div>
  <div class="cell" id="cell16" onclick="placePiece(6)"></div>
</div>
<div class="row">  
  <div class="cell" id="cell20" onclick="placePiece(0)"></div>
  <div class="cell" id="cell21" onclick="placePiece(1)"></div>
  <div class="cell" id="cell22" onclick="placePiece(2)"></div>
  <div class="cell" id="cell23" onclick="placePiece(3)"></div>
  <div class="cell" id="cell24" onclick="placePiece(4)"></div>
  <div class="cell" id="cell25" onclick="placePiece(5)"></div>
  <div class="cell" id="cell26" onclick="placePiece(6)"></div>
</div>
<div class="row">  
  <div class="cell" id="cell30" onclick="placePiece(0)"></div>
  <div class="cell" id="cell31" onclick="placePiece(1)"></div>
  <div class="cell" id="cell32" onclick="placePiece(2)"></div>
  <div class="cell" id="cell33" onclick="placePiece(3)"></div>
  <div class="cell" id="cell34" onclick="placePiece(4)"></div>
  <div class="cell" id="cell35" onclick="placePiece(5)"></div>
  <div class="cell" id="cell36" onclick="placePiece(6)"></div>
</div>
<div class="row">
  <div class="cell" id="cell40" onclick="placePiece(0)"></div>
  <div class="cell" id="cell41" onclick="placePiece(1)"></div>
  <div class="cell" id="cell42" onclick="placePiece(2)"></div>
  <div class="cell" id="cell43" onclick="placePiece(3)"></div>
  <div class="cell" id="cell44" onclick="placePiece(4)"></div>
  <div class="cell" id="cell45" onclick="placePiece(5)"></div>
  <div class="cell" id="cell46" onclick="placePiece(6)"></div>
</div>
<div class="row">
  <div class="cell" id="cell50" onclick="placePiece(0)"></div>
  <div class="cell" id="cell51" onclick="placePiece(1)"></div>
  <div class="cell" id="cell52" onclick="placePiece(2)"></div>
  <div class="cell" id="cell53" onclick="placePiece(3)"></div>
  <div class="cell" id="cell54" onclick="placePiece(4)"></div>
  <div class="cell" id="cell55" onclick="placePiece(5)"></div>
  <div class="cell" id="cell56" onclick="placePiece(6)"></div>
</div>
</div>
<input id="undoButton" type="button" value="Undo" onclick="undoMove()" /></br></br><!--button to undo a move-->
<input id="resetButton" type="button" value="Clear/Start New Game" onclick="clearBoard()" /></br></br><!--resets the board button-->
<!--<input id="loadButton" type="button" value="Load Game" onclick="loadBoard()" /></br></br>-->


<!--*************************************JAVASCRIPT***********Start**********************************************-->
<script>
//colors of pieces
var p1Color = "Yellow";
var p2Color = "Red";
var p1Colorhex = "#FFFF00";
var p2Colorhex = "#FF0000";

const COLS = 7;
const ROWS = 6;
const chainSize = 4// default is 4 consecutive pieces to win

var board = [];
var turn = 1; //1 for Yellow, 2 for Red
var win = false;

//saves the index position of previos move   -1,-1 means there is no move saved
var prevMove = [-1,-1];



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
function placePiece(col) {
   selectColumn(col);
   makeBotMove();
}
//loads the board from local storage
function loadBoard() {
//localStorage.setItem('init',JSON.stringify("done"));//initializes it only once
   //if(JSON.parse(localStorage.getItem('init')))
   newBoard(board);
   updateBoard();
}
function saveBoard(){
   if(!win){
      localStorage.setItem('easyBoardo'+chainSize,JSON.stringify(board));
      localStorage.setItem('easyTurno'+chainSize,JSON.stringify(turn));

      console.log("saved turn: "+JSON.stringify(turn));
      console.log(JSON.stringify(board));
   }else if(win){
      ford = [];
      newBoard(ford);
      localStorage.setItem('easyBoardo'+chainSize,JSON.stringify(ford));
      localStorage.setItem('easyTurno'+chainSize,JSON.stringify(1));

      console.log("saved turn: "+JSON.stringify(turn));
      console.log(JSON.stringify(ford));
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
         nextTurn(2);  
      }

      else {
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
         nextTurn(1); 
      }
      if(determineWin(board) == 1){
         document.getElementById("colorTurn").innerHTML="Yellow (YOU) Win!";
         win = true;
         winHandler("1Easy CPU");//updates the database on the win
      //checks if player2/red won   
      }if(determineWin(board) == 2){
         document.getElementById("colorTurn").innerHTML="Red Wins!";
         win = true;
         winHandler("2Easy CPU");
      //checks for ties ie the board is filled up and nobody wins
      }else if(row == 0){
         if(!board[row].includes(0)){//if no zeros on the top row then board is filled and no one won
            document.getElementById("colorTurn").innerHTML="Nobody Wins, You're all losers.";
            win = true;//setting to true will stop the game; 
         }
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
                document.getElementById("cell"+row+col).style.backgroundColor="#FFFFFF";
      } else if (board[row][col]==1) { //1 for yellow
                document.getElementById("cell"+row+col).style.backgroundColor="#FFFF00";
      } else if (board[row][col]==2) { //2 for red
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
 

//adds a move into the move history 
function pushToMoveHistory(row,col){
   prevMove[0]=row;
   prevMove[1]=col;
}
//removes the last piece that was placed
function undoMove() {
   if(!win && prevMove[0] != -1){//undo only works when nobody has won and previous move is not empty (-1 means its empty)
      board[prevMove[0]][prevMove[1]] = 0; //removes that piece from the board
      saveBoard();
      prevMove = [-1,-1];//resets previous move
      nextTurn(turn == 1? 2:1);
      updateBoard();//updates the display
   }
}
//sets the turn and updates the display accordingly
function nextTurn(pturn) {
   turn = pturn;
   document.getElementById("colorTurn").innerHTML= turn==1? p1Color+" Turn (YOU)":p2Color+" Turn";
   
}


//resets the board and the display
function clearBoard() {
   //all values back to 0
   for(x = 0; x < ROWS; x++){
      for(y = 0; y < COLS; y++)
         board[x][y] = 0;
   }
   win = false;// nobody won
   nextTurn(1);//sets the turn back to player 1
   saveBoard();
   updateBoard();
}


function makeBotMove() {
   if(turn == 2){
    var best_move = 0;
    var best_move_score = -10000000;
    
    console.log(board);

    for(var col = 0; col < 7; col++){
        var row = 5;
        while(row >= 0 && board[row][col] != 0){
            row--;
        }
        if(row >= 0){
            board[row][col] = 2;
            var new_score = valueBoardState(board);
            console.log(col+" "+new_score);
            if(new_score > best_move_score){
                best_move = col;
                best_move_score = new_score;
            }
            board[row][col] = 0;
        } 
    }
    console.log(board);
    console.log(best_move);
    selectColumn(best_move);
    nextTurn(1); 
    return best_move;
   }
   return -1;
}

//this is an easy difficulty bot
//it just makes random moves
function valueBoardState(cur_board) {

    return Math.random();
}

</script>
</body>
</html>
