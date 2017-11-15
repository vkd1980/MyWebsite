<?php
require_once (__DIR__.'/Includes/global.inc.php');
if(isset($_SESSION['logged_in'])) {
header("Location: index.php");
	}

$error = "";
//check to see if they've submitted the login form
if(isset($_POST['submit-login'])) { 
	$empcode = $_POST['empcode'];
	$password = $_POST['password'];
	$FYid= $_POST['cmbfinyear'];
	$userTools = new UserTools();
	if($userTools->login($empcode, $password,$FYid)){
		//successful login, redirect them to a page
		header("Location:index.php");
	}else{
	
		$error = "<div class='alert alert-danger' role='alert'> <span class='glyphicon glyphicon-warning-sign'>   </span>  Incorrect username or password. Please try again.</div>";
	}
}
$lnk="";?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' dir='ltr' lang='en'>
<head>
<title>..::: Bookstore V 1.0 :::..</title>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<meta name='keywords' content='Bookstore V 1.0' />
<meta name='description' content='..::: Bookstore V 1.0 :::..' />
<meta http-equiv='imagetoolbar' content='no' />
<meta name='author' content='IBiz Info Solutions&reg; Team and others' />
<meta name='viewport' content='width=device-width, initial-scale=1.0'/><?php
$css = '';
$handle = '';
$file = '';
// open the "css" directory
if ($handle = opendir('Includes/css')) {
    // list directory contents
    while (false !== ($file = readdir($handle))) {
        // only grab file names
        if (is_file('Includes/css/' . $file)) {
            // insert HTML code for loading Javascript files
            $css .= '<link rel="stylesheet" href="Includes/css/' . $file .
                '" type="text/css" media="all" />' . "\n";
        }
    }
    closedir($handle);
    echo $css;}
	$js = '';
$handle = '';
$file = '';
// open the "js" directory
if ($handle = opendir('Includes/js')) {
    // list directory contents
    while (false !== ($file = readdir($handle))) {
        // only grab file names
        if (is_file('Includes/js/' . $file)) {
            // insert HTML code for loading Javascript files
            $js .= '<script src="Includes/js/' . $file . '" type="text/javascript"></script>' . "\n";
        }
    }
    closedir($handle);
    echo $js;
}
?><script type="text/javascript">
		$()
    .ready(function() {
	$("#empcode").focus();
	$.validator.addMethod("selectfinyear", function(value, element, arg) {
            return arg != value;
        }, "Select Financial Year.");
	$("#loginForm")
            .validate({
                rules: {
                    empcode: {
                        minlength: 4,
                        required: true,
                        number: true
                    },
                    password: {
                        minlength: 5,
                        required: true
                    },
                    cmbfinyear: {
                        selectfinyear: "0"
                       
                    }

                },
                messages: {
                    empcode: {
                        required: "Please enter Employee Code",
                        minlength: "Your Employee Code must consist of at least 5 characters",
                        number: "Enter Numbers Only"
                    },
                    password: {
                        required: "Please enter your Password",
                        minlength: "Your Password must consist of at least 5 characters"
                    }
                },
                showErrors: function(errorMap, errorList) {
                    $.each(this.successList, function(index, value) {
                        return $(value).popover("hide");
                    });
                    return $.each(errorList, function(index, value) {
                        var _popover;
                        //console.log(value.message);
                        _popover = $(value.element).popover({
                                trigger: "manual",
                                placement: "top",
                                content: value.message,
                                template: "<div class=\"popover\"><div class=\"arrow\"></div><div class=\"popover-inner\"><div class=\"popover-content\"><p></p></div></div></div>"
                            });
                        _popover.data("popover")
                            .options.content = value.message;
                        return $(value.element)
                            .popover("show");
                    });
                },

                /*submitHandler: function() {
                    alert("Submit");
                }*/
            });
	});	</script>	

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
	<div class="col-md-4"></div>
        <div class="col-md-8 pull-right">
<?php		if(isset($_SESSION['logged_in'])) {
$lnk="<li class=' btn-info'><a href='#'>Session ID: ".session_id()  ."</a></li><li class='btn-warning'><a href='#'>Finyear ID: ".$_SESSION['FinYearID']."</a></li><li class='btn-info'><a href='#'> Token: ".$_SESSION['token'] ."</a></li>	";

}echo $lnk;?>
		</div>
    </div>
	</div><!--<div class="container">-->.
	<br class="clearBoth" />
	
	<!-- BOF Contents-->
	
		
		<div class="container">
		
		<?php
		echo $error;?>	<div class="col-md-6 col-md-offset-3" >
	
	<div class="row">
<div class="panel panel-primary well">
<div class="panel-heading">Login to Continue</div>
<br>
	<form id="loginForm" name="loginForm" action="login.php" method="post" >
	         <div class="form-group">
            <label for="empcode">Employee Code</label>
			<input type="text" id="empcode" name="empcode" autocomplete="off" class="form-control" />
                    </div>
        <div class="form-group">
            <label for="password">Password</label>
			 <input type="password" id="password" name="password"  autocomplete="off" class="form-control"  />
                </div>
		<div class="form-group">
		<label for="cmbfinyear">Fin Year</label>
		<?php		$sql = "SELECT Finyear_ID,Finyear FROM tbl_finyear_master 	";
		
$result = mysql_query($sql);

echo "<select name='cmbfinyear' class='form-control'>";
?><option value='0'>Select Financial Year</option><?php
while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['Finyear_ID'] . "'>" . $row['Finyear'] . "</option>";
}
echo "</select>";
?></div>
                <button type="submit"  name="submit-login" id="btn_submit" class="btn btn-primary">Login</button> 
				
    </form>
		</div>
		</div>
	</div>
	
</div>

<!-- EOF Contents-->

	     

