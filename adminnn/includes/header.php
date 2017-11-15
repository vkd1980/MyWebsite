<?php
require_once (__DIR__.'/global.inc.php');
if(isset($_SESSION['logged_in'])) {
	$token = $_SESSION['token'];
	}
	else
	{
	header("Location: login.php");
	
	}
$lnk="";?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' dir='ltr' lang='en'>
<head>
<title>..::: Prabhus Books Online :::.. Books, Buy Books,Book Shop,Bookstore,Online Bookstore, Online Shopping,India </title>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<meta name='keywords' content='Online Bookstore, Online Shopping, online shopping ' />
<meta name='description' content='..::: Prabhus Books Online :::..' />
<meta http-equiv='imagetoolbar' content='no' />
<meta name='author' content='IBiz Info Solutions&reg; Team and others' />
<meta name='viewport' content='width=device-width, initial-scale=1.0'/><?php
$css = '';
$handle = '';
$file = '';
// open the "css" directory
if ($handle = opendir('includes/css')) {
    // list directory contents
    while (false !== ($file = readdir($handle))) {
        // only grab file names
        if (is_file('includes/css/' . $file)) {
            // insert HTML code for loading Javascript files
            $css .= '<link rel="stylesheet" href="includes/css/' . $file .
                '" type="text/css" media="all" />' . "\n";
        }
    }
    closedir($handle);
    echo $css;}
	$js = '';
$handle = '';
$file = '';
// open the "js" directory
if ($handle = opendir('includes/js')) {
    // list directory contents
    while (false !== ($file = readdir($handle))) {
        // only grab file names
        if (is_file('includes/js/' . $file)) {
            // insert HTML code for loading Javascript files
            $js .= '<script src="includes/js/' . $file . '" type="text/javascript"></script>' . "\n";
        }
    }
    closedir($handle);
    echo $js;
}

?><script type="text/javascript">
$().ready( function() {
$(window).scroll(function() {
        if ($(this).scrollTop() > 220) {
            $('.back-to-top').fadeIn(500);
        } else {
            $('.back-to-top').fadeOut(500);
        }
    });
    
    $('.back-to-top').click(function(event) {
        event.preventDefault();
        jQuery('html, body').animate({scrollTop: 0}, 500);
        return false;
    })
});
</script>


<style>
.panel-default {
 opacity: 0.9;
 margin-top:30px;
}
.form-group.last {
 margin-bottom:0px;
}
</style>

</head>
<div class="container">
    <div class="row">
	<div class="col-md-4"><a href="#"><img src="includes/images/logo.png" alt="Shop @ Prabhus Books Online" title=" Shop @ Prabhus Books Online " width="400" height="100"  class="img-responsive"/></a>    </div>
        <div class="col-md-8 pull-right">
<?php		if(isset($_SESSION['logged_in'])) {
$lnk="<li class=' btn-info'><a href='#'>Session ID: ".session_id()  ."</a></li><li class='btn-warning'><a href='#'>Finyear ID: ".$_SESSION['FinYearID']."</a></li><li class='btn-info'><a href='#'> Token: ".$_SESSION['token'] ."</a></li>	";

}echo $lnk;?>
		</div>
    </div>
	</div><!--<div class="container">-->.
	<br class="clearBoth" />
	 <div class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            </div>
          <div class="navbar-collapse collapse">
          
            <!-- Left nav -->
            <ul class="nav navbar-nav">
              <li><a href="index.php">Home</a></li>
			   <li><a href="#">Master</a>
				 <ul class="dropdown-menu">
                  <li><a href="subject_master.php">Subject Master</a></li>
			<li><a href="publisher_master.php">Publisher Master</a></li>
			<li><a href="currency_master.php">Currency Master</a></li>
			<li><a href="title_master.php">Title Master</a></li>
			<li><a href="emp_master.php">Employee Master</a></li>
                  <li class="divider"></li>
                  <li class="dropdown-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a>
                    <ul class="dropdown-menu">
                      <li><a href="#">Action</a></li>
                      <li><a href="#">Another action</a></li>
                      <li><a href="#">A long sub menu</a>
                        <ul class="dropdown-menu">
                          <li><a href="#">Action</a></li>
                          <li><a href="#">Something else here</a></li>
                          <li class="disabled"><a class="disabled" href="#">Disabled item</a></li>
                          <li><a href="#">One more link</a></li>
                          <li><a href="#">Menu item 1</a></li>
                          <li><a href="#">Menu item 2</a></li>
                          <li><a href="#">Menu item 3</a></li>
                        </ul>
                      </li>
                      <li><a href="#">Another link</a></li>
                      <li><a href="#">One more link</a></li>
                    </ul>
                  </li>
                </ul>
              </li>
            			</ul>
          
            <!-- Right nav -->
            <ul class="nav navbar-nav navbar-right">
                      <li><a href="logout.php">Logout</a></li>     
              <!--<li><a href="#">Dropdown</a>
                <ul class="dropdown-menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li class="dropdown-header">Nav header</li>
                  <li><a href="#">A sub menu</a>
                    <ul class="dropdown-menu">
                      <li><a href="#">Action</a></li>
                      <li><a href="#">Another action</a></li>
                      <li><a href="#">Something else here</a></li>
                      <li class="disabled"><a class="disabled" href="#">Disabled item</a></li>
                      <li><a href="#">One more link</a></li>
                    </ul>
                  </li>
                  <li><a href="#">A separated link</a></li>
                </ul>
              </li>-->
            </ul>
          
          </div><!--/.nav-collapse -->
        </div><!--/.container -->
      </div>