XOOPS Simple Gallery
Version 1.1
Developed by: Mowaffak - www.arabxoops.com
Based on Saurdo Gallery - www.saurdo.com

Features: 
====================
- Very easy install.
- Don't have to move images from current folder location.
- Handles JPEG and JPG file types. Can handle GIF and PNG but the EXIF won't work for those filetypes.
- Show images in the current gallery folder alphabetically.
- Show subfolders to the gallery folder alphabetically, giving access to tree-like structure.
- Thumbs view.
- Javascript pewview with previous/next feature.
- Keyboard navigation for javascript preview (N - next, P - previous, C - close)
- Exif data that shows photographs camera settings and files size.
- Adjustable sizes for thumbnailed icons.
- Very flexible script.

Server requirments
====================
-Exif, PHP 5, Javascript, everything else is pretty standard. 
The only thing you really need to worry about is Exif. You can check out your server specs by making a PHP file with phpinfo().
-Removing Exif: Delete lines 122 - 187.  If you'd like to delete the link to that section find "<li><a href='.$_SERVER['PHP_SELF'].'?file='.$currentdir.$img.' target=_blank>Detailed information</a></li>" and delete that.
