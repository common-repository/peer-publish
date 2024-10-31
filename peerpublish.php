<?php
/*
Plugin Name: Peer Publish
Description: Manage your Content Distributor Machine settings here by adding/editing the websites to export.
Version: 1.0
Author: WebGarh Solutions 
Author URI: http://www.cwebconsultants.com/ 
Text Domain: peer_publish
*/
if ( ! defined( 'WPINC' ) ) {
	die;
}

/* Plugin Name */
$cwebPluginName="Peer Publish";

/* Use Domain as the folder name */
$PluginTextDomain="peer_publish";


/**
 * The code that runs during plugin activation.
*/
function PPNM_activate_this_plugin_distributor_machine() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/classes/activate-class-distributor-machine.php';
	PPNM_Plugin_Activator_distributor_machine::activate();
}
/**
 * The code that runs during plugin deactivation.
*/
function PPNM_deactivate_this_plugin_distributor_machine() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/classes/deactive-class-distributor-machine.php';
	PPNM_Plugin_Deactivator_distributor_machine::deactivate();
}

/* Register Hooks For Start And Deactivate */
register_activation_hook( __FILE__, 'PPNM_activate_this_plugin_distributor_machine' );
register_deactivation_hook( __FILE__, 'PPNM_deactivate_this_plugin_distributor_machine' );

/**
 * The core plugin class that is used to define internationalization,
*/
require plugin_dir_path( __FILE__ ) . 'includes/classes/classCwebdistributorMachine.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function PPNM_distributor_machine() { 
	$plugin = new PPNM_ClassdistributorMachine();
	$plugin->run();
}
PPNM_distributor_machine(); 

/* Constant */
define('PPNM_PLUGIN_FS_PATH_MACHINE', plugin_dir_path(__FILE__) );
define('PPNM_PLUGIN_WS_PATH_MACHINE', plugin_dir_url(__FILE__) );
define('PPNM_FS_PATH_MACHINE', plugin_dir_path(__FILE__) );
define('PPNM_WS_PATH_MACHINE', plugin_dir_url(__FILE__) );
define( 'PPNM_LICENSE', true );
/*
 * Include Custom Feild Files
 */

//Declares Common Fucntion File 
require plugin_dir_path( __FILE__ ) . 'includes/function/functions.php';
