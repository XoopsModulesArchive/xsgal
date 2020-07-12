<?php

//  ------------------------------------------------------------------------ //
//                  xsGallery - XOOPS Simple Gallery Module                  //
//                    Copyright (c) 2007 Mowaffak Ragas                      //
//                           mowaffakr@yahoo.com                             //
//                       http://www.arabxoops.com                            //
//  ------------------------------------------------------------------------ //
//  Based on Saurdo Gallery                                                  //
//  Creator: Saurdo - www.saurdo.com / me@saurdo.com                         //
//  ------------------------------------------------------------------------ //

include_once('../../../mainfile.php');
include_once('./functions.php');

$show_watermark = getModuleOptionXs('show_watermark');
$text_watermark = getModuleOptionXs('text_watermark');
$watermark_size = getModuleOptionXs('watermark_size');

if ($_GET['thumb'] == 0) {
	$pictwidth = getModuleOptionXs('pictwidth');
	$pictheight = getModuleOptionXs('pictheight');
} elseif ($_GET['thumb'] == 2) {
	$pictwidth = getModuleOptionXs('picinfwidth');
	$pictheight = getModuleOptionXs('picinfheight');
} elseif ($_GET['thumb'] == 3) {
	$pictwidth = getModuleOptionXs('pictwidth');
	$pictheight = getModuleOptionXs('pictheight');
} else {
	$pictwidth = getModuleOptionXs('thumbwidth');
	$pictheight = getModuleOptionXs('thumbheight');
}

generateImg($_GET['file'], $_GET['thumb'], $pictwidth, $pictheight);

function generateImg($img, $thumb, $w, $h) {

	global $show_watermark, $text_watermark, $watermark_size;
	$img = XOOPS_ROOT_PATH.'/'.$img;
	$width = $w;
	$height = $h;	
		
	$path = pathinfo($img);
	switch(strtolower($path["extension"])){
		case "jpeg":
		case "jpg":
			Header("Content-type: image/jpeg");
			$img=imagecreatefromjpeg($img);
			break;
		case "gif":
			Header("Content-type: image/gif");
			$img=imagecreatefromgif($img);
			break;
		case "png":
			Header("Content-type: image/png");
			$img=imagecreatefrompng($img);
			break;
		default:
			break;			
	}
	$xratio = $width/(imagesx($img));
	$yratio = $height/(imagesy($img));

	if($xratio < 1 || $yratio < 1) {
		if($xratio < $yratio) {
			$resized = imagecreatetruecolor($width,floor(imagesy($img)*$xratio));
		} else {
			$resized = imagecreatetruecolor(floor(imagesx($img)*$yratio), $height);
		}
		imagecopyresampled($resized, $img, 0, 0, 0, 0, imagesx($resized)+1,imagesy($resized)+1,imagesx($img),imagesy($img));
		
		if($show_watermark) {
			if ($thumb == 0 || $thumb == 2 || $thumb == 3) {
				$textColor = imagecolorallocate($resized, 255, 255, 255);
				imagestring($resized, 3, 5, imagesy($resized)-20, $text_watermark, $textColor);
			}
		}
			
		imagejpeg($resized);
		imagedestroy($resized);
	} else {
		if($show_watermark) {
			if ($thumb == 0 || $thumb == 2 || $thumb == 3) {
				$textColor = imagecolorallocate($img, 255, 255, 255);
				imagestring($img, $watermark_size, 5, imagesy($img)-20, $text_watermark, $img);
			}
		}
		imagejpeg($img);
	}
	imagedestroy($img);		
}
?>
