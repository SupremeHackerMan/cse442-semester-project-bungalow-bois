<?php
    session_start();

    $friendo = $_POST['friend_user_name'];
    $currentUserName = $_SESSION["username"];


    $HOST = 'tethys.cse.buffalo.edu';
    $USERNAME = 'jling2';
    $USERPASSWORD = "50244515";
    $DBNAME = "cse442_542_2020_spring_teaml_db";

    $conn = new mysqli($HOST, $USERNAME, $USERPASSWORD, $DBNAME);

    //friend entry may be stored as [bob , jon] or [jon, bob]
    $sqlQuery = "SELECT * FROM `Friends` WHERE (`friend1Username` = '$currentUserName' AND  `friend2Username` = '$friendo' ) 
                                        OR (`friend2Username` = '$currentUserName' AND  `friend1Username` = '$friendo' ) ";
    $result = $conn->query($sqlQuery);

    $searchIfFriendReal = "SELECT * FROM `users` WHERE `username` = '$friendo' ";
    $searchResults = $conn->query($searchIfFriendReal);                                  

    //if no entry found then insert
    if ($result->num_rows == 0 && $searchResults->num_rows > 0) {
        $sqlQuery2 = "INSERT INTO `Friends` (`friend1Username`,  `friend2Username`) 
                                        VALUES ('$currentUserName', '$friendo') ";    
        $conn->query($sqlQuery2);                               
    }
    $conn->close();
    //return back to welcome.php 
    header("location: ../welcome.php");
?>