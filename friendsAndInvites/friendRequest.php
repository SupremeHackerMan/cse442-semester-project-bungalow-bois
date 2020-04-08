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

    //checks if a request was already sent                                    
    $result = $conn->query("SELECT * FROM `FriendRequests` WHERE (`requester` = '$currentUserName' AND  `requestee` = '$friendo' )");

    //checks if that user even exists
    $result2 = $conn->query("SELECT * FROM `users` WHERE `username` = '$friendo' ");
    
    //if no entry found then insert
    if ($result->num_rows == 0 && $result2->num_rows != 0) {
        $sqlQuery2 = "INSERT INTO `FriendRequests` (`requester`,  `requestee`) 
                                        VALUES ('$currentUserName', '$friendo') ";    
        $conn->query($sqlQuery2);                               
    }
    
    $conn->close();
 
    //return back to welcome.php 
    header("location: ../welcome.php");
?>