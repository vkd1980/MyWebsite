<?php
$host 		= "localhost"; // Your hostname
$username	= "root"; // Your host username
$password	= ""; // Your host password
$db			= "bookstore"; // Your database name
mysql_connect($host, $username, $password) or die("Oops! Coudn't connect to server"); // Connect to the server
mysql_select_db($db) or die("Oops! Coudn't select Database"); // Select the database
?>