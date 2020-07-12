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

if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

// Globals - Do not tamper with these
global $gallery_root, $gallery_address, $file, $excluded_folders, $pictwidth, $pictheight, $thumbwidth, $thumbheight, $gallery_width, $images_per_page, $thumbnail_cols, $xoopsModuleConfig, $db;

$db =& Database::getInstance();

$gallery_address = getModuleOptionXs('gallery_address');
$excluded_folders[] = split(',', getModuleOptionXs('excluded_folders'));
$images_per_page = getModuleOptionXs('images_per_page');
$thumbnail_cols = getModuleOptionXs('thumbnail_cols');
$f_cols = getModuleOptionXs('f_cols');
$recentImagesDir = getModuleOptionXs('recentImagesDir');
$modDir = getModuleOptionXs('modDir');
$allow_fullsizeview = getModuleOptionXs('allow_fullsizeview');
$gallery_root = $_SERVER['DOCUMENT_ROOT'].'/'.$gallery_address;
$gal_root = $gallery_address;
$gallery_address = 'http://'.$_SERVER['HTTP_HOST'].'/'.$gallery_address;


function showGallery() {
    global $file;
	
	$myGalList = "";

    if (!validateFile())
    {
        $myGalList = 'Invalid folder or file';
        return;
    }
    $myGalList = createNavigation();

    $path = pathinfo($file);
    if ($path['extension'] == '')
    {
    //Display Dir(s) (if any)
    $myGalList .= showDirs();

    //Display Thumb(s) (if any)
    $myGalList .= showThumbs();

    } else {
    $myGalList .= showSlide($file);

    }
	
	return $myGalList;
}

function showRecentGallery() {
    global $file;

    if (!validateFile())
    {
        echo 'Invalid folder or file';
        return;
    }
	//echo 'Place holder for recent gallery';

}

function setCurrentdir()
{
    global $currentdir, $file;
    $path = pathinfo($file);
    if ($path['extension'] != '')
        $currentdir = $path['dirname'].'/';
    else
        $currentdir = $file;
}

function setRecentCurrentdir()
{
    global $currentdir, $file;
    $currentdir = $file;
}

function buildDirs($Dir) {
	
    if ( substr ( $Dir, -1 ) != '/' ) $Dir .= '/'; // Add a trailing slash
    
	if (opendir($Dir)) {		
		$Handle = opendir($Dir);
	} 
	
    $myDirs = array();
    while ( false !== ( $File = readdir ( $Handle ) ) )
    {
        if ( $File == '.' OR $File == '..' OR !is_dir ( $Dir . $File ) ) continue;
		
        $myDirs[] = $File;
    }
    natcasesort ( $myDirs );
    return $myDirs;
}

function showDirs() {
    global $gallery_root, $currentdir, $file, $excluded_folders, $f_cols, $gal_root, $thumbwidth, $thumbheight, $xoopsModuleConfig, $db;	
	$gallery_rootSd = $gallery_root;
	
	if ( substr ( $gallery_rootSd, -1 ) != '/' )  $gallery_rootSd .= '/'; // Add a trailing slash		
		
    $Dirs = buildDirs($gallery_rootSd.$currentdir);
	
	$myShowDir = "";
 	$myShowDir .= "<table cellpadding=\"3\" align=\"center\" valign=\"top\" class=\"foldersbox\"><tr>\n";
	$myFileList = array();
    $i=0 ;
	
    foreach ( $Dirs as $dir ) {
		
		$searchpath = $gallery_rootSd.$file.$dir;	
		$show_hits = getModuleOptionXs('show_hits');	
		$myFileList = array();
		$myFileList = searchPaths($searchpath, "", $myFileList);		
		$currFile = pathinfo($myFileList[0]);		
		list($myImgPath[0], $myImgPath[1]) = split("$gal_root", $myFileList[0]);		
		$myThumbnail = "";

		if ($myImgPath[1] == "") {
		  $myThumbnail = $file.$dir.'/'.$currFile[basename];		  
		} else {
		  $myThumbnail = $myImgPath[1];		  
		}

        if (!in_array($dir, $excluded_folders)) {
		if($i%$f_cols==0)
           $myShowDir .=  '</tr><tr>'."\n";
           $myShowDir .=  '<td align="center" valign="top">'."\n";
		   $myShowDir .=  '<a href="'.$_SERVER['PHP_SELF'].'?file='.$currentdir.$dir.'/" class="linkopacity"><img src="./include/img.php?file='.getModuleOptionXs('gallery_address').$myThumbnail.'&thumb=1"><br /> '.$dir.' </a>';
		   if ($show_hits) {
		   		$dirSQL = "SELECT coll_hits FROM ".$db->prefix('xsgal_collection')." WHERE coll_name='".$dir."'";
				$result = $db->query($dirSQL);
				if (list($hitCount) = $db->fetchRow($result)) {					
					$myShowDir .= "<br>"._MD_XS_SHOWHITS." ".$hitCount."<p>&nbsp;</p></td>\n";
				} else {					
					$myShowDir .= "<p>&nbsp;</p></td>\n";
				}
		   } else {		   		
		   		$myShowDir .= "<p>&nbsp;</p></td>\n";
		   }
		   $i=$i+1;
         }

      }

          $myShowDir .=  "\n</table>\n<br>\n";
		  return $myShowDir;
}

