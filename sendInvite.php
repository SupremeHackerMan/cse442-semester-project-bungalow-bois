<?php
    ini_set('display_errors', 1); 
    error_reporting(E_ALL);
    include 'config.php';
    session_start();

    //varable should match in the corresponding form where       name =
    $f= $_REQUEST["f"];
    $friendId = (int)($f);
    $currentUserName = $_SESSION["username"];

    //gets the friends name using the id
    $friendo = "oh no";
    $friendInfoQ = $link->query("SELECT `player` FROM `Status` WHERE `id` = '$friendId'");
    if ($friendInfoQ->num_rows == 1) {
        while($row = $friendInfoQ->fetch_assoc()) {
            $friendo = $row["player"];
        }
    }

    //checks if an invitation was already sent either by you or (the other person to you)                                 
    $sent = $link->query("SELECT * FROM `GameInvites` WHERE (`inviter` = '$currentUserName' AND  `invitee` = '$friendo' )  
                                                         OR (`inviter` = '$friendo' AND  `invitee` = '$currentUserName' ) ");   
    $alreadySent =($sent->num_rows == 0);
    
    if ($alreadySent) {
        $link->query("INSERT INTO `GameInvites` (`inviter`,  `invitee`) VALUES ('$currentUserName', '$friendo') ");                               
    }
    
    
    echo "sent Invitation to: " . $friendo;
    
?>