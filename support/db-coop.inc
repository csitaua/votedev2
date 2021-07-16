<?php
date_default_timezone_set("America/Aruba");
$host="localhost"; // Host name
$db_username="root"; // Mysql username
$db_password=""; // Mysql password
$db_name="vote_2021"; // Database name

$my = new mysqli($host,$db_username,$db_password,$db_name);

$voting_year=2021;
$voteend = gmmktime(19,0,0,8,27,2021);

?>
