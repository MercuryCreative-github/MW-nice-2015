<?php
/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2015 AJdG Solutions (Arnan de Gans). All Rights Reserved.
*  ADROTATE is a registered trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from it's use.
------------------------------------------------------------------------------------ */

if(!$ad_edit_id) { 
	$edit_id = $wpdb->get_var("SELECT `id` FROM `".$wpdb->prefix."adrotate` WHERE `type` = 'empty' ORDER BY `id` DESC LIMIT 1;");
	if($edit_id == 0) {
	    $wpdb->insert($wpdb->prefix."adrotate", array('title' => '', 'bannercode' => '', 'thetime' => $now, 'updated' => $now, 'author' => $current_user->user_login, 'imagetype' => 'dropdown', 'image' => '', 'link' => '', 'tracker' => 'N', 'responsive' => 'N', 'type' => 'empty', 'weight' => 6, 'sortorder' => 0, 'cbudget' => 0, 'ibudget' => 0, 'crate' => 0, 'irate' => 0, 'cities' => serialize(array()), 'countries' => serialize(array())));
	    $edit_id = $wpdb->insert_id;
	}
	$ad_edit_id = $edit_id;
}

$edit_banner = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."adrotate` WHERE `id` = '$ad_edit_id';");
$groups	= $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."adrotate_groups` WHERE `name` != '' ORDER BY `sortorder` ASC, `id` ASC;"); 
$schedules = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."adrotate_schedule` WHERE `name` != '' AND `stoptime` > $now ORDER BY `id` ASC;");
$user_list = $wpdb->get_results("SELECT `ID`, `display_name` FROM `$wpdb->users` ORDER BY `user_nicename` ASC;");
$saved_user = $wpdb->get_var("SELECT `user` FROM `".$wpdb->prefix."adrotate_linkmeta` WHERE `ad` = '$edit_banner->id' AND `group` = 0 AND `block` = 0 AND `schedule` = 0;");
$linkmeta = $wpdb->get_results("SELECT `group` FROM `".$wpdb->prefix."adrotate_linkmeta` WHERE `ad` = '$edit_banner->id' AND `block` = 0 AND `user` = 0 AND `schedule` = 0;");
$schedulemeta = $wpdb->get_results("SELECT `schedule` FROM `".$wpdb->prefix."adrotate_linkmeta` WHERE `ad` = '$edit_banner->id' AND `group` = 0 AND `block` = 0 AND `user` = 0;");

wp_enqueue_media();
wp_enqueue_script('uploader-hook', plugins_url().'/'.ADROTATE_FOLDER.'/library/uploader-hook.js', array('jquery'));

$meta_array = $schedule_array = '';
foreach($linkmeta as $meta) {
	$meta_array[] = $meta->group;
	unset($meta);
}

foreach($schedulemeta as $meta) {
	$schedule_array[] = $meta->schedule;
	unset($meta);
}

if(!is_array($meta_array)) $meta_array = array();
if(!is_array($schedule_array)) $schedule_array = array();

$smonth = date("m", $now);
$emonth = date("m", $in84days);

if($ad_edit_id) {
	if($edit_banner->type != 'empty') {
		// Errors
		if(strlen($edit_banner->bannercode) < 1 AND $edit_banner->type != 'empty') 
			echo '<div class="error"><p>'. __('The AdCode cannot be empty!', 'adrotate').'</p></div>';

		if($edit_banner->tracker == 'N' AND $saved_user > 0) 
			echo '<div class="error"><p>'. __('You\'ve set an advertiser but didn\'t enable clicktracking!', 'adrotate').'</p></div>';

		if(!preg_match("/%image%/i", $edit_banner->bannercode) AND $edit_banner->image != '') 
			echo '<div class="error"><p>'. __('You didn\'t use %image% in your AdCode but did select an image!', 'adrotate').'</p></div>';

		if(preg_match("/%image%/i", $edit_banner->bannercode) AND $edit_banner->image == '') 
			echo '<div class="error"><p>'. __('You did use %image% in your AdCode but did not select an image!', 'adrotate').'</p></div>';
		
		if((($edit_banner->imagetype != '' AND $edit_banner->image == '') OR ($edit_banner->imagetype == '' AND $edit_banner->image != ''))) 
			echo '<div class="error"><p>'. __('There is a problem saving the image specification. Please reset your image and re-save the ad!', 'adrotate').'</p></div>';
		
		if((($edit_banner->crate > 0 AND $edit_banner->cbudget < 1) OR ($edit_banner->irate > 0 AND $edit_banner->ibudget < 1))) 
			echo '<div class="error"><p>'. __('This advert has run out of budget. Add more budget to the advert or reset the rate to zero!', 'adrotate').'</p></div>';
		
		if(count($schedule_array) == 0) 
			echo '<div class="error"><p>'. __('This ad has no schedules!', 'adrotate').'</p></div>';
		
		if(!preg_match_all('/<a[^>](.*?)>/i', stripslashes(htmlspecialchars_decode($edit_banner->bannercode, ENT_QUOTES)), $things) AND $edit_banner->tracker == 'Y')
			echo '<div class="error"><p>'. __("Clicktracking is enabled but no valid link was found in the adcode!", 'adrotate').'</p></div>';

		if($edit_banner->tracker == 'N' AND $edit_banner->crate > 0)
			echo '<div class="error"><p>'. __("A Click rate was set but clicktracking is not active!", 'adrotate').'</p></div>';

		// Ad Notices
		$adstate = adrotate_evaluate_ad($edit_banner->id);
		if($edit_banner->type == 'error' AND $adstate == 'normal')
			echo '<div class="error"><p>'. __('AdRotate cannot find an error but the ad is marked erroneous, try re-saving the ad!', 'adrotate').'</p></div>';

		if($edit_banner->type == 'reject')
			echo '<div class="error"><p>'. __('This advert has been rejected by staff Please adjust the ad to conform with the requirements!', 'adrotate').'</p></div>';

		if($edit_banner->type == 'queue')
			echo '<div class="error"><p>'. __('This advert is queued and awaiting review!', 'adrotate').'</p></div>';

		if($adstate == 'expired')
			echo '<div class="error"><p>'. __('This ad is expired and currently not shown on your website!', 'adrotate').'</p></div>';

		if($adstate == 'expires2days')
			echo '<div class="updated"><p>'. __('The ad will expire in less than 2 days!', 'adrotate').'</p></div>';

		if($adstate == 'expires7days')
			echo '<div class="updated"><p>'. __('This ad will expire in less than 7 days!', 'adrotate').'</p></div>';

		if($edit_banner->type == 'disabled') 
			echo '<div class="updated"><p>'. __('This ad has been disabled and does not rotate on your site!', 'adrotate').'</p></div>';
	}
}

