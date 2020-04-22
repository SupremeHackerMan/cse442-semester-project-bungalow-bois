<html>
<head>
<script>
const COLS = 7;
const ROWS = 6;
board = [];
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
   <?php
   ini_set('display_errors', 1); 
   error_reporting(E_ALL);
   $currentUserName = "raygay";
      $check = $link->query("SELECT * FROM `SavedOfflineGames` WHERE `username` = '$currentUserName' ");//checks if players saved game is there or not

      if ($check->num_rows == 0) {//if not there create a new entry
        $sql = "INSERT INTO `SavedOfflineGames` (username, row0, row1, row2, row3, row4, row5) 
                                   VALUES ('$currentUserName', '0000000', '0000000','0000000','0000000','0000000','0000000')";
        $link->query($check);   
     }else{//if its there it will update the existing one
        $sql = "UPDATE `SavedOfflineGames` SET row0 = '0000000', row1 = '0000000', row2 = '0000000', row3 = '00000003', row4 = '0000000', row5 = '0000000' 
                                         WHERE username = '$currentUserName'" ;                          
        $link->query($check);   
     }
      
   ?>
}
newBoard(board);

board[5][2]=2;
board[5][1]=2;


function loadBoard() {
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
                    console.log(board[i][j]);
                    idx++;
                    
                }
            }
        }
    };
    xmlhttp.open("GET", "loadBoard.php", true);
    xmlhttp.send();

}

//saves a row into database
function saveBoard(row){
    if(row <= ROWS){
        var combine = board[row].join('');
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                
                console.log(this.responseText);
            }
        };
        xmlhttp.open("GET", "saveBoard.php?b=" + row + combine, true);
        xmlhttp.send();
    }

}

</script>
</head>
<body>

<p><b>Start typing a name in the input field below: open console to check output</b></p>
<form>

</form>
<p>Suggestions: <span id="txtHint"></span></p>
<button onclick="loadBoard()">load board</button>
<button onclick="saveBoard(5)">save board</button>
</body>
</html>