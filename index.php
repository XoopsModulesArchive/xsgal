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


include("../../mainfile.php");

// include the default language file for the admin interface
if(!@include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/language/" . $xoopsConfig['language'] . "/main.php")){
    include_once(XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/language/english/main.php");
}
global $gallery_root, $gallery_address, $file, $excluded_folders, $pictwidth, $pictheight, $thumbwidth, $thumbheight, $gallery_width, $images_per_page, $thumbnail_cols;

include_once('include/functions.php');

$xoopsOption['template_main'] = "xsgal_index.html";
if ($xoopsConfig['startpage'] == 'xsgal') {
	include XOOPS_ROOT_PATH.'/header.php';
    $xoopsOption['show_rblock'] = 1;    
    $galleryTable = showGallery();
} else {
	include XOOPS_ROOT_PATH.'/header.php';
    $xoopsOption['show_rblock'] = 0;
    $galleryTable = showGallery();
}

$xoopsTpl->assign('main_title', _MD_XS_MAINTITLE);
$xoopsTpl->assign('description', _MD_XS_DESC);
$xoopsTpl->assign('gallery', $galleryTable);

include(XOOPS_ROOT_PATH."/footer.php");
?>
