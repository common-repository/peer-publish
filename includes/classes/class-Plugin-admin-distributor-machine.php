<?php
/*
Plugin Name: Peer Publish
Description: Manage your Content Distributor Machine settings here by adding/editing the websites to export.
Version: 1.0
Author: WebGarh Solutions 
Author URI: http://www.cwebconsultants.com/
Text Domain: peer_publish
*/
class PPNM_Admin_News_Machine {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_action('admin_menu', array(&$this, 'register_my_custom_menu_page_news_machine'));               

	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
		public function enqueue_styles_news_machine() {
			/**
			 * This function is provided for demonstration purposes only.
			 *
			 * An instance of this class should be passed to the run() function
			 * defined in Plugin_Name_Loader as all of the hooks are defined
			 * in that particular class.
			 *
			 * The Plugin_Name_Loader will then create the relationship
			 * between the defined hooks and the functions defined in this
			 * class.
			 */

                 wp_enqueue_style( 'dataTablesNewsMachineCss', plugin_dir_url(dirname(dirname(__FILE__))) . 'admin/css/datatables.min.css', array(), $this->version, 'all' );
		}

		/**
		* Register the JavaScript for the dashboard.
		*
		* @since    1.0.0
		*/
		
      

	   public function enqueue_scripts_news_machine() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */			
       
           wp_enqueue_script( 'admin_custom_js', plugin_dir_url(dirname(dirname(__FILE__))) . 'admin/js/custom_jquery.js', array( 'jquery' ), $this->version, true );
           
           wp_enqueue_script( 'admin_dtataTableJs_news_machine', plugin_dir_url(dirname(dirname(__FILE__))) . 'admin/js/datatables.min.js', array( 'jquery' ), $this->version, true );  
       }

		/** Menu Function **/
        function register_my_custom_menu_page_news_machine() {
            global $submenu;
		    global $PluginTextDomain;
		    global $cwebPluginName;
		    add_menu_page(__($cwebPluginName,$PluginTextDomain), __('Peer Publish',$PluginTextDomain), 'read', 'newssetting', array(&$this, 'manage_news_websites'));
          add_submenu_page('newssetting', __('Details',$PluginTextDomain), __('Websites',$PluginTextDomain), 'read', 'websites', array(&$this, 'manage_news_websites'));
            add_submenu_page('newssetting', __('Add New Website','newssetting'), __('Add New Website','peer_publish'), 'read', 'newwebsite', array(&$this, 'add_new_website'));
            add_submenu_page('newssetting', __('About Us','newssetting'), __('About Us','peer_publish'), 'read', 'aboutus', array(&$this, 'news_setting_page'));
        }
        
      function news_setting_page() {
            global $PluginTextDomain;
            if (!current_user_can('read')) {
                wp_die(__('You do not have sufficient permissions to access this page.','peer_publish'));
            } else {
               $this->lets_review_admin_head();
                include(PPNM_PLUGIN_FS_PATH_MACHINE . 'admin/admin-pages/about_info.php');
                $this->lets_review_admin_footer();
            }   
        }
        
       function manage_news_websites() {
            global $PluginTextDomain;
            if (!current_user_can('read')) {
                wp_die(__('You do not have sufficient permissions to access this page.','peer_publish'));
            } else {
            	 $this->lets_review_admin_head();
                include(PPNM_PLUGIN_FS_PATH_MACHINE . 'admin/admin-pages/websites.php');
                  $this->lets_review_admin_footer();

            }   
        }
        
        function add_new_website() {
            global $PluginTextDomain;
            if (!current_user_can('read')) {
                wp_die(__('You do not have sufficient permissions to access this page.','peer_publish'));
            } else {
 $this->lets_review_admin_head();
                include(PPNM_PLUGIN_FS_PATH_MACHINE . 'admin/admin-pages/newwebsite.php');
                $this->lets_review_admin_footer();
            }   
        }



        public function lets_review_admin_head() {
	?>
		<div class="wrap about-wrap newsmachine_menu">
        <h1><?php _e('Peer Machine Setting');?></h1>
        <div class="about-text">Manage your news machine settings here by adding/editing the websites to export to...</div>
                <?php $page_current=sanitize_text_field($_GET["page"]);?>
            <h2 class="nav-tab-wrapper ">
             <a class='nav-tab <?php echo $page_current == "newssetting" ? "nav-tab-active" : " ";?>' href="?page=newssetting"><?php echo __('Manage Websites','peer_publish');?></a>
             <a class='nav-tab <?php echo $page_current == "newwebsite" ? "nav-tab-active" : " ";?>' href="?page=newwebsite"><?php echo __('Add New Website','peer_publish');?></a>
                <a class='nav-tab <?php echo $page_current == "aboutus" ? "nav-tab-active" : " ";?>' href="?page=aboutus"><?php echo __('About Us','peer_publish');?></a>

               <!-- -->
            </h2>
         <style type="text/css">
         .toplevel_page_newssetting ul.wp-submenu.wp-submenu-wrap{
         	display: none;
         }
         </style>
            <?php 
        }
            

	/**
	 * Admin Page Footer
	 *
	 * @since    1.0.0
	 */

			public function lets_review_admin_footer() {
			?>
			</div>
			<?php
			}
        
    }
