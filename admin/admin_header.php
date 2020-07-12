<?php
//  ------------------------------------------------------------------------ //
//                xsGallery - XOOPS Simple Gallery Module                    //
//                            Versi�n 1.3                                    //
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

include "../../../mainfile.php";
include_once XOOPS_ROOT_PATH."/class/xoopsmodule.php";
include XOOPS_ROOT_PATH."/include/cp_functions.php";
if ( $xoopsUser ) {
    $xoopsModule = XoopsModule::getByDirname("xsgal");
    if ( !$xoopsUser->isAdmin($xoopsModule->mid()) ) {
        redirect_header(XOOPS_URL."/",3,_NOPERM);
        exit();
    }
} else {
    redirect_header(XOOPS_URL."/",3,_NOPERM);
    exit();
}
if ( file_exists("../language/".$xoopsConfig['language']."/main.php") ) {
	include "../language/".$xoopsConfig['language']."/modinfo.php";
    include "../language/".$xoopsConfig['language']."/main.php";
} else {
	include "../language/english/modinfo.php";
    include "../language/english/main.php";
}

include_once "../include/functions.php";
?>