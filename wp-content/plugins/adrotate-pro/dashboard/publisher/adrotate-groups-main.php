<?php
/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2015 AJdG Solutions (Arnan de Gans). All Rights Reserved.
*  ADROTATE is a registered trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from it's use.
------------------------------------------------------------------------------------ */
?>
<h3><?php _e('Manage Groups', 'adrotate'); ?></h3>

<form name="groups" id="post" method="post" action="admin.php?page=adrotate-groups">
	<?php wp_nonce_field('adrotate_bulk_groups','adrotate_nonce'); ?>

	<div class="tablenav">
		<div class="alignleft">
			<select name="adrotate_action" id="cat" class="postform">
		        <option value=""><?php _e('Bulk Actions', 'adrotate'); ?></option>
		        <option value="group_delete"><?php _e('Delete Group', 'adrotate'); ?></option>
				<option value="group_delete_banners"><?php _e('Delete Group including ads', 'adrotate'); ?></option>
			</select>
			<input onclick="return confirm('<?php _e('You are about to delete a group', 'adrotate'); ?>\n<?php _e('This action can not be undone!', 'adrotate'); ?>\n<?php _e('OK to continue, CANCEL to stop.', 'adrotate'); ?>')" type="submit" id="post-action-submit" name="adrotate_action_submit" value="<?php _e('Go', 'adrotate'); ?>" class="button-secondary" />
		</div>
	</div>
	
   	<table class="widefat" style="margin-top: .5em">
			<thead>
			<tr>
			<th class="check-column">&nbsp;</th>
			<th width="5%"><center><?php _e('ID', 'adrotate'); ?></center></th>
			<th><?php _e('Name', 'adrotate'); ?></th>
			<th width="10%"><center><?php _e('Ads', 'adrotate'); ?> / <?php _e('Active', 'adrotate'); ?></center></th>
			<th width="5%"><center><?php _e('Impressions', 'adrotate'); ?></center></th>
			<th width="5%"><center><?php _e('Today', 'adrotate'); ?></center></th>
			<th width="5%"><center><?php _e('Clicks', 'adrotate'); ?></center></th>
			<th width="5%"><center><?php _e('Today', 'adrotate'); ?></center></th>
			<th width="15%"><center><?php _e('Code', 'adrotate'); ?></center></th>
		</tr>
			</thead>
		<tbody>
			
		<?php $groups = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix . "adrotate_groups` WHERE `name` != '' ORDER BY `sortorder` ASC, `id` ASC;");
		if($groups) {
			$class = '';
			$modus = array();
			foreach($groups as $group) {
				$stats = $wpdb->get_row("SELECT SUM(`clicks`) as `clicks`, SUM(`impressions`) as `impressions` FROM `".$wpdb->prefix."adrotate_stats` WHERE `group` = '$group->id';", ARRAY_A);
				$stats_today = $wpdb->get_row("SELECT SUM(`clicks`) as `clicks`, SUM(`impressions`) as `impressions` FROM `".$wpdb->prefix."adrotate_stats` WHERE `group` = '$group->id' AND `thetime` = '$today';", ARRAY_A);

				// Prevent gaps in display
				if(empty($stats['impressions'])) $stats['impressions'] = 0;
				if(empty($stats['clicks']))	$stats['clicks'] = 0;
				if(empty($stats_today['impressions'])) $stats_today['impressions'] = 0;
				if(empty($stats_today['clicks'])) $stats_today['clicks'] = 0;
				if($group->adspeed > 0) $adspeed = $group->adspeed / 1000;
		        if($group->modus == 0) $modus[] = __('Default', 'adrotate');
		        if($group->modus == 1) $modus[] = __('Dynamic', 'adrotate').' ('.$adspeed.' '. __('second rotation', 'adrotate').')';
		        if($group->modus == 2) $modus[] = __('Block', 'adrotate').' ('.$group->gridrows.' x '.$group->gridcolumns.' '. __('grid', 'adrotate').')';
		        if($group->cat_loc > 0 OR $group->page_loc > 0) $modus[] = __('Post Injection', 'adrotate');
		        if($group->geo == 1 AND $adrotate_config['enable_geo'] > 0) $modus[] = __('Geolocation', 'adrotate');
		        if($group->fallback > 0) $modus[] = __('Fallback', 'adrotate').' (Group '.$group->fallback.')';

				$ads_in_group = $wpdb->get_var("SELECT COUNT(*) FROM `".$wpdb->prefix."adrotate_linkmeta` WHERE `group` = ".$group->id." AND `block` = 0;");
				$active_ads_in_group = $wpdb->get_var("SELECT COUNT(*) FROM  `".$wpdb->prefix."adrotate`, `".$wpdb->prefix."adrotate_linkmeta` WHERE `".$wpdb->prefix."adrotate`.`id` = `".$wpdb->prefix."adrotate_linkmeta`.`ad` AND (`type` = 'active' OR `type` = '2days' OR `type` = '7days') AND `group` = ".$group->id." AND `block` = 0;");
				$class = ('alternate' != $class) ? 'alternate' : ''; ?>
			    <tr class='<?php echo $class; ?>'>
					<th class="check-column"><input type="checkbox" name="groupcheck[]" value="<?php echo $group->id; ?>" /></th>
					<td><center><?php echo $group->id;?></center></td>
					<td><strong><a class="row-title" href="<?php echo admin_url('/admin.php?page=adrotate-groups&view=edit&group='.$group->id);?>" title="<?php _e('Edit', 'adrotate'); ?>"><?php echo $group->name;?></a></strong> - <a href="<?php echo admin_url('/admin.php?page=adrotate-groups&view=report&group='.$group->id);?>" title="<?php _e('Stats', 'adrotate'); ?>"><?php _e('Report', 'adrotate'); ?></a><span style="color:#999;"><?php echo '<br /><span style="font-weight:bold;">'.__('Mode', 'adrotate').':</span> '.implode(', ', $modus); ?></span></td>
					<td><center><?php echo $ads_in_group; ?> / <?php echo $active_ads_in_group; ?></center></td>
					<td><center><?php echo $stats['impressions']; ?></center></td>
					<td><center><?php echo $stats_today['impressions']; ?></center></td>
					<td><center><?php echo $stats['clicks']; ?></center></td>
					<td><center><?php echo $stats_today['clicks']; ?></center></td>
					<td><center>[adrotate group="<?php echo $group->id; ?>"]</center></td>
				</tr>
				<?php unset($stats, $stats_today, $adspeed, $modus);?>
 			<?php } ?>
		<?php } else { ?>
				<tr>
					<th class="check-column">&nbsp;</th>
					<td colspan="9"><em><?php _e('No groups created!', 'adrotate'); ?></em></td>
				</tr>
		<?php } ?>
			</tbody>
	</table>
</form>
