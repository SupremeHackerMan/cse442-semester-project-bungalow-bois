<html>
<?php
    include 'config.php';
    ini_set('display_errors', 1); 
    error_reporting(E_ALL);
    $currentUserName = "raygay";
    $check = $link->query("SELECT * FROM `SavedOfflineGames` WHERE `username` = '$currentUserName' ");//checks if players saved game is there or not

    if ($check->num_rows == 0) {//if not there create a new entry
        $sql = "INSERT INTO `SavedOfflineGames` (username, row0, row1, row2, row3, row4, row5) 
                                    VALUES ('$currentUserName', '0000000', '0000000','0000000','0000000','0000000','0000000')";
        $link->query($sql);   
    }else{//if its there it will update the existing one
        $sql = "UPDATE `SavedOfflineGames` SET row0 = '0000000', row1 = '0000000', row2 = '0000000', row3 = '00000003', row4 = '0000000', row5 = '0000000' 
                                            WHERE username = '$currentUserName'" ;                          
        $link->query($sql);   
    }
      
   ?>
<head>
<script type="text/javascript" src="scripts.js"></script>

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