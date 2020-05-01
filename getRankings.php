<?php
#example: this should echo something like this: [Logged in as: raygay]   Wins: 292 | Losses: 15
ini_set('display_errors', 1); 
error_reporting(E_ALL);
include 'config.php';
session_start();
$currentUserName = $_SESSION["username"];
$result = $link->query("SELECT username, wins, losses FROM users ORDER BY wins DESC");
$all = "[ ";
if ($result->num_rows > 0) {
    // output data of each row
    $counter = 1;
    while (($row = $result->fetch_assoc()) AND ($counter < 11)) {
        if($row["losses"] != 0){
            $ratio = $row["wins"]/$row["losses"];
        }else {
            $ratio = 0;
        }
        $all .=  "\"" . $row["username"]. "\", \"". $row["wins"].  "\", \"". $row["losses"] . "\", \"". $ratio. "\"" ;
        if($counter != 10){
            $all .=  ", ";
        }else{
            $all .= " ]";
        }
        $counter++;
    } 
    
}
echo $all;
?>