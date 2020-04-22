
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
        xmlhttp.open("POST", "saveBoard.php?b=" + row + combine, true);
        xmlhttp.send();
    }

}

