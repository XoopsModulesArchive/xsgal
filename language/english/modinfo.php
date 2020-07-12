<?php
//  ------------------------------------------------------------------------ //
//                xsGallery - XOOPS Simple Gallery Module                    //
//                            Versión 1.3                                    //
//                   Copyright (c) 2007 Dana Harris                          //
//                       http://www.optikool.com                             //
// ------------------------------------------------------------------------- //
//  Based on Saurdo Gallery                                                  //
//  Creator: Saurdo - www.saurdo.com / me@saurdo.com                         //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

define("_MI_XSGAL_NAME","Simple Gallery");
define("_MI_XCGAL_DESC","Simple photos gallery for XOOPS sites");
define("_MI_XSGAL_RDESC","Shows five latest galleries");
define('_MI_XSGAL_BNAME1','Recent Images');
define('_MI_XSGAL_GAL_ADD','Gallery Directory');
define('_MI_XSGAL_GAL_ADD_DESC','Your gallery folder (this is where your pictures and picture folders are located)');
define("_MI_XSGAL_MODDIR","Module Directory");
define("_MI_XSGAL_MODDIR_DESC","Directory containing XSGal module. Default is xsgal.");
define("_MI_XSGAL_RECIMGDIR","Recent Images Directory");
define("_MI_XSGAL_RECIMGDIR_DESC","Directory where you recent images is located.");
define("_MI_XSGAL_RECTOTAL","Recent Display");
define("_MI_XSGAL_RECTOTAL_DESC","Number of recent image collections to display.");
define("_MI_XSGAL_EXCL_FOLD","Folders to exclude");
define("_MI_XSGAL_EXCL_FOLD_DESC","Folders you wish to exclude seperated by comma. (ex. folder1,folder2,folder3");
define("_MI_XSGAL_IMG_PER_PAGE","Image Thumbnails per page");
define("_MI_XSGAL_IMG_PER_PAGE_DESC","Number of thumbnails to display per page.");
define("_MI_XSGAL_PICTWTH","Picture Width");
define("_MI_XSGAL_PICTWTH_DESC","The width of the picture to display.");
define("_MI_XSGAL_PICTHI","Picture Height");
define("_MI_XSGAL_PICTHI_DESC","The height of the picture to display.");

define("_MI_XSGAL_PICTINFWTH","Picture Information Width");
define("_MI_XSGAL_PICTINFWTH_DESC","The width of the picture to displayed on the information page.");
define("_MI_XSGAL_PICINFTHI","Picture Information Height");
define("_MI_XSGAL_PICINFTHI_DESC","The height of the picture to displayed on the information page.");

define("_MI_XSGAL_THUMBWTH","Thumbnail Width");
define("_MI_XSGAL_THUMBWTH_DESC","The width of the thumbnails that are displayed.");
define("_MI_XSGAL_THUMBHI","Thumbnail Height");
define("_MI_XSGAL_THUMBHI_DESC","The width of the thumbnails that are displayed.");
define("_MI_XSGAL_F_COLS","Main Thumbnail Columns");
define("_MI_XSGAL_F_COLS_DESC","How many columns of thumbnails per row.");
define("_MI_XSGAL_THUMB_COLS","Collection Thumbnail Columns");
define("_MI_XSGAL_THUMB_COLS_DESC","How many columns of thumbnails per row.");
define("_MI_XSGAL_GENERALCONF","Preferences");
define("_MI_XSGAL_MARQUEE","Enable Marquee");
define("_MI_XSGAL_MARQUEE_DESC","Enabled or Disabled Recent Images Marquee");
define("_MI_XSGAL_MARQUEE_DIRECTION","Marquee Direction");
define("_MI_XSGAL_MARQUEE_DIRECTION_DESC","Up, Down, Left, Right");
define("_MI_XSGAL_MARQUEE_WIDTH","Marquee Width");
define("_MI_XSGAL_MARQUEE_WIDTH_DESC","Set the width of the Marquee box");
define("_MI_XSGAL_MARQUEE_HEIGHT","Marquee Height");
define("_MI_XSGAL_MARQUEE_HEIGHT_DESC","Set the height of the Marquee box");
define("_MI_XSGAL_MARQUEE_SAMOUNT","Marquee Scroll Amount");
define("_MI_XSGAL_MARQUEE_SAMOUNT_DESC",'SCROLLAMOUNT sets the size in pixels of each jump. A higher value for SCROLLAMOUNT makes the marquee scroll faster. The default value is 6');
define("_MI_XSGAL_MARQUEE_SDELAY","Marquee Scroll Delay");
define("_MI_XSGAL_MARQUEE_SDELAY_DESC",'SCROLLDELAY sets the amount of delay in milliseconds (a millisecond is 1/1000th of a second). The default delay is 85');
define("_MI_XSGAL_MARQUEE_UP","Up");
define("_MI_XSGAL_MARQUEE_DOWN","Down");
define("_MI_XSGAL_MARQUEE_LEFT","Left");
define("_MI_XSGAL_MARQUEE_RIGHT","Right");
define("_MI_XSGAL_WATERMARK","Show Watermark");
define("_MI_XSGAL_WATERMARK_DESC","If enabled a watermark will display on your image. Watermark will not show on Full Sized View or Thumbnails.");
define("_MI_XSGAL__TEXTWATERMARK","Watermark Text");
define("_MI_XSGAL_TEXTWATERMARK_DESC","Text that will appear as a watermark on your images.");
define("_MI_XSGAL_FULLVIEW","Show Full Sized");
define("_MI_XSGAL_FULLVIEW_DESC","If enabled the visitor will have the options to see a full size view of the image.");
define("_MI_XSGAL__WATERMARKSIZE","Watermark Font Size");
define("_MI_XSGAL_WATERMARKSIZE_DESC","Specify the font size for watermark text. (1 < 5)");
define("_MI_XSGAL_WATERMARKSIZE1","1");
define("_MI_XSGAL_WATERMARKSIZE2","2");
define("_MI_XSGAL_WATERMARKSIZE3","3");
define("_MI_XSGAL_WATERMARKSIZE4","4");
define("_MI_XSGAL_WATERMARKSIZE5","5");
define("_MI_XSGAL_SHOWHITS","Show Catalog Hits");
define("_MI_XSGAL_SHOWHITS_DESC","If enabled will show the number of time a particular catalog was accessed.");
define("_XSGAL_MENU","Catalog Hits");

?>
