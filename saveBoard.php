<?php
//only uncommment TEST ECHOS ONE AT A TIME
ini_set('display_errors', 1); 
error_reporting(E_ALL);
include 'config.php';
session_start();
$currentUserName = "raygay";
//$currentUserName = $_SESSION["username"];

// get the board data from the parameter from URL called by saveBoard()
$board = $_REQUEST["b"];
$rowNum = substr($board,0,1);//first char is the row number
$rowData = substr($board,1,7);//the rest is the data
//echo $rowData;//for testing: sends it back so it can be printed to console


$result = $link->query("SELECT * FROM `SavedOfflineGames` WHERE `username` = '$currentUserName' ");//checks if players saved game is there or not
//echo $result->num_rows;//for testing 

if ($result->num_rows == 1) {//if not there create a new entry

    if($rowNum === "0"){
        $link->query("UPDATE `SavedOfflineGames` SET row0 = '$rowData' WHERE username = '$currentUserName'"); 
    }if($rowNum === "1"){
        $link->query("UPDATE `SavedOfflineGames` SET row1 = '$rowData' WHERE username = '$currentUserName'"); 
    }if($rowNum === "2"){
        $link->query("UPDATE `SavedOfflineGames` SET row2 = '$rowData' WHERE username = '$currentUserName'"); 
    }if($rowNum === "3"){
        $link->query("UPDATE `SavedOfflineGames` SET row3 = '$rowData' WHERE username = '$currentUserName'"); 
    }if($rowNum === "4"){
        $link->query("UPDATE `SavedOfflineGames` SET row4 = '$rowData' WHERE username = '$currentUserName'"); 
    }if($rowNum == 5){
        $link->query("UPDATE `SavedOfflineGames` SET row5 = '$rowData' WHERE username = '$currentUserName'"); 
        echo $rowNum;
    } 
    
}
?>