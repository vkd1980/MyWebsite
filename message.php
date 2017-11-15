<?php
//Maha ganapathaye Namah!
//Bookstore FrontEnd V 1.0
//© I biz Info Solutions
require_once (__DIR__.'/includes/classes/global.inc.php');
include(__DIR__.'/includes/header.php');
/*    foreach ($_REQUEST as $key => $value) {
       
        echo $key.'=>';
        
        echo $value.'<br>';
        
    }*/


if(!empty($_REQUEST['service']) && !empty($_REQUEST['status']) && !empty($_REQUEST['message']) ){
$srv = filter_var($_REQUEST['service'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
switch($srv){
case "NewsLetter":
if ($_REQUEST['status']=="success")
{
echo'<div class="clearfix"></div>
	  <div class="clearfix"></div>
	  <br><br>
	<div class="container">
    <div class="row">
      
	  <div class ="alert alert-success" align="center"><h4>'.preg_replace('#[ -]+#', ' ', $_REQUEST['message']).'</h4></div>
	 
	  </div>
	  </div>';
}
elseif ($_REQUEST['status']=="error")
{
echo'<div class="clearfix"></div>
	  <div class="clearfix"></div>
	   <br><br>
	<div class="container">
    <div class="row">
      
	  <div class ="alert alert-danger" align="center"><h4>'.preg_replace('#[ -]+#', ' ', $_REQUEST['message']).'</h4></div>
	  
	  </div>
	  </div>';
}
elseif ($_REQUEST['status']=="info")
{
echo'<div class="clearfix"></div>
	  <div class="clearfix"></div>
	   <br><br>
	<div class="container">
    <div class="row">
      
	  <div class ="alert alert-warning" align="center"><h4>'.preg_replace('#[ -]+#', ' ', $_REQUEST['message']).'</h4></div>
	  
	  </div>
	  </div>';
}
break;

case "Signup":
if ($_REQUEST['status']=="success")
{
echo'<div class="clearfix"></div>
	  <div class="clearfix"></div>
	  <br><br>
	<div class="container">
    <div class="row">
      
	  <div class ="alert alert-success" align="center"><h4>'.preg_replace('#[ -]+#', ' ', $_REQUEST['message']).'<br><a href="../login.html">Login </a>to Continue<br></h4></div>
	 
	  </div>
	  </div>';
}
elseif ($_REQUEST['status']=="error")
{
echo'<div class="clearfix"></div>
	  <div class="clearfix"></div>
	   <br><br>
	<div class="container">
    <div class="row">
      
	  <div class ="alert alert-danger" align="center"><h4>Sign Up Error <br>'.preg_replace('#[ -]+#', ' ', $_REQUEST['message']).'<br><a href="../test.html">Sign Up Again!</a><br></h4></div>
	  
	  </div>
	  </div>';
}
elseif ($_REQUEST['status']=="info")
{
echo'<div class="clearfix"></div>
	  <div class="clearfix"></div>
	   <br><br>
	<div class="container">
    <div class="row">
      
	  <div class ="alert alert-warning" align="center"><h4>Sign Up Error <br>'.preg_replace('#[ -]+#', ' ', $_REQUEST['message']).'<br><a href="../test.html">Sign Up Again!</a><br></h4></div>
	  
	  </div>
	  </div>';
}
break;
case "Order":
/******************/
if ($_REQUEST['status']=="success")
{
echo'<div class="clearfix"></div>
	  <div class="clearfix"></div>
	  <br><br>
	<div class="container">
    <div class="row">
      
	  <div class ="alert alert-success" align="center"><h4>'.preg_replace('#[ -]+#', ' ', $_REQUEST['message']).'<br><a href="../login.html">Login </a>to Continue<br></h4></div>
	 
	  </div>
	  </div>';
}
elseif ($_REQUEST['status']=="error")
{
echo'<div class="clearfix"></div>
	  <div class="clearfix"></div>
	   <br><br>
	<div class="container">
    <div class="row">
      
	  <div class ="alert alert-danger" align="center"><h4>Sign Up Error <br>'.preg_replace('#[ -]+#', ' ', $_REQUEST['message']).'<br><a href="../test.html">Sign Up Again!</a><br></h4></div>
	  
	  </div>
	  </div>';
}
elseif ($_REQUEST['status']=="info")
{
echo'<div class="clearfix"></div>
	  <div class="clearfix"></div>
	   <br><br>
	<div class="container">
    <div class="row">
      
	  <div class ="alert alert-warning" align="center"><h4>Sign Up Error <br>'.preg_replace('#[ -]+#', ' ', $_REQUEST['message']).'<br><a href="../test.html">Sign Up Again!</a><br></h4></div>
	  
	  </div>
	  </div>';
}
/**************/
break;

}

}
	  			 
 include(__DIR__.'/includes/footer.php');
?>
	