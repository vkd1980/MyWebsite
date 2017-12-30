<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
//Maha ganapathaye Namah!
//Bookstore FrontEnd V 1.0
//© I biz Info Solutions
require_once (__DIR__.'/includes/classes/global.inc.php');
include(__DIR__.'/includes/header.php');
include(__DIR__.'/includes/classes/Crypto.php');
?>
<body>

</body>
<?php
		print_r( getimagesize("img/photos/test.jpg"));

//$cart->destroy();

//echo phpinfo();
//production
//PHP Version 5.4.7
//Apache Version	Apache/2.4.3
//Software version: 5.1.73

//Development
//xammp 3.2.1
//MysqlServer version: 5.6.21 tested
//Apache/2.4.10
//PHP/5.6.3
?>
<iframe src="<?php echo $production_url?>" id="paymentFrame" width="482" height="450" frameborder="0" scrolling="No" ></iframe>
<?php
include(__DIR__.'/includes/footer.php');
?>
