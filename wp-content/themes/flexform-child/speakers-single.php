<?php
/*
Template Name: Speaker Profile
*/
?>
<?php
	/* Redirect to Speakers List page if ID param is null or the user is !Speaker */
	$user_id = $_GET['id'];
	$user = get_userdata($user_id);
	if(empty($user_id) || implode(', ', $user->roles) != "Speaker"){
	    header("Location: /speakers/");
	}
?>
<?php get_header(); ?>

<?php
	$options = get_option('sf_flexform_options');
	$default_show_page_heading = $options['default_show_page_heading'];
	$default_page_heading_bg_alt = $options['default_page_heading_bg_alt'];
	$default_sidebar_config = $options['default_sidebar_config'];
	$default_left_sidebar = $options['default_left_sidebar'];
	$default_right_sidebar = $options['default_right_sidebar'];

	$show_page_title = get_post_meta($post->ID, 'sf_page_title', true);
	$page_title_one = get_post_meta($post->ID, 'sf_page_title_one', true);
	$page_title_two = get_post_meta($post->ID, 'sf_page_title_two', true);
	$page_title_bg = get_post_meta($post->ID, 'sf_page_title_bg', true);

	if ($show_page_title == "") {
		$show_page_title = $default_show_page_heading;
	}
	if ($page_title_bg == "") {
		$page_title_bg = $default_page_heading_bg_alt;
	}

	$sidebar_config = get_post_meta($post->ID, 'sf_sidebar_config', true);
	$left_sidebar = get_post_meta($post->ID, 'sf_left_sidebar', true);
	$right_sidebar = get_post_meta($post->ID, 'sf_right_sidebar', true);

	if ($sidebar_config == "") {
		$sidebar_config = $default_sidebar_config;
	}
	if ($left_sidebar == "") {
		$left_sidebar = $default_left_sidebar;
	}
	if ($right_sidebar == "") {
		$right_sidebar = $default_right_sidebar;
	}

	$page_wrap_class = '';
	if ($sidebar_config == "left-sidebar") {
	$page_wrap_class = 'has-left-sidebar has-one-sidebar row';
	} else if ($sidebar_config == "right-sidebar") {
	$page_wrap_class = 'has-right-sidebar has-one-sidebar row';
	} else if ($sidebar_config == "both-sidebars") {
	$page_wrap_class = 'has-both-sidebars';
	} else {
	$page_wrap_class = 'has-no-sidebar';
	}

	$remove_breadcrumbs = get_post_meta($post->ID, 'sf_no_breadcrumbs', true);
	$remove_bottom_spacing = get_post_meta($post->ID, 'sf_no_bottom_spacing', true);
	$remove_top_spacing = get_post_meta($post->ID, 'sf_no_top_spacing', true);

	if ($remove_bottom_spacing) {
	$page_wrap_class .= ' no-bottom-spacing';
	}
	if ($remove_top_spacing) {
	$page_wrap_class .= ' no-top-spacing';
	}
?>

<?php if (have_posts()) : the_post(); ?>

<?php if ($show_page_title) { ?>
	<div class="row">
		<div class="page-heading span12 clearfix alt-bg <?php echo $page_title_bg; ?>">
			<?php if ($page_title_one) { ?>
			<h1><?php echo $page_title_one; ?></h1>
			<?php } else { ?>
			<h1><?php the_title(); ?></h1>
			<?php } ?>
			<?php if ($page_title_one) { ?>
			<h3><?php echo $page_title_two; ?></h3>
			<?php } ?>
		</div>
	</div>
<?php } ?>

<?php
	// BREADCRUMBS
	if(!$remove_breadcrumbs) {
		echo sf_breadcrumbs();
} ?>