///// Show Slide
function showSlide($slidefile) {

    global $gallery_root, $gallery_address, $currentdir, $file, $pictwidth, $pictheight, $xoopsModuleConfig, $allow_fullsizeview;
	$myShowSlide = "";
    

    $slide = '';


    
	
	if ($slidefile) {
		$slide = $slidefile;

    
	} else {
		if ($dir_content = opendir($gallery_root.$currentdir)) {
        while ( false !== ($img = readdir($dir_content)) ) {
            if ( is_file($gallery_root.$currentdir.$img) && eregi(".*(\.jpg|\.gif|\.png|\.jpeg)", $img))
                    $imgfiles[] = $img;
        	}
    	}
		
		$arraysize = count($imgfiles);
		
		for ($i=0; $i < $arraysize; $i++)
    {
        if($currentdir.'/'.$imgfiles[$i] == $slidefile)
        {
            $slide = $imgfiles[$i];
        }
    }
		$slide = $currentdir.$slide;
	}
	
	if($allow_fullsizeview) {
	//$myShowSlide .= '<div class="image"><a href="'.$gallery_address.'/'.$slide.'" title="'._MD_XS_FPREVIEW.'" target="_new"><img src="./include/img.php?file='.getModuleOptionXs('gallery_address').'/'.$slide.'&thumb=2"></a>
	$myShowSlide .= '<div class="image"><a href="include/img.php?file='.getModuleOptionXs('gallery_address').'/'.$slide.'&thumb=3"'._MD_XS_FPREVIEW.'" target="_new"><img src="./include/img.php?file='.getModuleOptionXs('gallery_address').'/'.$slide.'&thumb=2"></a>
        </div>
        <br/>
        <div class="imgdata"><br/>'."\n";
	} else {
	$myShowSlide .= '<div class="image"><img src="./include/img.php?file='.getModuleOptionXs('gallery_address').'/'.$slide.'&thumb=2">
        </div>
        <br/>
        <div class="imgdata"><br/>'."\n";
	}

///////////// This is the Exif section
$exif = exif_read_data($gallery_root.'/'.$slide, 0, true);
                $myShowSlide .= "<ul>\n";
                // get file name
                if ($exif['FILE']['FileName'] == null){
				$myShowSlide .= ''."\n";
                                }else{
                $myShowSlide .= "<li>"._MD_XS_NAME.": <b>" . $exif['FILE']['FileName'] . "</b></li>\n";
                                }
				// get file size
				if ($exif['FILE']['FileSize'] == null){
				$myShowSlide .= ''."\n";
				}else{
                $myShowSlide .= "<li>"._MD_XS_FILESIZE.": " . floor($exif['FILE']['FileSize']/10.24)/100 . " kbs\n";
				}
                // get image dimensions
				if ($exif['COMPUTED']['Width'] == null || $exif['COMPUTED']['Height'] == null){
				$myShowSlide .= ''."\n";
				}else{
                $myShowSlide .= "<li>"._MD_XS_DIMENSIONS.": " . $exif['COMPUTED']['Width'] . " x " . $exif['COMPUTED']['Height'] . " </li>\n";
				}
				// get timestamp
				if($exif['EXIF']['DateTimeOriginal'] == null){
				$myShowSlide .= ''."\n";
				}else{
                $myShowSlide .= "<li>"._MD_XS_TIMESTAMP.": "  . $exif['EXIF']['DateTimeOriginal'] . "</li>\n";
				}
				// get exposure
				if($exif['EXIF']['ExposureTime'] == null){
				$myShowSlide .= ''."\n";
				}else{
                $myShowSlide .= "<li>"._MD_XS_EXPOSURETIME.": "  . $exif['EXIF']['ExposureTime'] . ""._MD_XS_EXPOSURETIMELANG." </li>\n";
				// get Aperture
				if($exif['EXIF']['ApertureValue'] == null){
				$myShowSlide .= ''."\n";
				}else{
                $myShowSlide .= "<li>"._MD_XS_APERTURE.": "  . $exif['EXIF']['ApertureValue'] . "</li>\n";
				}
				// get Flash
				if($exif['EXIF']['Flash'] == null){
				$myShowSlide .= ''."\n";
				}else{
                $myShowSlide .= "<li>"._MD_XS_FlASH.": "  . $exif['EXIF']['Flash'] . "</li>\n";
				}
				// get Focal Length
				if($exif['EXIF']['FocalLength'] == null){
				$myShowSlide .= ''."\n";
				}else{
                $myShowSlide .= "<li>"._MD_XS_FOCAL.": "  . $exif['EXIF']['FocalLength'] . "</li>\n";
				}
				// get Digital Zoom
				if($exif['EXIF']['DigitalZoomRatio'] == null){
				$myShowSlide .= ''."\n";
				}else{
                $myShowSlide .= "<li>"._MD_XS_DIGIZOOM.": "  . $exif['EXIF']['DigitalZoomRatio'] . "</li>\n";
				}
				// get ISO Speed
				if($exif['EXIF']['ExposureIndex'] == null){
				$myShowSlide .= ''."\n";
				}else{
                $myShowSlide .= "<li>"._MD_XS_ISO.": "  . $exif['EXIF']['ExposureIndex'] . "</li>\n";
				}
				// get White Balance
				if($exif['EXIF']['WhiteBalance'] == null){
				$myShowSlide .= ''."\n";
				}else{
                $myShowSlide .= "<li>"._MD_XS_WHITEBLNC.": "  . $exif['EXIF']['WhiteBalance'] . "</li>\n";
				}
                                // get Camera Make
				if($exif['IFD0']['Make'] == null){
				$myShowSlide .= ''."\n";
				}else{
                $myShowSlide .= "<li>"._MD_XS_CAMERAMAKE.": "  . $exif['IFD0']['Make'] . "</li>\n";
				}
                                // get Camera Model
				if($exif['IFD0']['Model'] == null){
				$myShowSlide .= ''."\n";
				}else{
                $myShowSlide .= "<li>"._MD_XS_CAMERAMODEL.": "  . $exif['IFD0']['Model'] . "</li>\n";
				}
				}
//////////end exif
				$myShowSlide .= '</ul></div>'."\n";
				
				return $myShowSlide;

}

