<?php
header("Pragma: public");
header("Cache-Control: max-age = 604800");
header("Expires: ".gmdate("D, d M Y H:i:s", time() + 604800)." GMT");

function thumbnail($image, $width, $height) {

	$image_properties = getimagesize($image);
	$image_width = $image_properties[0];
	$image_height = $image_properties[1];
	$image_ratio = $image_width / $image_height;
	$type = $image_properties["mime"];

	if(!$width && !$height) {
		$width = $image_width;
		$height = $image_height;
	}
	if(!$width) {
		$width = round($height * $image_ratio);
	}
	if(!$height) {
		$height = round($width / $image_ratio);
	}

	if($type == "image/jpeg") {
		header('Content-type: image/jpeg');
		$thumb = imagecreatefromjpeg($image);
	} elseif($type == "image/png") {
		header('Content-type: image/png');
		$thumb = imagecreatefrompng($image);
	} elseif($type == "image/gif") {
		header('Content-type: image/gif');
		$thumb = imagecreatefromgif($image);		
	} else {
		return false;
	}

	$temp_image = imagecreatetruecolor($width, $height);
	imagecopyresampled($temp_image, $thumb, 0, 0, 0, 0, $width, $height, $image_width, $image_height);
	$thumbnail = imagecreatetruecolor($width, $height);
	imagecopyresampled($thumbnail, $temp_image, 0, 0, 0, 0, $width, $height, $width, $height);

	if($type == "image/jpeg") {
		imagejpeg($thumbnail);
	}elseif($type == "image/gif") {
		imagegif($thumbnail);		
	} else {
		imagepng($thumbnail);
	}

	imagedestroy($temp_image);
	imagedestroy($thumbnail);

}

if(isset($_GET["h"])) { $h = $_GET["h"]; } else { $h = 0; }
if(isset($_GET["w"])) { $w = $_GET["w"]; } else { $w = 0; }
$img = isset($_GET['img']) ? $_GET['img'] : "";
$path = dirname(realpath(__FILE__));
$path2 = $path.DIRECTORY_SEPARATOR.$img;
if(file_exists($path2) && $w!= 0 && $h != 0)
{	
	thumbnail($path2, $w, $h);
}
?>