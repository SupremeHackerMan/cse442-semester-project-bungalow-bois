<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'tethys.cse.buffalo.edu');
define('DB_USERNAME', 'jshess');
define('DB_PASSWORD', '50185428');
define('DB_NAME', 'cse442_542_2020_spring_teaml_db');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

?>