//// Displaying thumbs
function showThumbs() {

    global $allow_fullsizeview, $gallery_root, $gallery_address, $currentdir, $imgNum, $dir, $file, $thumbwidth, $thumbheight, $pictwidth, $pictheight, $images_per_page, $thumbnail_cols, $xoopsModuleConfig, $db;
	$myShowThumbs = "";
	$gallery_rootSt = $gallery_root;
	
	if ( substr ( $gallery_rootSt, -1 ) != '/' ) $gallery_rootSt .= '/'; // Add a trailing slash
    if ($dir_content = opendir($gallery_rootSt.$currentdir)) {		
        while ( false !== ($file = readdir($dir_content)) ) {
            if ( is_file($gallery_rootSt.$currentdir.$file) ) {
                if(eregi(".*(\.jpg|\.gif|\.png|\.jpeg)", $file)) {					
                    $imgfiles[] = $file;
				}
			}
        }
    }

    if(isset($imgfiles))
    {
		$dirTitleName = pathinfo($currentdir);
		$currStat = 1;
		$sqlCheck = "SELECT coll_hits FROM ".$db->prefix('xsgal_collection')." WHERE coll_name='".$dirTitleName[basename]."'";		
		
		$result = $db->query($sqlCheck);
		
		if (list($retStats) = $db->fetchRow($result)) {			
			if ($retStats > 0) {
				$currStat = $retStats;
				$retStats++;
				$sqlInsert = "UPDATE ".$db->prefix('xsgal_collection')." SET coll_hits='".$retStats."' WHERE coll_name='".$dirTitleName[basename]."' LIMIT 1";
				$result2 = $db->queryF($sqlInsert);				
			} else {
				$retStats++;
				$currStat = $retStats;
				$sqlInsert = "UPDATE ".$db->prefix('xsgal_collection')." SET coll_hits='".$retStats."' WHERE coll_name='".$dirTitleName[basename]."' LIMIT 1";
				$result2 = $db->queryF($sqlInsert); 
			}			
		} else {
			$retStats = $currStat;
			$sqlInsert = "INSERT INTO ".$db->prefix('xsgal_collection')."(coll_hits, coll_name) VALUES ('".$retStats."', '".$dirTitleName[basename]."')";
			$result2 = $db->queryF($sqlInsert); 
		}
		
		$myShowThumbs .= "<div class=\"image\"><div class=\"title\">".$dirTitleName[basename]."\n";
        sort($imgfiles);
        $currentdir = str_replace(" ","%20",$currentdir);

		$imgFilesTotal = count($imgfiles);
		$imgPages = ceil($imgFilesTotal / $images_per_page);

        $curImgNum = 0;
        $imgNum = $_GET['num'];

        if ($imgPages > 1) {
        $myShowThumbs .=  "<p />\n";
		  for ($count1 = 1; $count1 < ($imgPages + 1); $count1++) {

		    if ($imgNum == $curImgNum) {
              $myShowThumbs .= '&nbsp;<b>'.$count1.'</b>&nbsp;'."\n";
              $curImgNum = $curImgNum + $images_per_page;
            } else {
              $myShowThumbs .= '&nbsp;<a href="'.$_SERVER['PHP_SELF'].'?num='.$curImgNum.'&file='.$currentdir.$dir.'">'.$count1.'</a>&nbsp;'."\n";
              $curImgNum = $curImgNum + $images_per_page;
            }
		  }
		}

        $myShowThumbs .= "</div><p>\n";

		if ($imgNum == "") {
		  $imgNum = 0;
		}

        $myShowThumbs .= "<table border=0>\n";

		for ($count2 = $imgNum; $count2 < $imgNum + $images_per_page; $count2++) {

          if ($count2 < $imgFilesTotal) {
            $myShowThumbs .= "<tr>\n";
            for($count_row = $count2; $count_row < $count2 + $thumbnail_cols; $count_row++) {
              if (isset($imgfiles[$count_row])) {
              $myShowThumbs .= "<td>\n";
			  if ($allow_fullsizeview) {
              $myShowThumbs .= "<a href=\"include/img.php?file=".getModuleOptionXs('gallery_address').'/'.$currentdir.$imgfiles[$count_row]."&thumb=0\" class=\"linkopacity\" rel=\"lightbox[".$currentdir."]\" title=\""._MD_XS_VPREVIEW."\" id=\"<a href=include/img.php?file=".getModuleOptionXs('gallery_address')."/".$currentdir.$imgfiles[$count_row]."&thumb=3>"._MD_XS_FULLSIZED."</a></br><a href=".$_SERVER['PHP_SELF']."?file=".$currentdir.$imgfiles[$count_row].">"._MD_XS_DETAILEDINFO."</a>\"><img src=include/img.php?file=".getModuleOptionXs('gallery_address').'/'.$currentdir.$imgfiles[$count_row]."&thumb=1></a>\n";
			  } else {
			  $myShowThumbs .= "<a href=\"include/img.php?file=".getModuleOptionXs('gallery_address').'/'.$currentdir.$imgfiles[$count_row]."&thumb=0\" class=\"linkopacity\" rel=\"lightbox[".$currentdir."]\" title=\""._MD_XS_VPREVIEW."\" id=\"<a href=".$_SERVER['PHP_SELF']."?file=".$currentdir.$imgfiles[$count_row].">"._MD_XS_DETAILEDINFO."</a>\"><img src=include/img.php?file=".getModuleOptionXs('gallery_address').'/'.$currentdir.$imgfiles[$count_row]."&thumb=1></a>\n";
			  }
              $myShowThumbs .= "</td>\n";
              } else {
                continue;
              }
            }
            $myShowThumbs .= "</tr>\n";
            $count2 = $count_row - 1;
          }
        }
        $myShowThumbs .= "</table>\n";
    }
    else {
	  //echo ""._MD_XS_NOIMAGES."";
	}
    $myShowThumbs .= "</div>\n";
	
	return $myShowThumbs;
}


