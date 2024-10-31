<?php
/*
Plugin Name: Peer Publish
Description: Manage your Peer Publish settings here by adding/editing the websites to export.
Version: 1.0
Author: WebGarh Solutions 
Author URI: http://www.cwebconsultants.com/
Text Domain: peer_publish
*/
class PPNM_Plugin_Activator_distributor_machine {
	/* Activate Class */
	public static function activate() {
        global $wpdb;
         $sqlQuery ="CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."subwebsites` (
                 `id` int(11) NOT NULL AUTO_INCREMENT,
                 `sitename` varchar(80) NOT NULL,
                 `siteurl` varchar(255) NOT NULL,
                 `home_path` varchar(255) NOT NULL,
                 `host` varchar(255) NOT NULL,
                 `db_name` varchar(255) NOT NULL,
                 `db_prefix` varchar(80) NOT NULL,
                 `dbusername` varchar(255) NOT NULL,
                 `dbpassword` varchar(255) NOT NULL,
                 `network` varchar(255) NOT NULL,
                 PRIMARY KEY (`id`)
               ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
		 $wpdb->query($sqlQuery);
    }

 } // end main class //
