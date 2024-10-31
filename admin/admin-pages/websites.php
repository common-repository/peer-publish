

<?php
/*
Plugin Name: Peer Publish
Description: Manage your Content Distributor Machine settings here by adding/editing the websites to export.
Version: 1.0
Author: WebGarh Solutions 
Author URI: http://www.cwebconsultants.com/
Text Domain: peer_publish
*/

global $wpdb;

$listwebsitesinternal= $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `".$wpdb->prefix."subwebsites` WHERE network =%d","internal" ) );
$perma_delete='';
if(isset($_GET['act'])){
$perma_delete=sanitize_text_field($_GET['act']);
}
if($perma_delete=='perma_delete'):
    $id=sanitize_text_field($_GET['id']);
	$wpdb->query("DELETE FROM `".$wpdb->prefix."subwebsites` WHERE id = '$id'");
    PPNM_foreceRedirect(admin_url('admin.php?page=websites'));
endif;
 
?>
<div class="wrap">

<!--internal table -->

<table class="wp-list-table widefat fixed striped posts" id="internal_data">
        <thead>
                <tr>
                    <td class="manage-column column-cb check-column" id="cb"></td>
                    <th  class="manage-column column-title" id="title" scope="col"><span><?php echo __('Website Name','peer_publish');?></th> 
                    <th  class="manage-column column-title" id="title" scope="col"><span><?php echo __('Website Url','peer_publish');?></th>
                    <th class="manage-column column-country" id="country" scope="col"><?php echo __('Website Username','peer_publish');?></th>
                    <th class="manage-column column-country" id="country" scope="col"><?php echo __('Website Password','peer_publish');?></th>
                </tr>
        </thead>

    <tbody id="the-list">
        <?php
            if(!empty($listwebsitesinternal)):
                foreach($listwebsitesinternal as $website):
                   
            ?>
                <tr class="iedit author-self status-publish hentry" id="post-2157">
                    <th class="check-column" scope="row"><input type="checkbox" name="website)id[]" value="<?php echo esc_html($website->id);?>"></th>
                    <td data-colname="City Name" class="title column-title has-row-actions column-primary page-title">
                    <?php echo esc_html($website->sitename);?>
                <div class="row-actions custom-action-row">
                        <span class="edit"><a title="<?php echo __('Edit this item','peer_publish');?>" href="admin.php?page=newwebsite&act=edit&id=<?php echo esc_html($website->id);?>&network=internal"><?php echo __('Edit','peer_publish');?></a> | </span>
                        <span class="trash"><a href="admin.php?page=websites&act=perma_delete&id=<?php echo esc_html($website->id);?>" onclick="return confirm(`Are you sure? You want to delete this item`);" class="submitdelete"><?php echo __('Delete','peer_publish');?></a></span>
                 </div>
                </td>
                    <td data-colname="Latitude"><?php echo esc_html($website->siteurl);?></td>
                    <td data-colname="Latitude"><?php echo esc_html($website->dbusername);?></td>
                    <td data-colname="Latitude"><?php echo esc_html($website->dbpassword); ?></td>
                    
                </tr>
        <?php   endforeach; 
                else:?>
            <tr class="iedit author- status-publish hentry">
            <td></td><td class="check-column text-center" scope="row" colspan='7'><?php echo __('Sorry No Record Found..!','peer_publish');?></td>
            </tr>
        <?php endif;?>
        </tbody>
                <tfoot>
                    <td class="manage-column column-cb check-column" id="cb"></td>
                    <th  class="manage-column column-title" id="title" scope="col"><span><?php echo __('Website Name','peer_publish');?></th> 
                    <th  class="manage-column column-title" id="title" scope="col"><span><?php echo __('Website Url','peer_publish');?></th>
                    <th class="manage-column column-country" id="country" scope="col"><?php echo __('Website Username','peer_publish');?></th>
                    <th class="manage-column column-country" id="country" scope="col"><?php echo __('Password','peer_publish');?></th>
                </tfoot>
            </table>

<!--end table -->

	</form>
     </div>
     
    <div style="clear:both"></div>
