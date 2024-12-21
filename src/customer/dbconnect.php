<?php

$server = "localhost";
$port = 3306;
$user = "root";
$password = "";
$dbname = "onlineticketsbooking";

$conn = new PDO("mysql:host=$server;port=$port;dbname=$dbname",$user,$password);
//echo"connection got";

?>