// Determine image field
if($edit_banner->imagetype == "field") {
	$image_field = $edit_banner->image;
	$image_dropdown = '';
} else if($edit_banner->imagetype == "dropdown") {
	$image_field = '';
	$image_dropdown = $edit_banner->image;
} else {
	$image_field = '';
	$image_dropdown = '';
}
?>

	<form method="post" action="admin.php?page=adrotate-ads">
	<?php wp_nonce_field('adrotate_save_ad','adrotate_nonce'); ?>
	<input type="hidden" name="adrotate_username" value="<?php echo $userdata->user_login;?>" />
	<input type="hidden" name="adrotate_id" value="<?php echo $edit_banner->id;?>" />
	<input type="hidden" name="adrotate_type" value="<?php echo $edit_banner->type;?>" />
	<input type="hidden" name="adrotate_link" value="<?php echo $edit_banner->link;?>" />

<?php if($edit_banner->type == 'empty') { ?>
	<h3><?php _e('New Advert', 'adrotate'); ?></h3>
<?php } else { ?> 
	<h3><?php _e('Edit Advert', 'adrotate'); ?></h3>
<?php } ?>

	<p><em><?php _e('These are required.', 'adrotate'); ?></em></p>
	<table class="widefat" style="margin-top: .5em">

		<tbody>
      	<tr>
	        <th width="15%"><?php _e('Title:', 'adrotate'); ?></th>
	        <td colspan="2">
	        	<label for="adrotate_title"><input tabindex="1" name="adrotate_title" type="text" size="80" class="search-input" value="<?php echo stripslashes($edit_banner->title);?>" autocomplete="off" /></label>
	        </td>
      	</tr>
      	<tr>
	        <th valign="top"><?php _e('AdCode:', 'adrotate'); ?></th>
	        <td>
	        	<label for="adrotate_bannercode"><textarea tabindex="2" id="adrotate_bannercode" name="adrotate_bannercode" cols="65" rows="15"><?php echo stripslashes($edit_banner->bannercode); ?></textarea></label>
	        </td>
	        <td width="40%">
		        <p><?php _e('Copy your ad tag/code in this field if you have received ready to go adverts.', 'adrotate'); ?><br /><?php _e('Advertising and affiliate networks often use these.', 'adrotate'); ?></p>
		        <p><strong><?php _e('Basic Examples:', 'adrotate'); ?></strong></p>
		        <p>1. <em><a href="#" onclick="textatcursor('adrotate_bannercode','&lt;a href=&quot;https://ajdg.solutions/&quot;&gt;Buy AdRotate Pro here!&lt;/a&gt;');return false;">&lt;a href="https://ajdg.solutions/"&gt;Buy AdRotate Pro here!&lt;/a&gt;</a></em></p>
				<p>2. <em><a href="#" onclick="textatcursor('adrotate_bannercode','&lt;a href=&quot;http://www.floatingcoconut.net&quot;&gt;&lt;img src=&quot;%image%&quot; /&gt;&lt;/a&gt;');return false;">&lt;a href="http://www.floatingcoconut.net"&gt;&lt;img src="%image%" /&gt;&lt;/a&gt;</a></em></p>
		        <p>3. <em><a href="#" onclick="textatcursor('adrotate_bannercode','&lt;span class=&quot;ad-%id%&quot;&gt;&lt;a href=&quot;http://www.ajdg.net&quot;&gt;Text Link Ad!&lt;/a&gt;&lt;/span&gt;');return false;">&lt;span class="ad-%id%"&gt;&lt;a href="http://www.ajdg.net"&gt;Text Link Ad!&lt;/a&gt;&lt;/span&gt;</a></em></p>

		        <p><strong><?php _e('Options:', 'adrotate'); ?></strong></p>
		        <p><em><a href="#" onclick="textatcursor('adrotate_bannercode','%id%');return false;">%id%</a>, <a href="#" onclick="textatcursor('adrotate_bannercode','%image%');return false;">%image%</a>, <a href="#" onclick="textatcursor('adrotate_bannercode','%title%');return false;">%title%</a>, <a href="#" onclick="textatcursor('adrotate_bannercode','%random%');return false;">%random%</a>, <a href="#" onclick="textatcursor('adrotate_bannercode','target=&quot;_blank&quot;');return false;">target="_blank"</a>, <a href="#" onclick="textatcursor('adrotate_bannercode','rel=&quot;nofollow&quot;');return false;">rel="nofollow"</a></em><br />
		        <p><?php _e('Place the cursor where you want to add a tag and click to add it to your AdCode.', 'adrotate'); ?></p>
	        </td>
      	</tr>
      	<tr>
	        <th><?php _e('Activate:', 'adrotate'); ?></th>
	        <td colspan="3">
		        <label for="adrotate_active">
			        <select tabindex="3" name="adrotate_active">
						<option value="active" <?php if($edit_banner->type == "active") { echo 'selected'; } ?>><?php _e('Yes, this ad will be visible', 'adrotate'); ?></option>
						<option value="disabled" <?php if($edit_banner->type == "disabled") { echo 'selected'; } ?>><?php _e('Disabled, do not show this ad anywhere', 'adrotate'); ?></option>
						<?php if($adrotate_config['enable_advertisers'] == 'Y' AND $adrotate_config['enable_editing'] == 'Y' AND $saved_user > 0) { ?>
						<option value="queue" <?php if($edit_banner->type == "queue") { echo 'selected'; } ?>><?php _e('Maybe, this ad is queued for review', 'adrotate'); ?></option>
						<option value="reject" <?php if($edit_banner->type == "reject") { echo 'selected'; } ?>><?php _e('No, this ad is rejected', 'adrotate'); ?></option>
						<?php } ?>
					</select>
				</label>
			</td>
      	</tr>
		</tbody>

	</table>

	<p class="submit">
		<input tabindex="0" type="submit" name="adrotate_ad_submit" class="button-primary" value="<?php _e('Save Advert', 'adrotate'); ?>" />
		<a href="admin.php?page=adrotate-ads&view=manage" class="button"><?php _e('Cancel', 'adrotate'); ?></a>
	</p>
		
	<?php if($edit_banner->type != 'empty') { ?>
	<h3><?php _e('Preview', 'adrotate'); ?></h3>
	<table class="widefat" style="margin-top: .5em">

		<tbody>
      	<tr>
	        <td>
	        	<div><?php echo adrotate_preview($edit_banner->id); ?></div>
		        <br /><em><?php _e('Note: While this preview is an accurate one, it might look different then it does on the website.', 'adrotate'); ?>
				<br /><?php _e('This is because of CSS differences. Your themes CSS file is not active here!', 'adrotate'); ?></em>
			</td>
      	</tr>
      	</tbody>

	</table>
	<?php } ?>

	<h3><?php _e('Usage', 'adrotate'); ?></h3>
	<p><em><?php _e('Copy the shortcode in a post or page. The PHP code goes in a theme file where you want the advert to show up.', 'adrotate'); ?></em></p>
	<table class="widefat" style="margin-top: .5em">
		<tbody>
      	<tr>
	        <th width="15%"><?php _e('In a post or page:', 'adrotate'); ?></th>
	        <td>[adrotate banner="<?php echo $edit_banner->id; ?>"]</td>
	        <th width="15%"><?php _e('Directly in a theme:', 'adrotate'); ?></th>
	        <td>&lt;?php echo adrotate_ad(<?php echo $edit_banner->id; ?>); ?&gt;</td>
      	</tr>
      	</tbody>
	</table>

	<h3><?php _e('Advanced', 'adrotate'); ?></h3>
	<p><em><?php _e('Everything below is optional.', 'adrotate'); ?></em></p>
	<table class="widefat" style="margin-top: .5em">

		<tbody>
		<?php if($adrotate_config['enable_stats'] == 'Y') { ?>
      	<tr>
	        <th width="15%" valign="top"><?php _e('Clicktracking:', 'adrotate'); ?></th>
	        <td colspan="3">
	        	<label for="adrotate_tracker"><input tabindex="4" type="checkbox" name="adrotate_tracker" <?php if($edit_banner->tracker == 'Y') { ?>checked="checked" <?php } ?> /> <?php _e('Enable click tracking for this advert.', 'adrotate'); ?> <br />
	        	<em><?php _e('Note: Clicktracking does generally not work for Javascript adverts such as those provided by Google AdSense.', 'adrotate'); ?></em><br />
		        <em><?php _e('Place the target URL in your adcode - Similar to code example 1.', 'adrotate'); ?></em>
		        </label>
	        </td>
      	</tr>
      	<tr>
	        <th valign="top"><?php _e('Target URL:', 'adrotate'); ?></th>
	        <td colspan="3">
	        	<label for="adrotate_link_disabled"><input tabindex="5" name="adrotate_link_disabled" type="text" size="60" class="search-input" value="<?php echo $edit_banner->link;?>" disabled="1" /><br />
		        <em><?php _e('This field is no longer required. You can place the URL directly in the adcode (above) instead of %link%.', 'adrotate'); ?></em></label>
	        </td>
      	</tr>
		<?php } ?>
      	<tr>
	        <th width="15%" valign="top"><?php _e('Responsive:', 'adrotate'); ?></th>
	        <td colspan="3">
	        	<label for="adrotate_responsive"><input tabindex="6" type="checkbox" name="adrotate_responsive" <?php if($edit_banner->responsive == 'Y') { ?>checked="checked" <?php } ?> /> <?php _e('Enable responsive support for this advert.', 'adrotate'); ?></label><br />
		        <em><?php _e('Upload your images to the banner folder and make sure the filename is in the following format; "imagename.full.ext". A full set of sized images is strongly recommended.', 'adrotate'); ?></em><br />
		        <em><?php _e('For smaller size images use ".320", ".480", ".768" or ".1024" in the filename instead of ".full" for the various viewports.', 'adrotate'); ?></em><br />
		        <em><strong><?php _e('Example:', 'adrotate'); ?></strong> <?php _e('image.full.jpg, image.320.jpg and image.768.jpg will serve the same advert for different viewports. Requires jQuery.', 'adrotate'); ?></em></label>
	        </td>
      	</tr>
		<tr>
	        <th width="15%" valign="top"><?php _e('Banner image:', 'adrotate'); ?></th>
			<td colspan="3">
				<label for="adrotate_image">
					<?php _e('Media:', 'adrotate'); ?> <input tabindex="6" id="adrotate_image" type="text" size="50" name="adrotate_image" value="<?php echo $image_field; ?>" /> <input tabindex="7" id="adrotate_image_button" class="button" type="button" value="<?php _e('Select Banner', 'adrotate'); ?>" />
				</label><br />
				<?php _e('- OR -', 'adrotate'); ?><br />
				<label for="adrotate_image_dropdown">
					<?php _e('Banner folder:', 'adrotate'); ?> <select tabindex="8" name="adrotate_image_dropdown" style="min-width: 200px;">
   						<option value=""><?php _e('No image selected', 'adrotate'); ?></option>
						<?php echo adrotate_folder_contents($image_dropdown); ?>
					</select><br />
				</label>
				<em><?php _e('Use %image% in the code. Accepted files are:', 'adrotate'); ?> jpg, jpeg, gif, png, swf <?php _e('and', 'adrotate'); ?> flv. <?php _e('Use either the text field or the dropdown. If the textfield has content that field has priority.', 'adrotate'); ?></em>
			</td>
		</tr>
      	<tr>
		    <th valign="top"><?php _e('Weight:', 'adrotate'); ?></th>
	        <td colspan="3">
	        	<label for="adrotate_weight">
	        	&nbsp;<input type="radio" tabindex="9" name="adrotate_weight" value="2" <?php if($edit_banner->weight == "2") { echo 'checked'; } ?> />&nbsp;&nbsp;&nbsp;2, <?php _e('Barely visible', 'adrotate'); ?><br />
	        	&nbsp;<input type="radio" tabindex="10" name="adrotate_weight" value="4" <?php if($edit_banner->weight == "4") { echo 'checked'; } ?> />&nbsp;&nbsp;&nbsp;4, <?php _e('Less than average', 'adrotate'); ?><br />
	        	&nbsp;<input type="radio" tabindex="11" name="adrotate_weight" value="6" <?php if($edit_banner->weight == "6") { echo 'checked'; } ?> />&nbsp;&nbsp;&nbsp;6, <?php _e('Normal coverage', 'adrotate'); ?><br />
	        	&nbsp;<input type="radio" tabindex="12" name="adrotate_weight" value="8" <?php if($edit_banner->weight == "8") { echo 'checked'; } ?> />&nbsp;&nbsp;&nbsp;8, <?php _e('More than average', 'adrotate'); ?><br />
	        	&nbsp;<input type="radio" tabindex="13" name="adrotate_weight" value="10" <?php if($edit_banner->weight == "10") { echo 'checked'; } ?> />&nbsp;&nbsp;&nbsp;10, <?php _e('Best visibility', 'adrotate'); ?>
	        	</label>
			</td>
		</tr>
      	<tr>
	        <th><?php _e('Sortorder:', 'adrotate'); ?></th>
	        <td colspan="3">
		        <label for="adrotate_sortorder"><input tabindex="4" name="adrotate_sortorder" type="text" size="5" class="search-input" autocomplete="off" value="<?php echo $edit_banner->sortorder;?>" /> <em><?php _e('For administrative purposes set a sortorder.', 'adrotate'); ?> <?php _e('Leave empty or 0 to skip this. Will default to ad id.', 'adrotate'); ?></em></label>
			</td>
      	</tr>
		</tbody>

	</table>

	<p class="submit">
		<input tabindex="0" type="submit" name="adrotate_ad_submit" class="button-primary" value="<?php _e('Save Advert', 'adrotate'); ?>" />
		<a href="admin.php?page=adrotate-ads&view=manage" class="button"><?php _e('Cancel', 'adrotate'); ?></a>
	</p>

	<?php if($adrotate_config['enable_geo'] > 0) { ?>
	<?php $cities = unserialize(stripslashes($edit_banner->cities)); ?>
	<?php $countries = unserialize(stripslashes($edit_banner->countries)); ?>
	<h3><?php _e('Geo Targeting', 'adrotate'); ?></h3>
	<p><em><?php _e('This works if you assign the advert to a group and enable that group to use Geo targeting.', 'adrotate'); ?></em></p>
	<table class="widefat" style="margin-top: .5em">			

		<tbody>
	    <tr>
			<th width="15%" valign="top"><?php _e('Cities/States:', 'adrotate'); ?></strong></th>
			<td colspan="3">
				<textarea tabindex="14" name="adrotate_geo_cities" cols="85" rows="5"><?php echo (is_array($cities)) ? implode(', ', $cities) : ''; ?></textarea><br />
		        <p><em><?php _e('A comma separated list of cities (or the Metro ID) and/or states (Also the states ISO codes are supported)', 'adrotate'); ?> (Alkmaar, Philadelphia, Melbourne, ...)<br /><?php _e('AdRotate does not check the validity of names so make sure you spell them correctly!', 'adrotate'); ?></em></p>
			</td>
		</tr>
	    <tr>
			<th valign="top"><?php _e('Countries:', 'adrotate'); ?></strong></th>
	        <td colspan="2">
		        <label for="adrotate_geo_countries">
			        <div class="adrotate-select">
			        <?php echo adrotate_select_countries($countries); ?>
					</div>
		        </label>
		        <p><em><?php _e('Select the countries you want the adverts to show in.', 'adrotate'); ?> <?php _e('Cities take priority and will be filtered first.', 'adrotate'); ?></em></p>
			</td>
		</tr>
		</tbody>

	</table>
  	<?php } ?>

	<?php if($adrotate_config['enable_advertisers'] == 'Y') { ?>
	<h3><?php _e('Advertiser & Budget', 'adrotate'); ?></h3>
	<p><em><?php _e('Link your ad to an Advertiser and optionally set a budget for clicks and impressions.', 'adrotate'); ?></em></p>
	<table class="widefat" style="margin-top: .5em">	

		<tbody>
      	<tr>
	        <th width="15%" valign="top"><?php _e('Advertiser:', 'adrotate'); ?></th>
	        <td colspan="3">
	        	<label for="adrotate_tracker">
	        	<select tabindex="15" name="adrotate_advertiser" style="min-width: 200px;">
					<option value="0" <?php if($saved_user == '0') { echo 'selected'; } ?>><?php _e('Not specified', 'adrotate'); ?></option>
				<?php 
				foreach($user_list as $user) {
					if($user->ID == $userdata->ID) $you = ' (You)';
						else $you = '';
				?>
					<option value="<?php echo $user->ID; ?>"<?php if($saved_user == $user->ID) { echo ' selected'; } ?>><?php echo $user->display_name; ?><?php echo $you; ?></option>
				<?php } ?>
				</select>
		        <em><?php _e('Must be a registered user on your site with appropriate access roles.', 'adrotate'); ?></em>
		        </label>
			</td>
      	</tr>
      	<tr>
	        <th width="15%"><?php _e('Ad Click Rate:', 'adrotate'); ?></th>
	        <td><label for="adrotate_crate"><input tabindex="16" name="adrotate_crate" type="text" size="5" class="search-input" autocomplete="off" value="<?php echo $edit_banner->crate;?>" /><em><?php _e('Cost per click', 'adrotate'); ?></em></label></td>
	        <th width="15%"><?php _e('Ad Impression Rate:', 'adrotate'); ?></th>
	        <td><label for="adrotate_irate"><input tabindex="17" name="adrotate_irate" type="text" size="5" class="search-input" autocomplete="off" value="<?php echo $edit_banner->irate;?>" /><em><?php _e('Cost per impression', 'adrotate'); ?></em></label></td>
      	</tr>
      	<tr>
	        <th><?php _e('Ad Click Budget:', 'adrotate'); ?></th>
	        <td><label for="adrotate_cbudget"><input tabindex="18" name="adrotate_cbudget" type="text" size="5" class="search-input" autocomplete="off" value="<?php echo $edit_banner->cbudget;?>" /></label></td>
	        <th><?php _e('Ad Impression Budget:', 'adrotate'); ?></th>
	        <td><label for="adrotate_ibudget"><input tabindex="19" name="adrotate_ibudget" type="text" size="5" class="search-input" autocomplete="off" value="<?php echo $edit_banner->ibudget;?>" /></label></td>
      	</tr>
      	</tbody>

	</table>
  	<?php } ?>

	<h3><?php _e('Usage', 'adrotate'); ?></h3>
	<p><em><?php _e('Copy the shortcode in a post or page. The PHP code goes in a theme file where you want the advert to show up.', 'adrotate'); ?></em></p>
	<table class="widefat" style="margin-top: .5em">

		<tbody>
      	<tr>
	        <th width="15%"><?php _e('In a post or page:', 'adrotate'); ?></th>
	        <td width="30%">[adrotate banner="<?php echo $edit_banner->id; ?>"]</td>
	        <th width="15%"><?php _e('Directly in a theme:', 'adrotate'); ?></th>
	        <td>&lt;?php echo adrotate_ad(<?php echo $edit_banner->id; ?>); ?&gt;</td>
      	</tr>
      	</tbody>
	
	</table>

	<p class="submit">
		<input tabindex="20" type="submit" name="adrotate_ad_submit" class="button-primary" value="<?php _e('Save Advert', 'adrotate'); ?>" />
		<a href="admin.php?page=adrotate-ads&view=manage" class="button"><?php _e('Cancel', 'adrotate'); ?></a>
	</p>


 	<h3><?php _e('Create a schedule', 'adrotate'); ?></h3>
	<p><em><?php _e('Create a schedule here if no appropriate one is listed below.', 'adrotate'); ?></em></p>
	<table class="widefat" style="margin-top: .5em">
     	<tr>
	        <th width="15%"><?php _e('Start date (day/month/year):', 'adrotate'); ?></th>
	        <td width="30%">
	        	<label for="adrotate_sday">
	        	<input tabindex="21" name="adrotate_sday" class="search-input" type="text" size="4" maxlength="2" value="" /> /
				<select tabindex="22" name="adrotate_smonth">
					<option value="01" <?php if($smonth == "01") { echo 'selected'; } ?>><?php _e('January', 'adrotate'); ?></option>
					<option value="02" <?php if($smonth == "02") { echo 'selected'; } ?>><?php _e('February', 'adrotate'); ?></option>
					<option value="03" <?php if($smonth == "03") { echo 'selected'; } ?>><?php _e('March', 'adrotate'); ?></option>
					<option value="04" <?php if($smonth == "04") { echo 'selected'; } ?>><?php _e('April', 'adrotate'); ?></option>
					<option value="05" <?php if($smonth == "05") { echo 'selected'; } ?>><?php _e('May', 'adrotate'); ?></option>
					<option value="06" <?php if($smonth == "06") { echo 'selected'; } ?>><?php _e('June', 'adrotate'); ?></option>
					<option value="07" <?php if($smonth == "07") { echo 'selected'; } ?>><?php _e('July', 'adrotate'); ?></option>
					<option value="08" <?php if($smonth == "08") { echo 'selected'; } ?>><?php _e('August', 'adrotate'); ?></option>
					<option value="09" <?php if($smonth == "09") { echo 'selected'; } ?>><?php _e('September', 'adrotate'); ?></option>
					<option value="10" <?php if($smonth == "10") { echo 'selected'; } ?>><?php _e('October', 'adrotate'); ?></option>
					<option value="11" <?php if($smonth == "11") { echo 'selected'; } ?>><?php _e('November', 'adrotate'); ?></option>
					<option value="12" <?php if($smonth == "12") { echo 'selected'; } ?>><?php _e('December', 'adrotate'); ?></option>
				</select> /
				<input tabindex="23" name="adrotate_syear" class="search-input" type="text" size="4" maxlength="4" value="" />&nbsp;&nbsp;&nbsp; 
				</label>
	        </td>
	        <th width="15%"><?php _e('End date (day/month/year):', 'adrotate'); ?></th>
	        <td>
	        	<label for="adrotate_eday">
	        	<input tabindex="24" name="adrotate_eday" class="search-input" type="text" size="4" maxlength="2" value=""  /> /
				<select tabindex="25" name="adrotate_emonth">
					<option value="01" <?php if($emonth == "01") { echo 'selected'; } ?>><?php _e('January', 'adrotate'); ?></option>
					<option value="02" <?php if($emonth == "02") { echo 'selected'; } ?>><?php _e('February', 'adrotate'); ?></option>
					<option value="03" <?php if($emonth == "03") { echo 'selected'; } ?>><?php _e('March', 'adrotate'); ?></option>
					<option value="04" <?php if($emonth == "04") { echo 'selected'; } ?>><?php _e('April', 'adrotate'); ?></option>
					<option value="05" <?php if($emonth == "05") { echo 'selected'; } ?>><?php _e('May', 'adrotate'); ?></option>
					<option value="06" <?php if($emonth == "06") { echo 'selected'; } ?>><?php _e('June', 'adrotate'); ?></option>
					<option value="07" <?php if($emonth == "07") { echo 'selected'; } ?>><?php _e('July', 'adrotate'); ?></option>
					<option value="08" <?php if($emonth == "08") { echo 'selected'; } ?>><?php _e('August', 'adrotate'); ?></option>
					<option value="09" <?php if($emonth == "09") { echo 'selected'; } ?>><?php _e('September', 'adrotate'); ?></option>
					<option value="10" <?php if($emonth == "10") { echo 'selected'; } ?>><?php _e('October', 'adrotate'); ?></option>
					<option value="11" <?php if($emonth == "11") { echo 'selected'; } ?>><?php _e('November', 'adrotate'); ?></option>
					<option value="12" <?php if($emonth == "12") { echo 'selected'; } ?>><?php _e('December', 'adrotate'); ?></option>
				</select> /
				<input tabindex="26" name="adrotate_eyear" class="search-input" type="text" size="4" maxlength="4" value="" />&nbsp;&nbsp;&nbsp; 
				</label>
			</td>
      	</tr>	
      	<tr>
	        <th><?php _e('Start time (hh:mm):', 'adrotate'); ?></th>
	        <td>
	        	<label for="adrotate_sday">
				<input tabindex="27" name="adrotate_shour" class="search-input" type="text" size="2" maxlength="4" value="" /> :
				<input tabindex="28" name="adrotate_sminute" class="search-input" type="text" size="2" maxlength="4" value="" />
				</label>
	        </td>
	        <th><?php _e('End time (hh:mm):', 'adrotate'); ?></th>
	        <td>
	        	<label for="adrotate_eday">
				<input tabindex="29" name="adrotate_ehour" class="search-input" type="text" size="2" maxlength="4" value="" /> :
				<input tabindex="30" name="adrotate_eminute" class="search-input" type="text" size="2" maxlength="4" value="" />
				</label>
			</td>
      	</tr>	
		<?php if($adrotate_config['enable_stats'] == 'Y') { ?>
      	<tr>
      		<th><?php _e('Maximum Clicks:', 'adrotate'); ?></th>
	        <td><input tabindex="31" name="adrotate_maxclicks" type="text" size="5" class="search-input" autocomplete="off" value="" /> <em><?php _e('Leave empty or 0 to skip this.', 'adrotate'); ?></em></td>
		    <th><?php _e('Maximum Impressions:', 'adrotate'); ?></th>
	        <td><input tabindex="32" name="adrotate_maxshown" type="text" size="5" class="search-input" autocomplete="off" value="" /> <em><?php _e('Leave empty or 0 to skip this.', 'adrotate'); ?></em></td>
		</tr>
	    <tr>
			<th valign="top"><?php _e('Spread Impressions', 'adrotate'); ?></th>
			<td colspan="3"><label for="adrotate_spread"><input tabindex="33" type="checkbox" name="adrotate_spread" value="1" /> <?php _e('Try to evenly spread impressions for each advert over the duraction of this schedule. This may cause adverts to intermittently not show.', 'adrotate'); ?></label></td>
		</tr>
		<?php } ?>
	</table>
	<p><em><strong><?php _e('Note:', 'adrotate'); ?></strong> <?php _e('Time uses a 24 hour clock. When you\'re used to the AM/PM system keep this in mind: If the start or end time is after lunch, add 12 hours. 2PM is 14:00 hours. 6AM is 6:00 hours.', 'adrotate'); ?><br /><?php _e('The maximum clicks and impressions are measured over the set schedule only and applies to all adverts using this schedule combined. Every schedule can have it\'s own limit!', 'adrotate'); ?></em></p>

	<h3><?php _e('Choose Schedules', 'adrotate'); ?></h3>
	<p><em><?php _e('You can add, edit or delete schedules from the', 'adrotate'); ?>  '<a href="admin.php?page=adrotate-schedules"><?php _e('Manage Schedules', 'adrotate'); ?></a>' <?php _e('dashboard. Save your advert first!', 'adrotate'); ?></em></p>
	<table class="widefat" style="margin-top: .5em">

		<thead>
		<tr>
			<th scope="col" class="manage-column column-cb check-column"><input type="checkbox" /></th>
	        <th width="4%"><?php _e('ID', 'adrotate'); ?></th>
	        <th width="17%"><?php _e('From / Until', 'adrotate'); ?></th>
	        <th>&nbsp;</th>
	        <th width="12%"><center><?php _e('Clicks', 'adrotate'); ?></center></th>
	        <th width="12%"><center><?php _e('Impressions', 'adrotate'); ?></center></th>
		</tr>
		</thead>

		<tbody>
		<?php
		$class = '';
		foreach($schedules as $schedule) {
			if(!in_array($schedule->id, $schedule_array) AND $adrotate_config['hide_schedules'] == "Y") continue;
			if($schedule->maxclicks == 0) $schedule->maxclicks = 'unlimited';
			if($schedule->maximpressions == 0) $schedule->maximpressions = 'unlimited';

			$class = ('alternate' != $class) ? 'alternate' : '';
			if(in_array($schedule->id, $schedule_array)) $class = 'row_active'; 
			if($schedule->stoptime < $in2days) $class = 'row_urgent'; 
		?>
      	<tr id='schedule-<?php echo $schedule->id; ?>' class='<?php echo $class; ?>'>
			<th class="check-column"><input type="checkbox" name="scheduleselect[]" value="<?php echo $schedule->id; ?>" <?php if(in_array($schedule->id, $schedule_array)) echo "checked"; ?> /></th>
			<td><?php echo $schedule->id; ?></td>
			<td><?php echo date_i18n("F d, Y H:i", $schedule->starttime);?><br /><span style="color: <?php echo adrotate_prepare_color($schedule->stoptime);?>;"><?php echo date_i18n("F d, Y H:i", $schedule->stoptime);?></span></td>
	        <td><?php echo stripslashes(html_entity_decode($schedule->name)); ?><?php if($schedule->spread == 'Y') { ?><span style="color:#999;"><br /><span style="font-weight:bold;">Spread:</span> Max. <?php echo $schedule->dayimpressions; ?> <?php _e('impressions per hour', 'adrotate'); ?></span><?php } ?></td>
	        <td><center><?php echo $schedule->maxclicks; ?></center></td>
	        <td><center><?php echo $schedule->maximpressions; ?></center></td>
      	</tr>
      	<?php } ?>
		</tbody>

	</table>
	<p><center>
		<?php if($adrotate_config['hide_schedules'] == "Y") { ?><?php _e("Schedules not in use by this advert are hidden.", "adrotate"); ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
		<span style="border: 1px solid #518257; height: 12px; width: 12px; background-color: #e5faee">&nbsp;&nbsp;&nbsp;&nbsp;</span> <?php _e("In use by this advert.", "adrotate"); ?>
		&nbsp;&nbsp;&nbsp;&nbsp;<span style="border: 1px solid #c00; height: 12px; width: 12px; background-color: #ffebe8">&nbsp;&nbsp;&nbsp;&nbsp;</span> <?php _e("Expires soon.", "adrotate"); ?>
	</center></p>

	<p class="submit">
		<input tabindex="37" type="submit" name="adrotate_ad_submit" class="button-primary" value="<?php _e('Save Advert', 'adrotate'); ?>" />
		<a href="admin.php?page=adrotate-ads&view=manage" class="button"><?php _e('Cancel', 'adrotate'); ?></a>
	</p>


	<?php if($groups) { ?>
	<h3><?php _e('Select Groups', 'adrotate'); ?></h3>
	<p><em><?php _e('Optionally select the group(s) this ad belongs to.', 'adrotate'); ?></em></p>
	<table class="widefat" style="margin-top: .5em">
		<thead>
		<tr>
			<th scope="col" class="manage-column column-cb check-column"><input type="checkbox" /></th>
			<th><?php _e('ID - Name', 'adrotate'); ?></th>
			<th width="10%"><center><?php _e('Ads', 'adrotate'); ?> / <?php _e('Active', 'adrotate'); ?></center></th>
		</tr>
		</thead>

		<tbody>
		<?php 
		$class = '';
		foreach($groups as $group) {
			if($group->adspeed > 0) $adspeed = $group->adspeed / 1000;
	        if($group->modus == 0) $modus[] = __('Default', 'adrotate');
	        if($group->modus == 1) $modus[] = __('Dynamic', 'adrotate').' ('.$adspeed.' '. __('second rotation', 'adrotate').')';
	        if($group->modus == 2) $modus[] = __('Block', 'adrotate').' ('.$group->gridrows.' x '.$group->gridcolumns.' '. __('grid', 'adrotate').')';
	        if($group->cat_loc > 0 OR $group->page_loc > 0) $modus[] = __('Post Injection', 'adrotate');
	        if($group->geo == 1 AND $adrotate_config['enable_geo'] > 0) $modus[] = __('Geolocation', 'adrotate');

			$ads_in_group = $wpdb->get_var("SELECT COUNT(*) FROM `".$wpdb->prefix."adrotate_linkmeta` WHERE `group` = ".$group->id." AND `block` = 0 AND `user` = 0 AND `schedule` = 0;");
			$active_ads_in_group = $wpdb->get_var("SELECT COUNT(*) FROM  `".$wpdb->prefix."adrotate`, `".$wpdb->prefix."adrotate_linkmeta` WHERE `".$wpdb->prefix."adrotate`.`id` = `".$wpdb->prefix."adrotate_linkmeta`.`ad` AND `type` = 'active' AND `group` = ".$group->id." AND `block` = 0;");
			$class = ('alternate' != $class) ? 'alternate' : ''; ?>
		    <tr id='group-<?php echo $group->id; ?>' class='<?php echo $class; ?>'>
				<th class="check-column" width="2%"><input type="checkbox" name="groupselect[]" value="<?php echo $group->id; ?>" <?php if(in_array($group->id, $meta_array)) echo "checked"; ?> /></th>
				<td><?php echo $group->id; ?> - <strong><?php echo $group->name; ?></strong><span style="color:#999;"><?php echo '<br /><span style="font-weight:bold;">'.__('Mode', 'adrotate').':</span> '.implode(', ', $modus); ?></span></td>
				<td width="15%"><center><?php echo $ads_in_group; ?> / <?php echo $active_ads_in_group; ?></center></td>
			</tr>
		<?php 
			unset($modus);
		} 
		?>
		</tbody>					
	</table>

	<p class="submit">
		<input tabindex="38" type="submit" name="adrotate_ad_submit" class="button-primary" value="<?php _e('Save Advert', 'adrotate'); ?>" />
		<a href="admin.php?page=adrotate-ads&view=manage" class="button"><?php _e('Cancel', 'adrotate'); ?></a>
	</p>
	<?php } ?>
</form>