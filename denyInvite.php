<?php
    ini_set('display_errors', 1); 
    error_reporting(E_ALL);
    include 'config.php';
    session_start();

    //varable should match in the corresponding form where       name =
    $f= $_REQUEST["f"];
    $friendId = (int)($f);
    $currentUserName = $_SESSION["username"];

    //gets the friends name using the id
    $friendo = "oh no";
    $friendInfoQ = $link->query("SELECT `player` FROM `Status` WHERE `id` = '$friendId'");
    if ($friendInfoQ->num_rows == 1) {
        while($row = $friendInfoQ->fetch_assoc()) {
            $friendo = $row["player"];
        }
    }

    //friend entry may be stored as [bob , jon] or [jon, bob]
    //checks if the invitation is in the database
    $result = $link->query("SELECT * FROM `GameInvites` WHERE (`inviter` = '$friendo' AND  `invitee` = '$currentUserName' )");

    //checks if that user even exists
    $searchResults = $link->query("SELECT * FROM `users` WHERE `username` = '$friendo' ");                                  

    
    if ($result->num_rows != 0 && $searchResults->num_rows != 0) {
        $link->query("DELETE FROM `GameInvites` WHERE (`inviter` = '$friendo' AND  `invitee` = '$currentUserName' )");                              
    }

    

?>