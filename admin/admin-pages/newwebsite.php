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
$act=(isset($_REQUEST['act']))?sanitize_text_field($_REQUEST['act']):'list';
if(isset($_POST['save_internal'])){
$save_internal=sanitize_text_field($_POST['save_internal']);
}
if(isset($_POST['save_internal']) && $save_internal=='Save'){
	if(empty($_POST['sitename']) || empty($_POST['siteurl']) || empty($_POST['username']) || empty($_POST['password'])){
		$message='<span style="color:red;text-align: left;display: block;">'. __("Please fill all required fields","peer_publish") .'</span>';
	} else {	
		$table_name=$wpdb->prefix . "subwebsites";
		$wpdb->insert($table_name, array(
			"sitename" => sanitize_text_field($_POST['sitename']),
			"siteurl" => sanitize_text_field($_POST['siteurl']),
			"dbusername" => sanitize_text_field($_POST['username']),
			"dbpassword" => sanitize_text_field($_POST['password']),
			"network" => 'internal',
		));
		if ($wpdb->insert_id) {
			$message='<span style="color:green;text-align: left;display: block;">'. __("Data has been added successfully","peer_publish") .'</span>';
		} else {
			$message='<span style="color:red;text-align: left;display: block;">'. __("Data insert fail. Please try again","peer_publish") .'</span>';
		}		
	}
}

if(isset($_POST['update_internal']) && $_POST['update_internal']=='Update'){
	if(empty($_POST['sitename']) || empty($_POST['siteurl']) || empty($_POST['username']) || empty($_POST['password'])){
		$message='<span style="color:red;text-align: left;display: block;">'. __("Please fill all required fields","peer_publish") .'</span>';
	} else {
		$table_name=$wpdb->prefix . "subwebsites";
		$wpdb->update($table_name, array(
			"sitename" => sanitize_text_field($_POST['sitename']),
			"siteurl" => sanitize_text_field($_POST['siteurl']),
			"dbusername" => sanitize_text_field($_POST['username']),
			"dbpassword" => sanitize_text_field($_POST['password']),
			), array('id'=>sanitize_text_field($_GET['id']))
		);

		$message='<span style="color:green;">'. __("Data has been successfully updated ","peer_publish") .'</span>';
	}		
}


if(isset($_POST['cancel']) && sanitize_text_field($_POST['cancel'])=='Cancel'){
	PPNM_foreceRedirect(admin_url('admin.php?page=websites') );
}	

