<?php
require_once (__DIR__.'/Includes/global.inc.php');
include(__DIR__.'/Includes/header.php');
echo 'Welcome '.$_SESSION['username'].' You Have successfully Logged In at '.$_SESSION["login_time"];
include(__DIR__.'/Includes/footer.php');
?>