// Validates file variable
function validateFile() {

    global $excluded_folders, $file;
	
    $file = $_GET['file'];

    // validate dir
    if ( strstr($file, '..') || strstr($file, '%2e%2e') )
        return false;

    foreach ($excluded_folders as $folder)
    {
        if ( strstr($file, $folder) )
        return false;
    }
	
	
    setCurrentdir();
    return true;
}

function createNavigation()
{
    global $currentdir, $file;
	$myCreateNavigation = "";
	
    if ($currentdir == './')
    $currentdir = '';
    $nav = split('/', $currentdir);
    array_pop($nav);
    $path = pathinfo($file);

    $myCreateNavigation .= "<div class=\"xstopnav\">"._MD_XS_FOLDERS.": &raquo; <a href=\"".$_SERVER['PHP_SELF']."\">"._MD_XS_MAIN."</a>\n";
    foreach ($nav as $n)
    {
        $current .= $n.'/';
        $myCreateNavigation .=  ' &raquo; <a href="'.$_SERVER['PHP_SELF'].'?file='.$current.'">'.$n.'</a> '."\n";;
    }
    if ($path['extension']!='')
        $myCreateNavigation .=  ' &raquo; <a href="'.$_SERVER['PHP_SELF'].'?file='.$current.$path['basename'].'">'.$path['basename'].'</a>'."\n";
    	$myCreateNavigation .=  '</div>'."\n";
	
	return $myCreateNavigation;
}

