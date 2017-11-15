<?php
//logout.php
require_once 'Includes/global.inc.php';
session_regenerate_id();
$userTools = new UserTools();
$userTools->logout();
header("Location: login.php");
?>