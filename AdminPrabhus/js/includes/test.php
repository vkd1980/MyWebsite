<?php 

require_once (__DIR__.'/classes/global.inc.php');
echo $review->savereveiw(1,2,"Vinod",5,date('Y/m/d H:i:s'),date('Y/m/d H:i:s'),1,"Test review test");
?>
<html>
<div id="display_error_review" style="display:none" ><strong></strong></div> 
</html>