function getModuleOptionXs($option, $repmodule='xsgal')
{
	global $xoopsModuleConfig, $xoopsModule;
	static $tbloptions= Array();
	if(is_array($tbloptions) && array_key_exists($option,$tbloptions)) {
		return $tbloptions[$option];
	}

	$retval=false;
	if (isset($xoopsModuleConfig) && (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $repmodule && $xoopsModule->getVar('isactive'))) {
		if(isset($xoopsModuleConfig[$option])) {
			$retval= $xoopsModuleConfig[$option];
		}
	} else {
		$module_handler =& xoops_gethandler('module');
		$module =& $module_handler->getByDirname($repmodule);
		$config_handler =& xoops_gethandler('config');
		if ($module) {
		    $moduleConfig =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
	    	if(isset($moduleConfig[$option])) {
	    		$retval= $moduleConfig[$option];
	    	}
		}
	}
	$tbloptions[$option]=$retval;
	return $retval;
}

function searchPaths($search, $sub, $fileList) {
		
	if ($sub) {
		$mySearch = $search.'/'.$sub;
	} else {
		$mySearch = $search;
	}
	
	$handle = opendir($mySearch);
	while (false !== ($file = readdir($handle))) {
		if ($file != "." && $file != "..") {
			if (is_dir($mySearch.'/'.$file)) {
				$fileList = searchPaths($search, $file, $fileList);
			}
			if(eregi(".*(\.jpg|\.gif|\.png|\.jpeg)", $file)) {				
				array_push($fileList, $mySearch.'/'.$file);				
			}	 		
		}			
	}

	sort($fileList);
	for($n = 0; $n < count($fileList); $n++) {
	}
	
	return $fileList;
}

function showXSFooter() {

//echo "<div class=\"xsfooter\"><a href=\"http://www.arabxoops.com\" target=\"_blank\">XOOPS Simple Gallery &copy; 2007</div>";

}

?>
