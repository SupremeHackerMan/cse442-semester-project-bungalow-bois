<?php
    ini_set('display_errors', 1); 
    error_reporting(E_ALL);
    include 'config.php';
    session_start();

    //varable should match in the corresponding form where       name =
    $f= $_REQUEST["f"];
    $friendId = (int)($f);
    $currentUserName = $_SESSION["username"];

    
?>