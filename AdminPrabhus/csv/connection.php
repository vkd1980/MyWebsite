<?php
function getdb(){
$servername = "localhost:3308";
$username = "root";
$password = "";
$db = "test";

try {

    $conn = mysqli_connect($servername, $username, $password, $db);
     //echo "Connected successfully";
    }
catch(exception $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
    return $conn;
}
?>
