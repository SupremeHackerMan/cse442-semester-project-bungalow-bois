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

   $turn =  $link->query("SELECT Turn FROM `OnlinePlay` WHERE (`Player1` = '$currentUserName')");//checks if players saved game is there or not
   $turn2 = $link->query("SELECT Turn FROM `OnlinePlay` WHERE (`Player2` = '$currentUserName')");
  
   if ($turn->num_rows == 1){
       //we are player 1
       $row = $turn->fetch_assoc();
       echo "<br>You are player one " . $row["Turn"].  "<br>";
       //if its not ur turn then make them exit
        if($row["Turn"] == 2){
            header("location: settings.php");
            
            echo '<script language="javascript">';
            echo 'alert("message successfully sent")';
            echo '</script>';

            exit;
        }
   }
   if ($turn2->num_rows == 1){
       //we are player 2
       $row = $turn2->fetch_assoc();
       echo "<br>You are player two " . $row["Turn"].  "<br>";
       //if its not ur turn then make them exit
        if($row["Turn"] == 1){
            //echo "<br>It is not your turn to play<br>"
            header("location: settings.php");
            exit;
    }
   }
?>
<html>

<link rel="stylesheet" href="css/gameBoard.css">
<link rel="stylesheet" href="css/navigationBar.css">

<head>

<script type="text/javascript" src="scripts.js"></script>
<!--<script type="text/javascript" src="scripts.js"></script>-->
<script>
function loadEmIn(){
   loadBoard();//loads board data from tethys
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

   </div>
</head>
<!--loads the board first thing when page refreshes -->
<body onload="loadEmIn()">

<H1>Neck 4 - Local Multiplayer Mode</H1>




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
<input id="confirmButton" type="button" value="Confirm Move" onclick="confirmMove()" /></br></br><!--resets the board button-->
<!--<input id="loadButton" type="button" value="Load Game" onclick="loadBoard()" /></br></br>-->

<script>
var p1Color = "Yellow";
var p2Color = "Red";
var p1Colorhex = "#FFFF00";
var p2Colorhex = "#FF0000";
var prevMove = [-1,-1];


const COLS = 7;
const ROWS = 6;
const chainSize = 4// default is 4 consecutive pieces to win

var board = [];
var turn = 1; //1 for Yellow, 2 for Red
var win = false;
var moved = false;
var loadedIn = false;

function newBoard(board){
   for(x = 0; x < ROWS; x++){
      board[x] = []
      for(y = 0; y < COLS; y++){
         board[x][y] = 0;
      }
   }
   
}



//loads the board from the table on tethys. Its stored there as 6 strings, each one corresponds to a row
function loadBoard() {
    newBoard(board);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var fromTable = (this.responseText).split("");
            var idx = 0;
            for (var i = 0; i < ROWS; i++) {
                for (var j = 0; i < COLS; j++) {
                    if(idx >= COLS * ROWS){
                        break;
                    }
                    board[i][j] = parseInt(fromTable[idx]);
                    //console.log(board[i][j]);
                    setBoard(i,j,board[i][j]);
                    idx++;
                    
                }
            }
            
        }
    };
    xmlhttp.open("GET", "loadBoard.php", true);
    xmlhttp.send();
    updateBoard();
    loadTurn();
    

}

//loads the current turn
function loadTurn() {
    console.log("enterd");
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var new_turn = this.responseText;
            turn = new_turn;
            console.log(new_turn);
            setTurn(new_turn);
        }
    };
    xmlhttp.open("GET", "loadTurn.php", true);
    xmlhttp.send();
}

function fixBoard(){
    var index = 0;
    
    //console.log(board[0].length);
    for (var row = 0; row < ROWS; row++) {
        for (var col = 0; col < COLS; col++) {
            //console.log(board[0][index]);
            board[row][col] = board[0][index];
            index = index + 1;
        }
    }  
    updateBoard();
    loadedIn = true;

    //after we fix and update the board we have to check if the other player just won
    //checks if player1/yellow won
    if(determineWin(board) == 1){
            document.getElementById("colorTurn").innerHTML="Yellow (YOU) Win!";
            win = true;
            winHandler("1");//updates the database on the win
        //checks if player2/red won   
    }if(determineWin(board) == 2){
            document.getElementById("colorTurn").innerHTML="Red Wins!";
            win = true;
            winHandler("2");
        }
}
function setBoard(x,y, val){
    board[x][y] = val;
    //console.log(board);
}
function setTurn(new_turn){
    turn = new_turn;
}
//saves a row into database
function saveBoard(){
    for(var i = 0; i < ROWS; i++){
        var row = i;
        if(row <= ROWS){
            //console.log(board);
            var combine = board[row].join('');
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    
                    console.log(this.responseText);
                }
            };
            xmlhttp.open("POST", "saveBoard.php?b=" + row + combine, true);
            xmlhttp.send();
        }
    }
    saveTurn();

}
//updates turn in database
function saveTurn(){
    var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    
                    console.log(this.responseText);
                }
            };
            xmlhttp.open("POST", "saveTurn.php?b=" + turn, true);
            xmlhttp.send();
}

//this add a game piece to a column and does some other stuff
function selectColumn(col) {
    
    if(!win && loadedIn){
        if (moved){
            //if the player already made a move we undo the last move and let them pick a new one
            undoMove();
            moved = false;
        }
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
            nextTurn(1); 
        }
        //checks if player1/yellow won
        if(determineWin(board) == 1){
            document.getElementById("colorTurn").innerHTML="Yellow (YOU) Win!";
            win = true;
            winHandler("1");//updates the database on the win
        //checks if player2/red won   
        }if(determineWin(board) == 2){
            document.getElementById("colorTurn").innerHTML="Red Wins!";
            win = true;
            winHandler("2");
        }
        
        moved = true;
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

//sets the turn and updates the display accordingly
function nextTurn(pturn) {
   turn = pturn;
   document.getElementById("colorTurn").innerHTML= turn==1? p1Color+" Turn (YOU)":p2Color+" Turn";
}

//adds a move into the move history 
function pushToMoveHistory(row,col){
   prevMove[0]=row;
   prevMove[1]=col;
}

//undo button
function undoMove() {
   
    if(!win && prevMove[0] != -1){//undo only works when nobody has won and previous move is not empty (-1 means its empty)
      
      board[prevMove[0]][prevMove[1]] = 0; //removes that piece from the board
      prevMove = [-1,-1];//resets previous move
      nextTurn(turn == 1? 2:1);
      updateBoard();//updates the display
   }
   
}

//this function saves the board and updates tethys to allow the next person to play
function confirmMove() {
    saveBoard();
    window.location.href = "settings.php";
}
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


</script>
</head>
<body>


<button onclick="fixBoard()">Load in the Game</button>
</body>
</html>
