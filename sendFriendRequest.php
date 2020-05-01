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


    /*
        Rules
        -wont send a request if request already sent
        -wont send a request if requestee sent you a request
        -wont send a request if you sent a request to your self 
        -wont send a request if you guys are already friends
    */

    //checks if a request was already sent either by you or (the other person to you)                                    
    $alreadySent1 = $link->query("SELECT * FROM `FriendRequests` WHERE (`requester` = '$currentUserName' AND  `requestee` = '$friendo' )");
    $alreadySent2 = $link->query("SELECT * FROM `FriendRequests` WHERE (`requester` = '$friendo' AND  `requestee` = '$currentUserName' )");
    $alreadySent =($alreadySent1->num_rows + $alreadySent2->num_rows ) == 0;

    //checks if that user even exists
    $doesExist = $link->query("SELECT * FROM `users` WHERE `username` = '$friendo' ");

    //checks if already friends
    $alreadyFriends1 = $link->query("SELECT * FROM `Friends` WHERE (`friend1Username` = '$currentUserName' AND  `Friend2Username` = '$friendo' )");
    $alreadyFriends2 = $link->query("SELECT * FROM `Friends` WHERE (`friend1Username` = '$friendo' AND  `Friend2Username` = '$currentUserName' )");
    $alreadyFriends =($alreadyFriends1->num_rows + $alreadyFriends2->num_rows ) == 0;
    
    
    if ($alreadySent &&  $doesExist->num_rows != 0 && $friendo != $currentUserName && $alreadyFriends) {
        $sqlQuery2 = "INSERT INTO `FriendRequests` (`requester`,  `requestee`) 
                                        VALUES ('$currentUserName', '$friendo') ";    
        $link->query($sqlQuery2);                               
    }
    
    
    echo "sent request to: " . $friendo;
    
?>