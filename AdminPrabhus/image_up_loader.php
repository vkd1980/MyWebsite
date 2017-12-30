<?php
if((empty($_SERVER['HTTP_X_REQUESTED_WITH']) or strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') or empty($_REQUEST)){/*Detect AJAX and POST request*/
  $response= array("ERROR","Hacking attempt");
	echo json_encode($response);
  exit();
}
require_once (__DIR__.'/includes/classes/global.inc.php');
if(!empty($_REQUEST['Token']) && isset($_FILES["file"]["type"]) &&(hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/book_master.php', $_SESSION['csrf_token']))))
{
$pmodel=isset($_REQUEST['pmodel']) ? filter_var(($_REQUEST['pmodel']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH): '';
$validextensions = array("jpeg", "jpg", "png");
$temporary = explode(".", $_FILES["file"]["name"]);
$file_extension = end($temporary);
if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")
) && ($_FILES["file"]["size"] < 4000000)//Approx. 100kb files can be uploaded.
&& in_array($file_extension, $validextensions)) {
if ($_FILES["file"]["error"] > 0)
{
echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
}
else
{
if (file_exists("../img/photos/" . $_FILES["file"]["name"])) {
//echo $_FILES["file"]["name"] . " <span id='invalid'><b>already exists.</b></span> ";
}
else
{
// some settings
		$max_upload_width = 236;
		$max_upload_height = 409;
		// if uploaded image was JPG/JPEG
		if($_FILES["file"]["type"] == "image/jpeg" || $_FILES["file"]["type"] == "image/pjpeg"){
			$image_source = imagecreatefromjpeg($_FILES["file"]["tmp_name"]);
		}
		// if uploaded image was GIF
		if($_FILES["file"]["type"] == "image/gif"){
			$image_source = imagecreatefromgif($_FILES["file"]["tmp_name"]);
		}
		// BMP doesn't seem to be supported so remove it form above image type test (reject bmps)
		// if uploaded image was BMP
		if($_FILES["file"]["type"] == "image/bmp"){
			$image_source = imagecreatefromwbmp($_FILES["file"]["tmp_name"]);
		}
		// if uploaded image was PNG
		if($_FILES["file"]["type"] == "image/x-png"){
			$image_source = imagecreatefrompng($_FILES["file"]["tmp_name"]);
		}
		$remote_file = $pmodel.".jpg";
		imagejpeg($image_source,"../img/photos/".$remote_file,100);
		chmod("../img/photos/".$remote_file,0644);

		// get width and height of original image
		list($image_width, $image_height) = getimagesize("../img/photos/".$remote_file);

		if($image_width>$max_upload_width || $image_height >$max_upload_height){
			$proportions = $image_width/$image_height;

			if($image_width>$image_height){
				$new_width = $max_upload_width;
				$new_height = round($max_upload_width/$proportions);
			}
			else{
				$new_height = $max_upload_height;
				$new_width = round($max_upload_height*$proportions);
			}


			$new_image = imagecreatetruecolor($new_width , $new_height);
			$image_source = imagecreatefromjpeg("../img/photos/".$remote_file);

			imagecopyresampled($new_image, $image_source, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height);
			imagejpeg($new_image,"../img/photos/".$remote_file,100);

			imagedestroy($new_image);
		}

		imagedestroy($image_source);
    //$data = array("products_image" => "'$remote_file'");
//Update to DB
$DBC = new DB();
$DBC->updatedb("UPDATE `products` SET `products_image`='".$remote_file."' WHERE  `products_model`='".$pmodel."';");
//Eof New
echo "<span id='success'>Image Uploaded Successfully...!!</span><br/>";
//imagedestroy($_FILES["file"]["tmp_name"]);

}
}

}
else
{
echo "<span id='invalid'>***Invalid file Size or Type***<span>";
}
}
