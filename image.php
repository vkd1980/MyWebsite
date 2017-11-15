<?php
//phpinfo(); 
$width  = 140;
$height = 80;
$image  = $_GET['img'];
$ext    = 'png';

// Check if file exists
if ( ! file_exists('img/photos/'.$image.'.'.$ext))
{
    die('Unable to process the requested file.');
}

// Check if a thumb already exists, otherwise create a thumb
if (file_exists('cache/ImageCache'.$image.'_thumb.'.$ext))
{
    $img = new Imagick('cache/ImageCache'.$image.'_thumb.'.$ext);
}
else
{
    $img = new Imagick('cache/ImageCache'.$image.'.'.$ext);
    $img->setImageFormat($ext);
    $img->scaleImage($width, 0);
    $img->cropImage($width, $height, 0, 0);
    $img->writeImage('cache/ImageCache'.$image.'_thumb.'.$ext);
}

// Return as an image
header('Content-Type: image/'.$ext);
echo $img;
?>