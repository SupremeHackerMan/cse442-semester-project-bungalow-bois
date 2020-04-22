<?php

   //$_SESSION["username"];


    

    function incrWin($username)
    {
        session_start();
        $HOST = 'tethys.cse.buffalo.edu';
        $USERNAME = 'jling2';
        $USERPASSWORD = "50244515";
        $DBNAME = "cse442_542_2020_spring_teaml_db";
        $yeah= new mysqli($HOST, $USERNAME, $USERPASSWORD, $DBNAME);
        $yeah->query("UPDATE users SET wins = wins + 1 WHERE  username = '$username' ");
        $yeah->close();
    }
    function incrLoss($username)
    {
        session_start();
        $HOST = 'tethys.cse.buffalo.edu';
        $USERNAME = 'jling2';
        $USERPASSWORD = "50244515";
        $DBNAME = "cse442_542_2020_spring_teaml_db";
        $yeah= new mysqli($HOST, $USERNAME, $USERPASSWORD, $DBNAME);
        $yeah->query("UPDATE users SET losses = losses + 1 WHERE  username = '$username' ");
        $yeah->close();
    }

    
?>