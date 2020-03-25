<?php
    session_start();

    $friendo = $_POST['friend_user_name'];
    $currentUserName = $_SESSION["username"];


    $HOST = 'tethys.cse.buffalo.edu';
    $USERNAME = 'jling2';
    $USERPASSWORD = "50244515";
    $DBNAME = "cse442_542_2020_spring_teaml_db";

    $conn = new mysqli($HOST, $USERNAME, $USERPASSWORD, $DBNAME);


    $sqlQuery = "SELECT * FROM `Friends` WHERE (`friend1Username` = '$currentUserName' AND  `friend2Username` = '$friendo' ) 
                                        OR (`friend2Username` = '$currentUserName' AND  `friend1Username` = '$friendo' ) ";
    $result = $conn->query($sqlQuery);

    
    if ($result->num_rows == 0) {
        $sqlQuery2 = "INSERT INTO `Friends` (`friend1Username`,  `friend2Username`) 
                                        VALUES ('$currentUserName', '$friendo') ";    
        $conn->query($sqlQuery2);                               
    }
    $conn->close();
?>