<?php
//only uncommment TEST ECHOS ONE AT A TIME
ini_set('display_errors', 1); 
error_reporting(E_ALL);
include 'config.php';
session_start();

$currentUserName = $_SESSION["username"];

// get the board data from the parameter from URL called by saveBoard()
$board = $_REQUEST["b"];
$rowNum = substr($board,0,1);//first char is the row number
$rowData = substr($board,1,7);//the rest is the data
echo $rowData;//for testing: sends it back so it can be printed to console

$result = $link->query("SELECT * FROM `OnlinePlay` WHERE (`Player1` = '$currentUserName' OR  `Player2` = '$currentUserName' ) ");//checks if players saved game is there or not
//echo $result->num_rows;//for testing 

if ($result->num_rows == 1) {//if not there create a new entry

    if($rowNum === "0"){
        $link->query("UPDATE `OnlinePlay` SET row0 = '$rowData' WHERE (`Player1` = '$currentUserName' OR  `Player2` = '$currentUserName' )"); 
        echo "saved to Table at row ". $rowNum;
    }if($rowNum === "1"){
        $link->query("UPDATE `OnlinePlay` SET row1 = '$rowData' WHERE (`Player1` = '$currentUserName' OR  `Player2` = '$currentUserName' )"); 
        echo "saved to Table at row ". $rowNum;
    }if($rowNum === "2"){
        $link->query("UPDATE `OnlinePlay` SET row2 = '$rowData' WHERE (`Player1` = '$currentUserName' OR  `Player2` = '$currentUserName' )"); 
        echo "saved to Table at row ". $rowNum;
    }if($rowNum === "3"){
        $link->query("UPDATE `OnlinePlay` SET row3 = '$rowData' WHERE (`Player1` = '$currentUserName' OR  `Player2` = '$currentUserName' )"); 
        echo "saved to Table at row ". $rowNum;
    }if($rowNum === "4"){
        $link->query("UPDATE `OnlinePlay` SET row4 = '$rowData' WHERE (`Player1` = '$currentUserName' OR  `Player2` = '$currentUserName' )"); 
        echo "saved to Table at row ". $rowNum;
    }if($rowNum == 5){
        $link->query("UPDATE `OnlinePlay` SET row5 = '$rowData' WHERE (`Player1` = '$currentUserName' OR  `Player2` = '$currentUserName' )"); 
        echo "saved to Table at row ". $rowNum;
    } 
    
}
?>