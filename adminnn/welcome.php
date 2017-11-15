<?php
include'includes/header.php';
$now=time();
if(!isset($_SESSION['logged_in'])) {
header("Location: index.php");
	}
?>
<div class="container">
  
</div>
<?php include'includes/footer.php';
 ?>