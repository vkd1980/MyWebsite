<?php
//logout.php
require_once 'includes/global.inc.php';
session_regenerate_id();
$userTools = new UserTools();
$userTools->logout();

header("Location: index.php");

?>