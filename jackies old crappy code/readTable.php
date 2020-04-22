<?php

   //$_SESSION["username"];
   

    
//stores the saved board state from table to cookies
function tableToCookie($username){
    session_start();
    include 'config.php';
    $currentUserName = $_SESSION["username"];
    $result = $link->query("SELECT * FROM `SavedOfflineGames` WHERE `username` = '$currentUserName' ");//checks if players saved game is there or not

    if ($result->num_rows == 1) {  
        while ($row = $result->fetch_assoc()) {
            //            cookie name          cookie value value   expiration time
            setcookie("row0", $row["row0"], time() + 10, "/"); // time() + 10 = 10 secs
            setcookie("row1", $row["row1"], time() + 10, "/");
            setcookie("row2", $row["row2"], time() + 10, "/");
            setcookie("row3", $row["row3"], time() + 10, "/");
            setcookie("row4", $row["row4"], time() + 10, "/");
            setcookie("row5", $row["row5"], time() + 10, "/");
        }  
    }
    
}


    
?>