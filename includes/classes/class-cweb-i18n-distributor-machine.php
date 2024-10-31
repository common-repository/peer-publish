<?php
/*
Plugin Name: Peer Publish
Description: Manage your Content Distributor Machine settings here by adding/editing the websites to export.
Version: 1.0
Author: WebGarh Solutions 
Author URI: http://www.cwebconsultants.com/
Text Domain: peer_publish
*/
class PPNM_i18n_news_Machine {

	/**
	 * The domain specified for this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $domain    The domain identifier for this plugin.
	 */
	private $domain;

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain_news_machine() {
		//load_plugin_textdomain($this->domain,false,dirname(dirname(dirname(plugin_basename( __FILE__ ) ))) . '/languages/');
	}

	/**
	 * Set the domain equal to that of the specified domain.
	 *
	 * @since    1.0.0
	 * @param    string    $domain    The domain that represents the locale of this plugin.
	 */
	public function set_domain_news_machine( $domain ) { 
		$this->domain = $domain;
	}
}
