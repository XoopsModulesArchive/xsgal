# phpMyAdmin MySQL-Dump
# version 2.4.0
# http://www.phpmyadmin.net/ (download page)
#
# Server: localhost
# Date: 04-05-2003 00:28:51
# Version: 3.23.54
# Version PHP: 4.3.0
# Version Xoops: Xoops 2.0
# --------------------------------------------------------

#
# Structure table for `xsgal_collection`
#

CREATE TABLE `xsgal_collection` (
  `coll_id` int(11) unsigned NOT NULL auto_increment,
  `coll_name` varchar(100) NOT NULL default '',
  `coll_hits` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`coll_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