if($act!='edit'){	
?>
<div class="wrap">
	

	<form method="post" action="" id="internal_form" style="float: left; width: 55%;">
	<table class="form-table">
		<tr>
			<th><label for="myplugin_new_field"><?php echo __('Website Name','peer_publish');?><span class="_req"> *</span></label></th>
			<td><input type="text" style="width:80%;line-height: 24px;" required id="sitename" value=""  name="sitename" placeholder="<?php echo __('Enter Website Name','peer_publish');?>"></td>
		</tr>
		<tr>
			<th><label for="myplugin_new_field"><?php echo __('Website Url','peer_publish');?><span class="_req"> *</span></label></th>
			<td><input type="text" style="width:80%;line-height: 24px;" required id="siteurl" value=""  name="siteurl" placeholder="<?php echo __('Website Url','peer_publish');?>"></td>
		</tr>
		<tr>
			<th><label for="myplugin_new_field"><?php echo __('Website Username','peer_publish');?><span class="_req"> *</span></label></th>
			<td><input type="text" style="width:80%;line-height: 24px;" required id="username" value=""  name="username" placeholder="<?php echo __('Username','peer_publish');?>"></td>
		</tr>
		<tr>
			<th><label for="myplugin_new_field"><?php echo __('Website Password','peer_publish');?><span class="_req"> *</span></label></th>
			<td><input type="text" style="width:80%;line-height: 24px;" required id="password" value=""  name="password" placeholder="<?php echo __('Password','peer_publish');?>"></td>
		</tr>
		<tr>
			<td><input type="submit"  id="save" value="Save"  name="save_internal"></td>
		</tr>
	</table>
	</form>
	<div class="add_site_info" style="float: right; width: 38%;background: #ddd; padding: 0 35px 35px;">
<h4>HOW TO ADD A WEBSITE :-</h4>
<ul>
<li><strong>If your wordpress version is above 5.6, open following URL on your website that is,</strong> https://www.example.com/wp-admin/authorize-application.php</li>
<li>Enter "New Application Password Name" in field.</li>
<li>Then, Click on "Yes, I approve of this connection" button.</li>
<li>Your New password is generated.</li>
<li>That you can copy and add on master website to transfer posts.</li>
</ul>
<p style="text-align: center;">OR</p>
<p>To whatever website where you to want to export the posts too. Please do the followings :-</p>
<ul>
<li>Please install The <a href="https://wordpress.org/plugins/application-passwords/" target="_blank">"Application Passwords"</a> plugin on the website & Activate it. </li>
<li>Go to "Your Profile" section, and create application password.</li>
<li>Enter the "Username" and "Password" and website link in these fields.</li>
</ul>
</div>
</div>
<div style="clear:both"></div>
<?php } if($act =='edit'){
	if(!empty($_GET['id'])){
		$id=sanitize_text_field($_GET['id']);
       $website_detail = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `".$wpdb->prefix."subwebsites` WHERE ID = %d", $id ) );
	}
?>

	<div class="wrap">
	<?php 
		 $network=sanitize_text_field($_GET['network']);
     if($network=='internal'){ ?>
     	<form method="post" action="" style="float: left; width: 55%;">
			
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="myplugin_new_field"><?php echo __('Website Name','peer_publish');?><span class="_req"> *</span></label></th>
						<td><input type="text" style="width:80%;line-height: 24px;" required id="sitename" value="<?php echo esc_html($website_detail[0]->sitename);?>"  name="sitename" placeholder="<?php echo __('Enter Website Name','newssetting');?>"></td>
					</tr>
					<tr>
						<th><label for="myplugin_new_field"><?php echo __('Website Url','peer_publish');?><span class="_req"> *</span></label></th>
						<td><input type="text" style="width:80%;line-height: 24px;" required id="siteurl" value="<?php echo esc_html($website_detail[0]->siteurl);?>"  name="siteurl" placeholder="<?php echo __('Website Url','peer_publish');?>"></td>
					</tr>
					<tr>
						<th><label for="myplugin_new_field"><?php echo __('Website Username','peer_publish');?><span class="_req"> *</span></label></th>
						<td><input type="text" style="width:80%;line-height: 24px;" required id="dbusername" value="<?php echo esc_html($website_detail[0]->dbusername);?>" name="username" placeholder="<?php echo __('Database Username','peer_publish');?>"></td>
					</tr>
					<tr>
						<th><label for="myplugin_new_field"><?php echo __('Website Password','peer_publish');?><span class="_req"> *</span></label></th>
						<td><input type="text" style="width:80%;line-height: 24px;" required id="dbpassword" value="<?php echo esc_html($website_detail[0]->dbpassword);?>" name="password" placeholder="<?php echo __('Database Password','peer_publish');?>"></td>
					</tr>
					<tr>
						<td><input type="submit"  id="update" value="Update"  name="update_internal"><input type="submit"  id="cancel" value="Cancel"  name="cancel"></td>
					</tr>
				</tbody>
			</table>
		</form>
		<?php } ?>
		<div class="add_site_info" style="float: right; width: 38%;background: #ddd; padding: 0 35px 35px;">
<h4>HOW TO ADD A WEBSITE :-</h4>
<p>To whatever website where you to want to export the posts too. Please do the followings :-</p>
<ul>
<li>Please install The <a href="https://wordpress.org/plugins/application-passwords/" target="_blank">"Application Passwords"</a> plugin on the website & Activate it. </li>
<li>Go to "Your Profile" section, and create application password.</li>
<li>Enter the "Username" and "Password" and website link in these fields.</li>
</ul>
</div>
	</div>
	<div style="clear:both"></div>
<?php } ?>	        


