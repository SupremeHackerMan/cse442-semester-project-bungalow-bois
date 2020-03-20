<?php
    $HOST = 'tethys.cse.buffalo.edu';
    $USERNAME = 'jling2';
    $USERPASSWORD = "50244515";
    $DBNAME = "cse442_542_2020_spring_teaml_db";

    $conn = new mysqli($HOST, $USERNAME, $USERPASSWORD, $DBNAME);
    if(!$conn){
        echo ("Fail to conncet server".mysqli_connect_error());
    }else{
        echo 'Please ignore this text, just means logging into the tethys database actually worked:)';
    }
?>