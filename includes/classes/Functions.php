<?php
require_once 'global.inc.php';

/*function breadcrumbs($separator = ' &raquo; ', $home = 'Home') {

    $path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
    $base_url = substr($_SERVER['SERVER_PROTOCOL'], 0, strpos($_SERVER['SERVER_PROTOCOL'], '/')) . '://' . $_SERVER['HTTP_HOST'] . '/';
    $breadcrumbs = array("<a href=\"$base_url\">$home</a>");
    $tmp = array_keys($path);
    $last = end($tmp);
    unset($tmp);

    foreach ($path as $x => $crumb) {
        $title = ucwords(str_replace(array('.php', '_'), array('', ' '), $crumb));
	if ($x == 1){
	        $breadcrumbs[]  = "<a href=\"$base_url$crumb\">$title</a>";
	}elseif ($x > 1 && $x < $last){
		$tmp = "<a href=\"$base_url";
		for($i = 1; $i <= $x; $i++){
			$tmp .= $path[$i] . '/';
		}
                $tmp .= "\">$title</a>";
		$breadcrumbs[] = $tmp;
		unset($tmp);
        }else{
                $breadcrumbs[] = "$title";
	}
    }

    return implode($separator, $breadcrumbs);
}*/
function breadcrumbs($sep = ' &raquo; ', $home = 'Home') {
//Use RDFa breadcrumb, can also be used for microformats etc.
$bc     =   '<div xmlns:v="http://rdf.data-vocabulary.org/#" id="crums">';
//Get the website:
$site   =   'http://'.$_SERVER['HTTP_HOST'];
//Get all vars en skip the empty ones
$crumbs =   array_filter( explode("/",$_SERVER["REQUEST_URI"]) );
//Create the home breadcrumb
$bc    .=   '<span typeof="v:Breadcrumb"><a href="'.$site.'" rel="v:url" property="v:title">'.$home.'</a>'.$sep.'</span>';
//Count all not empty breadcrumbs
$nm     =   count($crumbs);
$i      =   1;
//Loop the crumbs
foreach($crumbs as $crumb){
    //Make the link look nice
    $link    =  ucfirst( str_replace( array(".php","-","_"), array(""," "," ") ,$crumb) );
    //Loose the last seperator
    $sep     =  $i==$nm?'':$sep;
    //Add crumbs to the root
    $site   .=  '/'.$crumb;
    //Make the next crumb
    $bc     .=  '<span typeof="v:Breadcrumb"><a href="'.$site.'" rel="v:url" property="v:title">'.$link.'</a>'.$sep.'</span>';
    $i++;
}
$bc .=  '</div>';
//Return the result
return $bc;}

function output($Return=array()){
    /*Set response header*/
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    /*Final JSON response*/
    exit(json_encode($Return));
}

function SendMailSmtp($To,$Subject,$message){

$mail = new PHPMailer();
//$mail->SMTPDebug = 2;
//$mail->Debugoutput = 'html';
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
$mail->IsSMTP();
$mail->Host = SMTP_SERVER;
// Remove these next 3 lines if you dont need SMTP authentication
$mail->SMTPAuth = true;
$mail->Username = SMTP_USER_NAME;
$mail->Password = SMTP_PASSWORD;
// Set who the email is coming from
$mail->SetFrom('admin@prabhusbooks.com', 'Prabhus Books Online');
$mail->addReplyTo('admin@prabhusbooks.com', 'Prabhus Books Online');
// Set who the email is sending to
$mail->AddAddress($To);
// Set the subject
$mail->Subject = $Subject;
//Set Bcc
$mail->AddBCC('admin@prabhusbooks.com', 'Administrator');
//Set the message
$mail->MsgHTML($message);
//$mail->AltBody =(strip_tags($message));
//$mail->AltBody = strip_tags($message);
// Send the email
if(!$mail->Send()) {
 return "Mailer Error: " . $mail->ErrorInfo;
}
else
{
return true;
}

}
function SendMailSmtpCC($To,$Subject,$Bcc='',$message){

$mail = new PHPMailer();
//$mail->SMTPDebug = 2;
//$mail->Debugoutput = 'html';
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
$mail->IsSMTP();
$mail->Host = SMTP_SERVER;
// Remove these next 3 lines if you dont need SMTP authentication
$mail->SMTPAuth = true;
$mail->Username = SMTP_USER_NAME;
$mail->Password = SMTP_PASSWORD;
// Set who the email is coming from
$mail->SetFrom('admin@prabhusbooks.com', 'Prabhus Books Online');
$mail->addReplyTo('admin@prabhusbooks.com', 'Prabhus Books Online');
// Set who the email is sending to
$mail->AddAddress($To);
// Set the subject
$mail->Subject = $Subject;
//Set Cc
//$mail->AddCC($Cc);
//Set Bcc
$mail->AddBCC($Bcc);
//Set the message
$mail->MsgHTML($message);
//$mail->AltBody =(strip_tags($message));
//$mail->AltBody = strip_tags($message);
// Send the email
if(!$mail->Send()) {
 return "Mailer Error: " . $mail->ErrorInfo;
}
else
{
return true;
}

}


