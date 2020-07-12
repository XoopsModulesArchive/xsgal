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

include(XOOPS_ROOT_PATH."/mainfile.php");
function b_recent_gallery_show() {
	global $currentdir, $file, $recentImagesDir, $xoopsModuleConfig, $xoopsConfig, $gallery_root, $gal_root, $modDir, $thumbwidth, $thumbheight, $xoopsOption, $db;
	
	if (file_exists(XOOPS_ROOT_PATH.'/modules/xsgal/include/functions.php')) {
		require_once XOOPS_ROOT_PATH.'/modules/xsgal/include/functions.php';
	}
	
	if (file_exists(XOOPS_ROOT_PATH.'/modules/xsgal/language/'.$xoopsConfig['language'].'/main.php')) {
		include_once XOOPS_ROOT_PATH.'/modules/xsgal/language/'.$xoopsConfig['language'].'/main.php';
	} else {
		include_once XOOPS_ROOT_PATH.'/modules/xsgal/language/english/main.php';
	}
		
	$sql = "SELECT side FROM ".$db->prefix('newblocks')." WHERE show_func='b_recent_gallery_show'";
	$result = $db->query($sql);
	list($xsLocation) = $db->fetchRow($result);
	
	$recentImagesDir = getModuleOptionXs('recentImagesDir');
	$recentTotal = getModuleOptionXs('recentTotal');
	$gallery_address = getModuleOptionXs('gallery_address');
	$modDir = getModuleOptionXs('modDir');
	$thumbwidth = getModuleOptionXs('thumbwidth');
	$thumbheight = getModuleOptionXs('thumbheight');	
	$enable_marquee = getModuleOptionXs('enable_marquee');
	$marquee_direction = getModuleOptionXs('marquee_direction');
	$marquee_width = getModuleOptionXs('marquee_width');
	$marquee_height = getModuleOptionXs('marquee_height');
	$marquee_scrollamount = getModuleOptionXs('marquee_scrollamount');
	$marquee_scrolldelay = getModuleOptionXs('marquee_scrolldelay');
	
	if (!eregi($recentImagesDir, $gallery_address)) {		
	  	$file = $recentImagesDir;
	} else {		
	  	$file = "";
	}
	
	$modURL = 'http://'.$_SERVER['HTTP_HOST'].'/modules/'.$modDir;
	
	setRecentCurrentdir();
   
   	$recentDir = array();   
	
	if (eregi($gallery_address, $gallery_root)) {
		if ( substr ( $gallery_root, -1 ) != '/' ) $gallery_root .= '/'; // Add a trailing slash		
		$recentDir = buildDirs($gallery_root.$currentdir);
	} else {		
   		$recentDir = buildDirs($gallery_root.$gallery_address."/".$currentdir);
		
	}
   $myDir = array();
   $blocks = array();
   $total = count($recentDir);
   
     
   for ($i = 0; $i < $total; $i++) {
     $currDir = array();
	 $myImgfiles = "";
	 $currDir['currDir'] = $recentDir[$i];
	 $currDir['time'] = date("Y-m-d:G-i-s", filemtime( XOOPS_ROOT_PATH.'/'.$gallery_address.'/'.$currentdir.'/'.$recentDir[$i]));	
	 
	 if ($currentdir == "") { 
	 	$blksearchpath = XOOPS_ROOT_PATH.'/'.$gallery_address.'/'.$recentDir[$i];
	} else {
		$blksearchpath = XOOPS_ROOT_PATH.'/'.$gallery_address.'/'.$currentdir.'/'.$recentDir[$i];
	}

		$myBlkFileList = array();
		$myBlkFileList = searchPaths($blksearchpath, "", $myBlkFileList);
	 
	 		$currFile = pathinfo($myBlkFileList[0]);
	 
	 		$myImgPath = array();
	 		$myImgPath[0] = "";
	 		$myImgPath[1] = "";
	 
	 		if ($myBlkFileList[0] == "") {
	   			$myImgPath[1] = "";
	 		} else {
	   			list($myImgPath[0], $myImgPath[1]) = split("$gallery_address", $myBlkFileList[0]);
     		}
	 		
	 		$myThumbnail = "";

	 		if ($myImgPath[1] == "") {	 
				// Needs to be fixed.	
				$myThumbnail = 'modules/'.$modDir.'/images/404.gif';
	 		} else {
	  			$myThumbnail = $myImgPath[1];
	 		}
	 		
			if ($xsLocation == 0 || $xsLocation == 1) {
				if ($marquee_direction == "left" || $marquee_direction == "right") {
					if ($currentdir == "") {
	 					$currDir['dirLink'] = '<a href="'.$modURL.'/index.php?file='.$recentDir[$i].'/" class="linkopacity"><img src="'.$modURL.'/include/img.php?file='.$gallery_address.$myThumbnail.'&thumb=1"></a>&nbsp;&nbsp;';					
					} else {
						$currDir['dirLink'] = '<a href="'.$modURL.'/index.php?file='.$currentdir.'/'.$recentDir[$i].'/" class="linkopacity"><img src="'.$modURL.'/include/img.php?file='.$gallery_address.$myThumbnail.'&thumb=1"></a>&nbsp;&nbsp;';					
					}
	 			} else {
					if ($currentdir == "") {
						$currDir['dirLink'] = '<br /><a href="'.$modURL.'/index.php?file='.$recentDir[$i].'/" class="linkopacity"><img src="'.$modURL.'/include/img.php?file='.$gallery_address.$myThumbnail.'&thumb=1"><br /> '.$recentDir[$i].' </a><br />';					
					} else {
						$currDir['dirLink'] = '<br /><a href="'.$modURL.'/index.php?file='.$currentdir.'/'.$recentDir[$i].'/" class="linkopacity"><img src="'.$modURL.'/include/img.php?file='.$gallery_address.$myThumbnail.'&thumb=1"><br />'.$recentDir[$i].'</a><br />';					
					}
				}
			
			} else {
				if ($currentdir == "") {
	 					$currDir['dirLink'] = '<a href="'.$modURL.'/index.php?file='.$recentDir[$i].'/" class="linkopacity"><img src="'.$modURL.'/include/img.php?file='.$gallery_address.$myThumbnail.'&thumb=1"></a>';					
				} else {
						$currDir['dirLink'] = '<a href="'.$modURL.'/index.php?file='.$currentdir.'/'.$recentDir[$i].'/" class="linkopacity"><img src="'.$modURL.'/include/img.php?file='.$gallery_address.$myThumbnail.'&thumb=1"></a>';					
				}		
			}
			
	 		$blocks[$currDir['time']] = $currDir;   
   		}
				  
   		krsort($blocks);
		   
  	 	if ($total <= $recentTotal) {
   	 		$total = $total;
   		} else {
     		$total = $recentTotal;
	   	}
	  
	   	$block = array();
   
		$l = 0;
		foreach($blocks as $key => $value) {
			if ($l < $total) {
				$block[$key] = $value;
				$l++;
			} else {
				break;
			}
		}
		$css['csspth'] = $modURL;
		$block['csspath'][] = &$css;
		if ($enable_marquee) {
			
			$marq['marquee_start'] = '<marquee onmouseover="this.stop()" onmouseout="this.start()" scrollAmount="'.$marquee_scrollamount.'" scrollDelay="'.$marquee_scrollamount.'" align="center" width="'.$marquee_width.'" height="'.$marquee_height.'" direction="'.$marquee_direction.'">'."\n";			
			$marq['marquee_end'] = '</marquee>';			
		} else {
			$marq['marquee'] = "";
			$marq['marquee_end'] = "";
		}
		
		$block['marque'][] = &$marq;    
		unset($marq);			
		
   		return $block;
	}
?>
