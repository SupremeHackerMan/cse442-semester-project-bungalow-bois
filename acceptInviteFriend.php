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

    //checks if a player is already in a game                                   
    $inGame = $conn->query("SELECT * FROM `OnlinePlay` WHERE (`Player1` = '$currentUserName' OR  `Player2` = '$currentUserName' )");

    //checks if player2 exists
    $opponenetExists = $conn->query("SELECT * FROM `users` WHERE `username` = '$friendo' ");
    
    //if not in game and player exists create a new game
    if ($inGame->num_rows == 0 && $opponenetExists->num_rows != 0) {
        $sqlQuery2 = "INSERT INTO `OnlinePlay` (`Player1`,  `Player2`, `Turn`, `row0`, `row1`, `row2`, `row3`, `row4`, `row5`) 
                                        VALUES ('$currentUserName', '$friendo', '1', '0000000', '0000000', '0000000', '0000000', '0000000', '0000000') ";    
                               
        $conn->query($sqlQuery2);                                   
    }
    
    
    
        

    $conn->close();
 
    //return back to welcome.php 
    header("location: friends.php");
?>