function curPageURL() {
 $pageURL = 'http';
 if (array_key_exists('HTTPS', $_SERVER) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
 function get_ip_address() {
    if (isset($_SERVER)) {
      if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
      } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
      } elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED'];
      } elseif (isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
      } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_FORWARDED_FOR'];
      } elseif (isset($_SERVER['HTTP_FORWARDED'])) {
        $ip = $_SERVER['HTTP_FORWARDED'];
      } else {
        $ip = $_SERVER['REMOTE_ADDR'];
      }
    } else {
      if (getenv('HTTP_X_FORWARDED_FOR')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
      } elseif (getenv('HTTP_CLIENT_IP')) {
        $ip = getenv('HTTP_CLIENT_IP');
      } else {
        $ip = getenv('REMOTE_ADDR');
      }
    }

    return $ip;
  }


/**
 * Ensures an ip address is both a valid IP and does not fall within
 * a private network range.
 */
function validate_ip($ip) {
    if (strtolower($ip) === 'unknown')
        return false;

    // generate ipv4 network address
    $ip = ip2long($ip);

    // if the ip is set and not equivalent to 255.255.255.255
    if ($ip !== false && $ip !== -1) {
        // make sure to get unsigned long representation of ip
        // due to discrepancies between 32 and 64 bit OSes and
        // signed numbers (ints default to signed in PHP)
        $ip = sprintf('%u', $ip);
        // do private network range checking
        if ($ip >= 0 && $ip <= 50331647) return false;
        if ($ip >= 167772160 && $ip <= 184549375) return false;
        if ($ip >= 2130706432 && $ip <= 2147483647) return false;
        if ($ip >= 2851995648 && $ip <= 2852061183) return false;
        if ($ip >= 2886729728 && $ip <= 2887778303) return false;
        if ($ip >= 3221225984 && $ip <= 3221226239) return false;
        if ($ip >= 3232235520 && $ip <= 3232301055) return false;
        if ($ip >= 4294967040) return false;
    }
    return true;
}
Function ShowCartModal()
{
$cart= new ShoppingCart();
$CartHTMl= '<div class="modal-dialog">
						<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
						<h4>Shopping Cart</h4>
					</div>
					<div class="modal-body">
						<table class="table table-striped tcart">
							<thead>
								<tr>
								  <th>Name</th>
								  <th>Quantity</th>
								  <th>Price</th>
								  <th>Total</th>

								</tr>
							</thead>
							<tbody>';

        if($cart->total_items() > 0){
            //get cart items from session
            $cartItems = $cart->contents();
            foreach($cartItems as $item){

								$CartHTMl= $CartHTMl.'<tr>
								  <td>'.$item["name"].'</td>
								  <td>'.$item["qty"].'</td>
								  <td align="right"><span class="fa fa-inr"></span> '. number_format( (float) $item["price"], 2, '.', '').'</td>
								  <td align="right"><span class="fa fa-inr"></span> '. number_format( (float) $item["subtotal"], 2, '.', '').'</td>
								  	</tr>';
								 } }else{
        $CartHTMl=$CartHTMl.'<tr><td colspan="5"><p>Your cart is empty.....</p></td></tr>';
       }
								$CartHTMl=$CartHTMl.'<tr>
								  <th align="right">Total Weight:</th>
								  <th>'.$cart->total_weight().'Kg</th>
								  <th>Total</th>
								  <th align="right"><span class="fa fa-inr"></span> '. number_format( (float) $cart->total(), 2, '.', '').'</th>

								</tr>
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<a class="btn btn-warning cartclose" data-dismiss="modal"><i class="glyphicon glyphicon-menu-left"></i> Continue Shopping</a>
						<a href="../checkout.html" class="btn btn-success " >Checkout <i class="glyphicon glyphicon-menu-right"></i></a>
					</div>
				</div></div>
			';
		return $CartHTMl;
}
if(!function_exists('hash_equals'))
{
    function hash_equals($str1, $str2)
    {
        if(strlen($str1) != strlen($str2))
        {
            return false;
        }
        else
        {
            $res = $str1 ^ $str2;
            $ret = 0;
            for($i = strlen($res) - 1; $i >= 0; $i--)
            {
                $ret |= ord($res[$i]);
            }
            return !$ret;
        }
    }
}

