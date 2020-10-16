<?php
//source: https://www.w3schools.com/php/php_mysql_connect.asp
$servername = "localhost";
$username = "myhealth2";
$password = "CIOjh^J8h^?b";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if (mysqli_connect_error()) {
  die("Database connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
?>