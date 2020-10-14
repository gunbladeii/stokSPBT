<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname = "localhost";
$database = "iconvess_projekSPBT";
$username = "iconvess_iconvess";
$password = "Sh@ti5620";
$mySPBT2.0 = mysql_pconnect($hostname, $username, $password) or trigger_error(mysql_error(),E_USER_ERROR); 
?>