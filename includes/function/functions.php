<?php 
/** @wordpress-plugin
 * Author:            WebGarh Solutions 
 * Author URI:        http://www.cwebconsultants.com/
 */
/* Function for session message */


/*add post filed*/

if (!function_exists('PPNM_foreceRedirect')) {
    function PPNM_foreceRedirect($filename)
    {
        if (!headers_sent())
                 header('Location: '.$filename);
        else {
            echo '<script type="text/javascript">';
            echo 'window.location.href="'.esc_html($filename).'";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url='.esc_html($filename).'" />';
            echo '</noscript>';
        }
    }   
}
add_action('admin_head', 'PPNM_my_custom_fonts');
  function PPNM_my_custom_fonts() {
    return '<style type="text/css">
           .toplevel_page_newssetting ul.wp-submenu.wp-submenu-wrap{
              display: none;
           }
           .choose_network {
              text-align: center;
              margin: 2px 0 10px 0 !important;
              }
              .add_site_info li {
             list-style-type: square;
             font-size: 16px;
             }
           </style>';
  }
// Add the custom columns to the book post type:
add_filter( 'manage_post_posts_columns', 'PPNM_set_custom_edit_post_columns_distributor_machine' );
  function PPNM_set_custom_edit_post_columns_distributor_machine($columns) {
      $columns['export_list'] = __( 'Exported', 'peer_publish' );
      return $columns;
  }
// Add the data to the custom columns for the book post type:
add_action( 'manage_post_posts_custom_column' , 'PPNM_custom_post_column_distributor_machine', 10, 2 );
  function PPNM_custom_post_column_distributor_machine( $column, $post_id ) {
      switch ( $column ) {  
          case 'export_list' :
          global $wpdb, $post;
          $post_meta_exp=get_post_meta( $post->ID, 'exported_to', true);
          $unserialize_old_exported_to_websites=unserialize($post_meta_exp);
         
          $websiteslist = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `".$wpdb->prefix."subwebsites`"));
          
          foreach ($websiteslist as $list_website) {
            if (in_array($list_website->id,$unserialize_old_exported_to_websites)) {
              echo esc_html($list_website->sitename)."<br>";
            }
          }
        break;

      }
  }


/*  start session code */

add_action('init', 'PPNM_start_session_distributor_machine', 1);
add_action('wp_logout', 'PPNM_end_session_distributor_machine');
add_action('wp_login', 'PPNM_end_session_distributor_machine');

  function PPNM_start_session_distributor_machine() {
      if( ! session_id() ) {
          session_start();
      }
  }
  function PPNM_end_session_distributor_machine() {
      session_destroy();
  }

add_action( 'add_meta_boxes', 'PPNM_meta_box_add_distributor_machine' );
  function PPNM_meta_box_add_distributor_machine(){
      $user = wp_get_current_user();
      $screen = get_current_screen();
      if ( 'add' != $screen->action ) {
          if ($user->roles[0]=='administrator' || $user->roles[0]=='editor') {
              add_meta_box( 'my-meta-box-id', 'Select Websites to Post this News', 'PPNM_meta_box_for_distributor_machine', 'post', 'side', 'default' );
          }
      }
  }

  function PPNM_meta_box_for_distributor_machine(){
      global $wpdb, $post;
      $post_meta_exp=get_post_meta( $post->ID, 'exported_to', true);
      @$unserialize_old_exported_to_websites=unserialize($post_meta_exp);
      //$query="SELECT  * FROM  `".$wpdb->prefix."subwebsites`";

      $listwebsites = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `".$wpdb->prefix."subwebsites`") );
    
      ?>
      <table style="width:100%;">
          <tr>
              <td>
                <form method="post">
                    <?php foreach ($listwebsites as $list) { 
                        if (in_array(@$list->id, @$unserialize_old_exported_to_websites)) {
                            $checked='checked';
                        } else {
                            $checked='';
                        } ?>
                        <input type="checkbox" class="check_website" name="websites[]" value="<?php echo esc_html($list->id); ?>" <?php echo esc_html($checked);?>><?php echo esc_html($list->sitename); ?>
                    <?php }
                     ?>
                     <input type="hidden" id="customajaxurl" name="customajaxurl" value="<?php echo admin_url('admin-ajax.php'); ?>">
                    <button onclick="sendtoremote(<?php echo esc_html($post->ID); ?>)" name="export" style="margin: 10px;float: right;background: #008ec2;  color: #fff;border-color: #008ec2;padding: 5PX 10px; box-shadow: none;"><?php echo __('Export','peer_publish');?></button>
                  </form>
              </td>
          </tr>
      </table>
  <?php 
  }

