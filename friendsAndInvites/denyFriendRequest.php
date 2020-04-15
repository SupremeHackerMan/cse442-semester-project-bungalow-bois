<?php
    session_start();

    $friendo = $_POST['user_name'];
    $currentUserName = $_SESSION["username"];


    $HOST = 'tethys.cse.buffalo.edu';
    $USERNAME = 'jling2';
    $USERPASSWORD = "50244515";
    $DBNAME = "cse442_542_2020_spring_teaml_db";

    $conn = new mysqli($HOST, $USERNAME, $USERPASSWORD, $DBNAME);

    //friend entry may be stored as [bob , jon] or [jon, bob]
    //checks if the friend request is in the database
    $result = $conn->query("SELECT * FROM `FriendRequests` WHERE (`requester` = '$friendo' AND  `requestee` = '$currentUserName' )");

    //checks if that user even exists
    $searchResults = $conn->query("SELECT * FROM `users` WHERE `username` = '$friendo' ");                                  

    
    if ($result->num_rows != 0 && $searchResults->num_rows != 0) {
        $conn->query("DELETE FROM `FriendRequests` WHERE (`requester` = '$friendo' AND  `requestee` = '$currentUserName' )");                              
    }

    
   
    $conn->close();
    //return back to welcome.php 
    header("location: ../welcome.php");
?>