<div class="inner-page-wrap <?php echo $page_wrap_class; ?> clearfix">

	<!-- OPEN page -->
	<?php if (($sidebar_config == "left-sidebar") || ($sidebar_config == "right-sidebar")) { ?>
	<div <?php post_class('clearfix span8'); ?> id="<?php the_ID(); ?>">
	<?php } else if ($sidebar_config == "both-sidebars") { ?>
	<div <?php post_class('clearfix row'); ?> id="<?php the_ID(); ?>">
	<?php } else { ?>
	<div <?php post_class('clearfix'); ?> id="<?php the_ID(); ?>">
	<?php } ?>

		<?php if ($sidebar_config == "both-sidebars") { ?>

			<div class="page-content span6">

			</div>

			<aside class="sidebar left-sidebar span3">
				<?php dynamic_sidebar($left_sidebar); ?>
			</aside>

		<?php } else { ?>

		<div class="page-content clearfix">
			<div class="row">
				<div class="span12 speakers-actions">
					<div class="filters span9">
						<a href="/speakers/?filter=high" class="high">Highlighted</a>
						<a href="/speakers/?filter=key" class="key">Keynotes</a>
						<a href="/speakers/" class="all">Full Speakers List</a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="span8 speaker-profile">
	<?php
	$user = get_userdata($_GET["id"]);
	$avatar = get_user_meta($sid, 'image',1);
	$userId = '"'.$_GET["id"].'"';
	$companies=$user->company;
	$companyId = $companies[0];
	// then we GET the post data
	$companyObj = get_post($companyId);
	// from that object we use the title
	$companyTitle = $companyObj->post_title;
	$companyURL = $companyObj->url;
	$companyThumb = get_the_post_thumbnail($companyId, 'medium');
	$presentations='';
	$sidebarSchedule='';

	//var_dump($user);

	$twitter='';
	if($user->twitter_alias!==''){

		$twitter ='<div style="float:right"><a href="http://www.twitter.com/'.( $user->twitter_alias ).'" target="_blank"><i class="icon icon-twitter" style="vertical-align: bottom;"></i> '.( $user->twitter_alias ).'</a></div>';


	};


// User data from
$speakerItem= '<div class="speaker-info">';
	$speakerItem.= '<div class="thumb-single thumb">'; 
		$speakerItem.= wp_get_attachment_image($user->image);
		$speakerItem.= '<div style="margin-top: 20px;"><a href="'.$companyURL.'" target="_blank">'.$companyThumb.'</a></div>';
	$speakerItem.= '</div>';
	$speakerItem.= '<div class="subtitle" style="display:inline-block;vertical-align: top;">';
		$speakerItem.= '<h4>' . esc_html( $user->display_name ). $twitter . '</h4>';
		
		// Get companies and job role
		$companyIds = getUserCompanies( esc_html( $user->ID ) );
		
		$speaker = '';
		$i = 0;
		$companyRoleStr = '';
		foreach( $companyIds as $companyId ) {
			if( (int)$companyId == 0 ) continue;
			$role = '';
			$company = '';
			
			$jobRole = getUserJobRolesByCompanyId( $user->ID, $companyId );
			if( empty( $jobRole ) ) {
				$jobRole = esc_html( $user->role );
			}
			
			if( !empty( $jobRole ) || (int)$companyId > 0 ) {
				if( $i == 0 ) {
					$role .= '';
				} else {
					$role .= '<br/>';
				}
				$role .= $jobRole;
				$company = get_the_title( $companyId );  // cambia , por </br> 
			}
			$companyRoleStr .= $role . ( !empty( $jobRole ) ? ' at ' : ' ' ) . $company;
			$i++;
		} // foreach( $companyIds as $company )
		$speakerItem.= '<p class="name">' . $companyRoleStr . '</p>';
		
		
		//$speakerItem.= '<p class="name">' . esc_html( $user->role ) . ' at '.$companyTitle.'</p>';
		$speakerItem.= '<p>' . ( $user->biography ) . '</p>';
	$speakerItem.= '</div>';
$speakerItem.= '</div>';
$speakerItem.= '<div class="clear"></div>';

echo $speakerItem;


// old call to the Db where we look for the presentations with userId on their meta
function callPresentations($user){
// The Vars to run the Query that gets all the Agenda Tracks (presentations) with the speaker asociated

$presentationsToSpeak = get_user_meta($user->ID, 'speaker_at' );
$presentationsToModerate = get_user_meta($user->ID, 'moderator_at' );
$presentationsToPanelist = get_user_meta($user->ID, 'panelist_at' );
$presentationsToFacilitate = get_user_meta($user->ID, 'facilitator_at' );
$presentationsToCollaborate = get_user_meta($user->ID, 'collaborator_at' );

$presentationsIDsArray[]=$presentationsToSpeak;
$presentationsIDsArray[]=$presentationsToModerate;
$presentationsIDsArray[]=$presentationsToPanelist;
$presentationsIDsArray[]=$presentationsToFacilitate;
$presentationsIDsArray[]=$presentationsToCollaborate;

foreach ($presentationsIDsArray as $arr) {
	foreach ($arr as $presnetId) {
		if($presnetId!==''){
			foreach ($presnetId as $value) {$presentationsIDs[]=$value;}
		}
	}
}

	$presentations='';
	$presentations.='<div class="wpb_wrapper clearfix"><h4>' . esc_html( $user->display_name ) . '&#39;s <strong>Schedule</strong></h4></div>';

foreach ($presentationsIDs as $presentationToCheck ) {

		$presentationToCheck = get_post( $presentationToCheck );

		if ( $presentationToCheck  !== NULL && $presentationToCheck->post_type =='agenda_tracks'){

			$presentationToCheckId=$presentationToCheck->ID;

			$presentationTitle=get_the_title($presentationToCheckId);
			$presentationSubtitle=get_post_meta($presentationToCheckId,'_TMF_presentations_subtitle',true);

			$dmonth=date('D j',get_post_meta($presentationToCheckId,'_TMF_presentations_start_date',true));
			$startTime=date('g:i a',get_post_meta($presentationToCheckId,'_TMF_presentations_start_date',true));
			$endTime=date('g:i a',get_post_meta($presentationToCheckId,'_TMF_presentations_end_date',true));
			$presentationLink = get_permalink($presentationToCheckId);

			$presentations.='<div class="speaking-schedule">';
			$presentations.='<p><strong><a href="'.$presentationLink.'">'.$presentationTitle.'</a></strong><br/>';
			$presentations.='<span style="text-transform: capitalize;">'.$dmonth.'</span> - '.$startTime.' - '.$endTime.'</p>';
			$presentations.='</div>';

		}


}

/*	// get the selected day
	$day=get_field('day');
	$dayAtt='';
	$speakersDisplay='';
	$moderatorsDisplay='';
	$panelistsDisplay='';
	$daytag='';
	$time='';
	$hour='';
	$mins='';
	$endTime='';
	$endHour='';
	$endMins='';
	$showStartTime='';
	$showEndTime='';
	$subtitle='';
	$content='';

	for($j=0;$j<count($day);$j++){
		$dayAtt = $day[$j];
		$term = get_term_by('id', $dayAtt,'events_category');
		$daytag.= ($term -> slug);
	}

	$forumId = get_field('forum');
	$forumId = $forumId->ID;
	$forumLink = get_post_meta($forumId,'timetable_custom_url',1);

	$forum = '<a href="'.$forumLink.'">'.get_the_title( $forumId ).'</a>';

	$time= get_field('time');
	echo $time;
	$time= split(":", $time);
	$hour = $time[0];
	$mins = $time[1];
	$time=$hour.'.'.$mins;
	if($hour>12){$showStartTime=($hour-12).':'.$mins.' pm';}
	else{$showStartTime=($hour).':'.$mins.' am';};

	$endTime= get_field('end_time');
	echo $endTime;
	$endTime= split(":", $endTime);
	$endHour = $endTime[0];
	$endMins = $endTime[1];
	$endTime=$endHour.'.'.$endMins;
	if($endHour>12){$showEndTime=($endHour-12).':'.$endMins.' pm';}
	else{$showEndTime=($endHour).':'.$endMins.' am';};

	if($daytag=='monday'){$dnumber='01';}
	else if($daytag=='tuesday'){$dnumber='02';}
	else if($daytag=='wednesday'){$dnumber='03';}
	else if($daytag=='thursday'){$dnumber='04';}
	else {$dnumber='';}

	// define subtitle
	$subtitle= get_field('sub_title').' - ';
	if($subtitle==' - '){$subtitle='';}
	$content = apply_filters( 'the_content', get_the_content() );
	$content = str_replace( ']]>', ']]&gt;', $content );
	$linkToForum = get_permalink();

	$presentations.='<div class="speaking-schedule">';
	$presentations.='<p><strong><a href="'.$linkToForum.'">'.get_the_title().'</a></strong><br/>';
	$presentations.='<span style="text-transform: capitalize;">'.$daytag.'</span> - '.$showStartTime.' - '.$showEndTime.'</p>';
	$presentations.='</div>';

	$title= explode(' – ',get_the_title());
	$title= get_the_title();

	$sidebarSchedule .='<div class="nday" style="margin-bottom:10px;"><div class="dday" style="background:#ffffff"><p>DEC<br><span>'.$dnumber.'</span></p></div>';
	$sidebarSchedule .='<div class="fday"><strong><span style="text-transform:capitalize">' .$title. '</span></strong></br><strong>'.$forum. '<!-- at '. $showStartTime.'--></strong></div></div><div class="clear"></div>';
	endwhile;
}*/



	if($presentations!=='<div class="wpb_wrapper clearfix"><h2>' . esc_html( $user->display_name ) . '&#39;s schedule</h2></div>'){echo $presentations;}
	return $sidebarSchedule;
	}

	$sidebarSchedule = callPresentations($user);

?>

</div>
</div>

		<?php } ?>

	<script>
		/* Hide the "Array" text when field Company is not empty */
		jQuery('.speaker-info .company').each(function(){
			if (jQuery(this).text() == "Array") {
				jQuery(this).css("visibility","hidden");
			}
		});
		

		jQuery('.speaker-info .thumb').each(function(){
			if (jQuery('img',this).length == 0) {
				jQuery(this).append('<img src="/wp-content/uploads/2014/09/default_speaker.png"/>');
			}
		});

	</script>
	<!-- CLOSE page -->
	</div>
	</div>
	<?php if ($sidebar_config == "left-sidebar") { ?>

		<aside class="sidebar left-sidebar span4">
			<?php dynamic_sidebar($left_sidebar); ?>
		</aside>

	<?php } else if ($sidebar_config == "right-sidebar") { ?>

		<aside class="sidebar right-sidebar span4">
			<?php dynamic_sidebar($right_sidebar); ?>
		</aside>

	<?php } else if ($sidebar_config == "both-sidebars") { ?>

		<aside class="sidebar right-sidebar span3">
			<?php dynamic_sidebar($right_sidebar); ?>
		</aside>

	<?php } ?>

</div>

<?php endif; ?>




<!--// WordPress Hook //-->


<?php get_footer(); ?>