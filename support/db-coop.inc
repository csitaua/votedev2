<?php

$host="localhost"; // Host name
$db_username="root"; // Mysql username
$db_password=""; // Mysql password
$db_name="vote_2021"; // Database name

$my = new mysqli($host,$db_username,$db_password,$db_name);

$voting_year=2021;
$voteend = mktime(15,0,0,8,27,2021);

?>
