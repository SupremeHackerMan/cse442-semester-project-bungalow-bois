<?php
    session_start();

    //varable should match in the corresponding form where       name =
    $friendo = $_POST['user_name'];
    $currentUserName = $_SESSION["username"];


    $HOST = 'tethys.cse.buffalo.edu';
    $USERNAME = 'jling2';
    $USERPASSWORD = "50244515";
    $DBNAME = "cse442_542_2020_spring_teaml_db";

    $conn = new mysqli($HOST, $USERNAME, $USERPASSWORD, $DBNAME);

    /*
        Rules
        -wont send a request if request already sent
        -wont send a request if requestee sent you a request
        -wont send a request if you sent a request to your self 
        -wont send a request if you guys are already friends
    */

    //checks if a request was already sent either by you or (the other person to you)                                    
    $alreadySent1 = $conn->query("SELECT * FROM `FriendRequests` WHERE (`requester` = '$currentUserName' AND  `requestee` = '$friendo' )");
    $alreadySent2 = $conn->query("SELECT * FROM `FriendRequests` WHERE (`requester` = '$friendo' AND  `requestee` = '$currentUserName' )");
    $alreadySent =($alreadySent1->num_rows + $alreadySent2->num_rows ) == 0;

    //checks if that user even exists
    $doesExist = $conn->query("SELECT * FROM `users` WHERE `username` = '$friendo' ");

    //checks if already friends
    $alreadyFriends1 = $conn->query("SELECT * FROM `Friends` WHERE (`friend1Username` = '$currentUserName' AND  `Friend2Username` = '$friendo' )");
    $alreadyFriends2 = $conn->query("SELECT * FROM `Friends` WHERE (`friend1Username` = '$friendo' AND  `Friend2Username` = '$currentUserName' )");
    $alreadyFriends =($alreadyFriends1->num_rows + $alreadyFriends2->num_rows ) == 0;
    
    
    if ($alreadySent &&  $doesExist->num_rows != 0 && $friendo != $currentUserName && $alreadyFriends) {
        $sqlQuery2 = "INSERT INTO `FriendRequests` (`requester`,  `requestee`) 
                                        VALUES ('$currentUserName', '$friendo') ";    
        $conn->query($sqlQuery2);                               
    }
    
    $conn->close();
 
    //return back to welcome.php 
    header("location: ../welcome.php");
?>