Function ShowPostage()
{
$cart= new ShoppingCart();
$DBC = new DB();
$qry="SELECT * FROM shipping_modules WHERE STATUS= TRUE;";
$result= $DBC->select($qry);

	if(mysqli_num_rows($result) > 0)
	{
	while($rows =  mysqli_fetch_array($result))
		{
		/*check zone is valied*/
		if (CheckZoneStatus($_SESSION['Address']['Cust_state_id'],$rows['Shipping_Zone'])== true){
		/**/
$weight=ceil($cart->total_weight());
$data=$rows['Shipping_Table'];
$size = sizeof(preg_split("/[:,]/" , $data));
$zones2_table=preg_split("/[:,]/" , $data);
$shipping = 0;
$pktnumber=0;
for($b = $weight; $b>=0; $b-=1) {

  for($i=0; $i<$size; $i+=2) {
      if ($weight == $zones2_table[$i]) {

      $weight=$weight-$zones2_table[$i];
      $shipping=$shipping+$zones2_table[$i+1];
              $pktnumber+=1;

            }
      else//$weight is not equal to $zones
            {
              if ($weight >$zones2_table[($size-2)]) {
                              $weight=$weight-$zones2_table[($size-2)];
                              $shipping=$shipping+$zones2_table[($size-1)];
                              $pktnumber+=1;
                            }

            }
  }

  $b = $weight;

  }
  $itemData[] = array(
		'ShippingID' => $rows['Shipping_Id'],
		'name' => $rows['Shipping Name'],
		'Method' => $rows['Shipping Method'],
		'Postage' => $shipping,
		'Packets' => $pktnumber,
		'Img' =>$rows['Shipping_Image']);
		}

		/*Eof Zone*/

		}
	}
	else{
	echo'noShipping Modules Available';
	}
	return $itemData;
}

function CheckZoneStatus($stateid,$Zone){
$DBC = new DB();
/*show Postate*/
$qry="select State_id from zones_to_geo_zones where geo_zone_id = '".$Zone."' and zone_country_id = '".$_SESSION['Address']['Cust_country_id']."' order by State_id";
$result= $DBC->select($qry);
while($rows =  mysqli_fetch_array($result)){
				if ($rows['State_id'] < 1) {
				  return true;
				  break;
				} elseif ($rows['State_id']== $stateid) {
					return true;
					break;
				}
			}
}


function ShowPayments()
{
$DBC = new DB();
$qry="SELECT * FROM payment_modules WHERE STATUS= TRUE;";
$result= $DBC->select($qry);
	if(mysqli_num_rows($result) > 0)
	{
	while($rows =  mysqli_fetch_array($result))
		{
		$itemData[] = array(
		'PaymentID' => $rows['Payment_id'],
		'name' => $rows['Payment_name'],
		'paymentMethod' =>$rows['Payment Method'],
		'Img' =>$rows['Payment_image']);
		}
	}
	return $itemData;
}
function sendsms($Mob_No,$sms_text)
{
$ch = curl_init();
$user="admin@prabhusbooks.com:Vinod123*";
$receipientno=$Mob_No;
$senderID="PRABHU";
$msgtxt=$sms_text;
curl_setopt($ch,CURLOPT_URL,  "http://api.mVaayoo.com/mvaayooapi/MessageCompose");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "user=$user&senderID=$senderID&receipientno=$receipientno&msgtxt=$msgtxt");
$buffer = curl_exec($ch);
$SMSStat=explode(',', $buffer);
if($SMSStat[0]=='Status=0')
{ return true; }
else
{ return false; }
curl_close($ch);
}
function hideEmail($email)
{
    $mail_parts = explode("@", $email);
    $length = strlen($mail_parts[0]);
    $show = floor($length/2);
    $hide = $length - $show;
    $replace = str_repeat("*", $hide);

    return substr_replace ( $mail_parts[0] , $replace , $show, $hide ) . "@" . substr_replace($mail_parts[1], "**", 0, 2);
}

function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>
