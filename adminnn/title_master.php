<?php
include'includes/header.php';
$now=time();
if(!isset($_SESSION['logged_in'])) {
header("Location: index.php");
	}
?>
<?php
include 'includes/footer.php';
?>
