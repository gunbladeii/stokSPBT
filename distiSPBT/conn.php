<?php
$username = "iconvess_iconvess";
$password = "Sh@ti5620";
$hostname = "localhost";
$db_name = "iconvess_projekSPBT";

//connection to the database
$mysqli = new mysqli($hostname, $username, $password, $db_name);
/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
?>
