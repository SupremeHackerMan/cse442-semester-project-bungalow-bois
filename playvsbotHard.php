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
  
?>
 
<!DOCTYPE html>
<html>

<!--links to css file-->
<link rel="stylesheet" href="css/gameBoard.css">
<link rel="stylesheet" href="css/navigationBar.css">
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
<!--loads the board first thing when page refreshes -->
<body onload="loadEmIn()">


<H1>Neck 4 - vs Hard CPU Mode</H1>




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
<input id="resetButton" type="button" value="Make Bot Move" onclick="makeBotMove()" /></br></br><!--resets the board button-->
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
//loads the board from local storage
function loadBoard() {
//localStorage.setItem('init',JSON.stringify("done"));//initializes it only once
   //if(JSON.parse(localStorage.getItem('init')))
   if(localStorage.getItem('easyBoardo'+chainSize)){//checks if save exists or not
      board = JSON.parse(localStorage.getItem('easyBoardo'+chainSize));
      nextTurn(parseInt(JSON.parse(localStorage.getItem('easyTurno'+chainSize))));
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
         winHandler("1Hard CPU");//updates the database on the win
      //checks if player2/red won   
      }if(determineWin(board) == 2){
         document.getElementById("colorTurn").innerHTML="Red Wins!";
         win = true;
         winHandler("2Hard CPU");
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
    var best_move = 0;
    var best_move_score = -10000000;
    

    for(var col = 0; col < 7; col++){
        var row = 5;
        while(row >= 0 && board[row][col] != 0){
            row = row - 1;
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
    selectColumn(best_move);
    return best_move;
}

//this is a hard difficulty bot
//this bot sees diagonals and will actually try to connect 4 isntead
//of just blocking you
function valueBoardState(cur_board) {
   //0 = empty 1 = human 2 = bot
   var score = 0;

   
   for(x = 0; x < ROWS; x++){
      for(y = 0; y < COLS; y++){
         if(cur_board[x][y] == 1){
            //this is a human piece so this is negative score
            //we first check the chain in the vertical direction
            //note we have -2 here and +1 in the next portion
            //so our bot slightly prefers blocking compared to attacking
            v_score = -2;
            vertical = x;

            while(vertical >=0 && cur_board[vertical][y] == 1){
               v_score = v_score * 10;
               vertical = vertical - 1;
            }
            //now we say if this chain is closed off by the wall or our piece
            //the points are not added to the score
            if(vertical < 0 || cur_board[vertical][y] == 2){
               score = score; // do nothing
            }
            else{
               score = score + v_score;
            }

            //next horizontal direction
            h_score = -2;
            horizontal = y;

            while(horizontal < COLS && cur_board[x][horizontal] == 1){
               h_score = h_score * 10;
               horizontal = horizontal + 1;
            }
            if((horizontal == COLS || cur_board[x][horizontal] == 2)&&(y - 1 < 0 || cur_board[x][y - 1] == 2)){
                console.log("skipped score"+y+" "+cur_board[x][y-1]);
               score = score;
            }
            //if 1 side is blocked off we add half the points
            else if((horizontal == COLS || cur_board[x][horizontal] == 2) || (y - 1 < 0 || cur_board[x][y - 1] == 2)){
               h_score = h_score / 2;
               score = score + h_score;
               console.log("half");
            }
            else{
                score = score + h_score;
            }

            diag1_score = -2;
            vertical = x;
            horizontal = y;
            /*  this diagonal goes up and to the right
                   x
                  x
                 x
                x
            */
            while(horizontal < COLS && vertical >= 0 && cur_board[vertical][horizontal] == 1){
                diag1_score = diag1_score * 10;
                vertical = vertical - 1;      //upwards
                horizontal = horizontal + 1;  //to the right
            }
            if(vertical < 0 || horizontal == COLS || cur_board[vertical][horizontal] == 2){
                score = score;
            }
            else{
                score = score + diag1_score;
            }

            diag2_score = -2;
            vertical = x;
            horizontal = y;
            /*  this diagonal goes up and to the left
                x
                 x
                  x
                   x
            */
            while(horizontal >= 0 && vertical < ROWS && cur_board[vertical][horizontal] == 1){
                diag2_score = diag2_score * 10;
                vertical = vertical - 1;      //upwards
                horizontal = horizontal - 1;  //to the left
            }
            if(vertical < 0 || horizontal < 0|| cur_board[vertical][horizontal] == 2){
                score = score;
            }
            else{
                score = score + diag2_score;
            }
            console.log("h "+h_score+" v "+v_score+" d1 "+diag1_score+" d2 "+diag2_score+" score "+score);
            
         }
         //now we have to do the opposite thing for our pieces
         if(cur_board[x][y] == 2){
            //the scores are now positive because we want longer chains
            v_score = 1;
            vertical = x;

            while(vertical >=0 && cur_board[vertical][y] == 2){
               v_score = v_score * 10;
               vertical = vertical - 1;
            }
            //now we say if we get 4 in a row take it because we win
            if(x - 4 == vertical){
                return 100000;
            }
            //if this chain is blocked off its worthless to us
            //should add check to make sure theres room for 4 in a row
            if(vertical < 0 || cur_board[vertical][y] == 1){
               score = score; // do nothing
            }
            else{
               score = score + v_score;
            }

            //next horizontal direction
            h_score = 1;
            horizontal = y;

            while(horizontal < COLS && cur_board[x][horizontal] == 2){
               h_score = h_score * 10;
               horizontal = horizontal + 1;
            }
            if(y + 4 == horizontal){
                return 100000;
            }
            if(horizontal == COLS || cur_board[x][horizontal] == 1){
               score = score;
            }
            else{
               score = score + h_score;
            }

            diag1_score = 1;
            vertical = x;
            horizontal = y;
            /*  this diagonal goes up and to the right
                   x
                  x
                 x
                x
            */
            while(horizontal < COLS && vertical >= 0 && cur_board[vertical][horizontal] == 2){
                diag1_score = diag1_score * 10;
                vertical = vertical - 1;      //upwards
                horizontal = horizontal + 1;  //to the right
            }
            if(x - 4 == vertical && y + 4 == horizontal){
                return 100000;
            }
            if(vertical < 0 || horizontal == COLS || cur_board[vertical][horizontal] == 1){
                score = score;
            }
            else{
                score = score + diag1_score;
            }

            diag2_score = 1;
            vertical = x;
            horizontal = y;
            /*  this diagonal goes up and to the left
                x
                 x
                  x
                   x
            */
            while(horizontal >= 0 && vertical < ROWS && cur_board[vertical][horizontal] == 2){
                diag2_score = diag2_score * 10;
                vertical = vertical - 1;      //upwards
                horizontal = horizontal - 1;  //to the left
            }
            if(x - 4 == vertical && y - 4 == horizontal){
                return 100000;
            }
            if(vertical < 0 || horizontal < 0|| cur_board[vertical][horizontal] == 1){
                score = score;
            }
            else{
                score = score + diag2_score;
            }
            
         }
      }
         
   }
   
   return score;
}
</script>
</body>
</html>