add_filter('use_block_editor_for_post', '__return_false', 10); 

add_action('wp_ajax_PPNM_sendtoremote_distributor_machine', 'PPNM_sendtoremote_distributor_machine');
add_action('wp_ajax_nopriv_PPNM_sendtoremote_distributor_machine', 'PPNM_sendtoremote_distributor_machine');
  function PPNM_sendtoremote_distributor_machine(){
        global $wpdb;
         $post_id=sanitize_text_field($_POST['post_id']);
        $postdata=get_post($post_id);

        $post_meta_exp=get_post_meta( $post_id, 'exported_to', true);
        $unserialize_old_exported_to_websites=unserialize($post_meta_exp);
          if (empty($unserialize_old_exported_to_websites)) {
              $unserialize_old_exported_to_websites=array();
          }
            if (!empty($_POST['websites'])) {
              $websites=filter_var_array($_POST['websites'],FILTER_SANITIZE_NUMBER_INT); 
                
                foreach ($websites as $key => $site_val) {
                    global $wpdb;
                            if(!in_array($site_val,$unserialize_old_exported_to_websites)){
                           
                             $website_info= $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `".$wpdb->prefix."subwebsites` WHERE id =%d",$site_val));
                            $str_url=$website_info[0]->siteurl;
                            $username=$website_info[0]->dbusername;
                            $password=$website_info[0]->dbpassword;
                            $content=$postdata->post_content;
                            $regex = '/src="([^"]*)"/';
                            preg_match_all( $regex, $content, $matches );
                            $matches = array_reverse($matches);
                            $newarray=array();
                            $upload_dirt = wp_upload_dir();
                        foreach ($matches[0] as $key => $content_image) {
                          $eimage=explode("uploads",$content_image);
                          $file_name = pathinfo($eimage[1], PATHINFO_FILENAME);
                          $ext = pathinfo($eimage[1], PATHINFO_EXTENSION);
                          $image_name=$file_name.'.'.$ext;
                          @$image_old_contantpath = $upload_dirt['basedir'].@$eimage[1];
                          $image_old_contantpath;
                          $file = @fopen($image_old_contantpath, 'r' );
                          $file_size = filesize($image_old_contantpath);
                          $file_data = fread( $file, $file_size );
                          $args = array(
                            'headers'     => array(
                            'Authorization' => 'Basic ' . base64_encode($username.':'.$password),
                            'accept'        => 'application/json', // The API returns JSON
                            'content-type'  => 'application/binary', // Set content type to binary
                            'Content-Disposition' => 'attachment; filename='.time().@$image_name
                            ),
                            'body'        => $file_data
                          );
                          $api_response = wp_remote_post( $str_url.'/wp-json/wp/v2/media', $args);
                          $contant_id = json_decode( $api_response['body'] );
                          $image_paths = $contant_id->guid->rendered;
                          $newarray[$content_image]=$image_paths;
                        }
                        if(!empty($newarray)) { 
                          foreach($newarray as $oldimage => $newimage){
                            $content = str_replace($oldimage, $newimage, $content);
                          }
                        }
                        $content=sanitize_text_field( htmlentities($content) );
                        $contentss=html_entity_decode($content);
                        /*feature image*/
                          $thunail_url = wp_get_attachment_url(get_post_thumbnail_id($post_id) );
                          $thunailpath=explode("uploads",$thunail_url);
                          $file_namethunailpath = pathinfo($thunailpath[1], PATHINFO_FILENAME);
                          $thunailpath_ext = pathinfo($thunailpath[1], PATHINFO_EXTENSION);
                          $thunailpath_image_name=$file_namethunailpath.'.'.$thunailpath_ext;
                          $image_old_thunailpath = $upload_dirt['basedir'].'/'.$thunailpath[1];
                          $file = @fopen( $image_old_thunailpath, 'r' );
                          $file_size = filesize( $image_old_thunailpath );
                          $file_data = fread( $file, $file_size );
                          $args = array(
                              'headers'     => array(
                                  'Authorization' => 'Basic ' . base64_encode($username.':'.$password),
                                  'accept'        => 'application/json', // The API returns JSON
                                  'content-type'  => 'application/binary', // Set content type to binary
                                  'Content-Disposition' => 'attachment; filename='.time().$thunailpath_image_name
                              ),
                              'body'        => $file_data
                              );

            $api_response = wp_remote_post( $str_url.'/wp-json/wp/v2/media', $args);
            $media_id = json_decode( $api_response['body'] );
            
            /*end features image */

             /*create tag*/
                       $tag = wp_get_post_tags($post_id);
                       $tagid= array();
                      foreach ($tag as $key => $tagvalue) {     
                        $api_response = wp_remote_post( $str_url.'/wp-json/wp/v2/tags/', array(
                          'headers' => array(
                          'Authorization' => 'Basic ' . base64_encode($username.':'.$password)
                          ),
                          'body' => array( 
                                 'description' => $tagvalue->description,
                                 'name' => $tagvalue->name, 
                                 'taxonomy' => $tagvalue->taxonomy,
                                 'slug' => $tagvalue->slug,
                                 )
                          ) );
                        $tags = json_decode( $api_response['body'] );
                           if($tags->code == 'term_exists'){
                             $tagid[] = $tags->data->term_id;
                          }else{
                              $tagid[]  =  $tags->id;
                          }
                      }  
                   
           /*end tags*/
           
             /** create category **/
    		 $category =get_the_category($post_id);
    		 $categoriessid= array();
    		 foreach ($category as $key => $categoryvalue) {
                  $api_response = wp_remote_post( $str_url.'/wp-json/wp/v2/categories/', array(
                    'headers' => array(
                    'Authorization' => 'Basic ' . base64_encode($username.':'.$password)
                  ),
      					   'body' => array( 
      					   'description' => $categoryvalue->description,
      					   'name' => $categoryvalue->name, 
      					   'taxonomy' => $categoryvalue->taxonomy,
      					   'slug' => $categoryvalue->slug,
    					   )
                       ) );
                    $categoriess = json_decode( $api_response['body'] );
                    if($categoriess->code == 'term_exists'){
                     $categoriessid[] = $categoriess->data->term_id;
                    }else{
                      $categoriessid[]  =  $categoriess->id;
                    }
    		 }
              /* end */
            /*create post*/
            

                         $api_response = wp_remote_post( $str_url.'/wp-json/wp/v2/posts/', array(
                        'headers' => array(
                        'Authorization' => 'Basic ' . base64_encode($username.':'.$password)
                        ),
                        'body' => array(
                                'title'   => $postdata->post_title,
                                'status'  => 'draft', 
                                'content' => $contentss,
                                'type' => $postdata->post_type, 
                                'comment_status' => $postdata->comment_status, 
                                'ping_status' => $postdata->ping_status, 
                                'password' => $postdata->post_password,
                                'author' => 1,
                                'tags' => $tagid,
                                'categories' => $categoriessid,
                                'post_modified' => date("Y-m-d H:i:s"),
                                'post_modified_gmt' => date("Y-m-d H:i:s"),
                                'post_name' => $postdata->post_name,
                                'featured_media' => $media_id->id,
                                'post_content_filtered' => $postdata->post_content_filtered,
                                )
                        ) );
                        $body = json_decode( $api_response['body'] );
                       
                     
                        if(!empty($body->id)){
                          if (!in_array($site_val,$unserialize_old_exported_to_websites)) { 
                            array_push($unserialize_old_exported_to_websites,$site_val);  
                          } 
                          if(!empty($unserialize_old_exported_to_websites)) {  
                            delete_post_meta($post_id,'exported_to');      
                            $export_site=serialize($unserialize_old_exported_to_websites);           
                            update_post_meta($post_id,'exported_to',$export_site);
                          }
                        }
            }
        }
        

        //$query="SELECT  * FROM  `".$wpdb->prefix."subwebsites`";
       // $listwebsites=$wpdb->get_results($query);
          $listwebsites = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `".$wpdb->prefix."subwebsites`"));
        $site_id=array();
           foreach ($listwebsites as $list_website) {
                         if (in_array($list_website->id,$unserialize_old_exported_to_websites)) {
                  $site_id[]=$list_website->sitename;      
                }
            }

                 echo $sitename = json_encode($site_id);

    }
    exit;
  }




add_filter( 'style_loader_src',  'PPNM_remove_ver_css_js_distributor_machine', 9999, 2 );
add_filter( 'script_loader_src', 'PPNM_remove_ver_css_js_distributor_machine', 9999, 2 );
function PPNM_remove_ver_css_js_distributor_machine( $src, $handle ) 
  {
      $handles_with_version = [ 'style' ]; 
      if ( strpos( $src, 'ver=' ) && ! in_array( $handle, $handles_with_version, true ) )
          $src = remove_query_arg( 'ver', $src );
      return $src;
  }





