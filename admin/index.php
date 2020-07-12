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

include_once "admin_header.php";

$op = "options";
$id = "";

if (isset($HTTP_GET_VARS)) {
    $op = empty($_GET['op'])? "options":$_GET['op'];
	$id = empty($_GET['id_img'])? 0:intval($_GET['id_img']);
}

switch ($op) {
	case "options":
		listOptions();
		break;
	case "liststats":
		listStats();
		break;
	case "resetstats":
		resetStats($id);
		break;
	case "delstat":
		deletStats($id);
		break;
	default:
		listOptions();
		break;
}

function listOptions() {
	global $xoopsModule;
    xoops_cp_header();
    echo  "<h4 style='text-align:left;'>"._MI_XSGAL_NAME."</h4>";
    OpenTable();
	echo "<br>";
	echo " - <a href='".XOOPS_URL."/modules/xsgal/admin/index.php?op=liststats'>"._XD_XSSTATSMENU."</a>\n";
    echo "<p>";
    echo " - <a href='".XOOPS_URL."/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod=".$xoopsModule->getVar('mid')."'>"._MI_XSGAL_GENERALCONF."</a>\n";

    CloseTable();
    xoops_cp_footer();
    exit();
}

function listStats() {
	global $db, $op, $id;
	$sql = "SELECT coll_id, coll_name, coll_hits FROM ".$db->prefix('xsgal_collection')." ORDER BY coll_hits DESC";
	xoops_cp_header();
	if (!($result = $db->query($sql))) {
		xoops_cp_header();
    	echo "Could not retrieve statistics";
     	xoops_cp_footer();
	} else {
		echo "<h4 style='text-align:left;'>"._XD_XSSTATSMENU."</h4>";
		echo "<table width='100%' border='1' cellpadding='4' cellspacing='1'>";
		echo "<tr class='bg3'><th>ID</th><th>Collection</th><th>Hits</th><th>Action</th></tr>";
		while(list($id, $name, $stat) = $db->fetchRow($result)) {
			echo "<tr class='bg1'>";
			echo "<td align='left'>".$id."</td>";
			echo "<td align='left'>".$name."</td>";
			echo "<td align='left'>".$stat."</td>";
        	echo "<td align='right'><a href='index.php?op=resetstats&amp;id_img=".$id."'>" ._XD_RESET."</a> | <a href='index.php?op=delstat&amp;id_img=".$id."'>"._XD_DELETE."</a></td>";
			echo "</tr>";
		}
		echo "</table>";
	}
	xoops_cp_footer();
}

function resetStats($statID) {
	global $db;
	$sql = "UPDATE ".$db->prefix('xsgal_collection')." SET coll_hits='0' WHERE coll_id='".$statID."' LIMIT 1";
	//xoops_cp_header();
	if (!$db->queryF($sql)) {
    	xoops_cp_header();
    	echo "Could not reset statistic";
     	xoops_cp_footer();
    } else {
		redirect_header("index.php?op=liststats",1,_XD_XSRESSUCCESS);
	}
	//xoops_cp_footer();
}

function deletStats($statID) {
	global $db;
	$sql = "DELETE FROM ".$db->prefix('xsgal_collection')." WHERE coll_id='".$statID."' LIMIT 1";
	xoops_cp_header();
	if (!$db->queryF($sql)) {
    	xoops_cp_header();
    	echo "Could not delete statistic";
     	xoops_cp_footer();
    } else {
		redirect_header("index.php?op=liststats",1,_XD_XSDELSUCCESS);
	}
	xoops_cp_footer();
	exit();
}

?>