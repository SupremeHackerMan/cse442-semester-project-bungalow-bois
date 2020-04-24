//if getting a cannot set innerhtml of null error then ur tag id is prolly spelled wrong


//grabs the players wins and losses
function getPlayerInfo() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
       if (this.readyState == 4 && this.status == 200) {
          document.getElementById("pInfo").innerHTML = this.responseText;
          console.log(this.responseText);
          
       }
    };
    xmlhttp.open("GET", "getPlayerInfo.php", true);
    xmlhttp.send();
 
}
function getRankings() {
   var xmlhttp = new XMLHttpRequest();
   xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
         var rankArr = JSON.parse(this.responseText);
         console.log(this.responseText);
         console.log(rankArr[0]);
         var idnum =1;
         for(var i = 0; i < rankArr.length-3; i+=4){
            document.getElementById("pl"+idnum).innerHTML = rankArr[i];
            document.getElementById("win"+idnum).innerHTML = rankArr[i+1];
            document.getElementById("lose"+idnum).innerHTML = rankArr[i+2];
            document.getElementById("ratio"+idnum).innerHTML = rankArr[i+3];
            idnum++;
         }
      }
   };
   xmlhttp.open("GET", "getRankings.php", true);
   xmlhttp.send();

}

//loads the board from the table on tethys. Its stored there as 6 strings, each one corresponds to a row
function loadBoard(board, chainSize) {
   
   //localStorage.setItem('init',JSON.stringify("done"));//initializes it only once
   //if(JSON.parse(localStorage.getItem('init')))

   board = JSON.parse(localStorage.getItem('boardo'+chainSize));
   turn = parseInt(JSON.parse(localStorage.getItem('turno'+chainSize)));
   if(turn == 1){
      document.getElementById("colorTurn").innerHTML="Yellow Turn (YOU)";
   }else{
      document.getElementById("colorTurn").innerHTML="Red Turn";
   }
   
   console.log("loaded turn: "+turn);
   console.log(board);
   updateBoard();
}

function saveBoard(board, chainSize){
   localStorage.setItem('boardo'+chainSize,JSON.stringify(board));
   localStorage.setItem('turno'+chainSize,JSON.stringify(turn));

   console.log("saved turn: "+JSON.stringify(turn));
   console.log(JSON.stringify(board));
}