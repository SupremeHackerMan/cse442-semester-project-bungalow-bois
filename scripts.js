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