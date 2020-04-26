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

}/*
function winHandler(winningplayer) {
   var xmlhttp = new XMLHttpRequest();
   xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
         
         console.log(this.responseText);
         
      }
   };
   xmlhttp.open("GET", "winHandler.php?d="+winningplayer, true);
   xmlhttp.send();

}*/ 

function winHandler(winningplayer) {
   var xmlhttp = new XMLHttpRequest();
   xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
         console.log("player "+ this.responseText+ "has won");
         
      }
   };
   xmlhttp.open("GET", "winHandler.php?d="+winningplayer, true);
   xmlhttp.send();

}

