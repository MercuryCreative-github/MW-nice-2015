<?php
/*
Template Name: Agenda Forum
*/
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
				<?php the_content(); ?>
			</div>

			<aside class="sidebar left-sidebar span3">
				<?php dynamic_sidebar($left_sidebar); ?>
			</aside>

		<?php } else { ?>

		<div class="page-content clearfix">

			<?php


			// this is selected in the page settings. E.g. Internet Of Things
			$forumId= get_field('forum');
			$forumId= $forumId->ID;

			the_content();



			function callLoop($forumId){

				// The Vars to run the Query that gets all the Presentations with this Forum Asociated
				$args = array(
						'post_type' => 'agenda_tracks',
						'order' => 'ASC',
						'meta_query' => array(
								array(
										'key' => 'forum',
										'value' => $forumId,
										'compare' => 'LIKE'
								)
						)
				);

				$loop = new WP_Query( $args );
				$forum='';
				$i=0;


				while ( $loop->have_posts() ) : $loop->the_post();

				// get the selected day
				$day=get_field('day');
				$dayAtt='';
				$speakersDisplay='';
				$moderatorsDisplay='';
				$panelistsDisplay='';
				$facilitatorDisplay='';
				$collaboratorDisplay='';
				$daytag='';
				$time='';
				$hour='';
				$mins='';
				$displayTime='';
				$subtitle='';
				$content='';
				$speakerCount=0;
				$moderatorcount=0;
				$panelistCount=0;
				$facilitatorCount=0;
				$collaboratorCount=0;


				for($j=0;$j<count($day);$j++){

				$dayAtt = $day[$j];
				$term = get_term_by('id', $dayAtt,'events_category');
				$daytag.= ($term -> slug);
				//echo $i.'en>'.$j.':'.$dayAtt.' - ><br>';

				}

				$presentationId=  get_the_ID();

				$args = array(
				'role'=>'speaker',
				'meta_query' =>array(array('value' => $presentationId ,'compare' => 'LIKE'),)
				);// meta_query);

				add_action( 'pre_user_query', function( $user_query ) {
					$user_query->query_fields = 'DISTINCT ' . $user_query->query_fields;
				} );

				// The Query

				$user_query = new WP_User_Query( $args );

				// User Loop
				if ( ! empty( $user_query->results ) ) {
					foreach ( $user_query->results as $user ) {

						$sid = $user->ID;
						$avatar = $user->image;
						$avatar = '<a href="/speaker-profile/?id='.$sid.'">'.wp_get_attachment_image($avatar).'</a>';
						$avatar ='';
						//$avatar = ''; // borra esta linea para que aparezca el avatar
						$nameSp = '<div class="speakerSidebar">' . $user->first_name.' '.$user->last_name;

						// Get companies and user mapping along with job role as per new conventions
						// Get companies and job role
						$companyIds = getUserCompanies( esc_html( $user->ID ) );

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
									$role .= ' - ';
								} else {
									$role .= ', ';
								}
								$role .= '<em>'.$jobRole.'</em>';
								$company = ', <strong>'.get_the_title( $companyId ).'</strong>';  // cambia , por </br>
							}
							$companyRoleStr .= $role . $company;
							$i++;
						} // foreach( $companyIds as $company )
						$companyRoleStr .= '</div>';

						/*$role = ' - <em>'.$user->role.'</em>'; // cambia - por </br>
						// company is a post object so the method to get the value is longer
						// first we get the ID from the custom field
						$companyId = $user->company;
						$companyId = $companyId[0];
						// then we GET the post data
						$companyObj = get_post($companyId);
						// from that object we use the title
						$companyTitle = $companyObj->post_title;
						$company = ', <strong>'.$companyTitle.'</strong></div><div class="clear" style="margin:0"></div>';  // cambia , por </br> */

						//if($role==' - <em></em>'){$role='';} // cambia - por </br>
						//if($company==', <strong></strong>'){$company='';} // cambia , por </br>

						if(($user->speaker_at))
						if (in_array($presentationId, $user->speaker_at)) {
						//$speakersDisplay.= $avatar.$nameSp.$role.$company;
						$speakersDisplay.= $avatar.$nameSp.$companyRoleStr;
						$speakerCount++;
						}

						if(($user->moderator_at))
						if (in_array($presentationId, $user->moderator_at)) {
						//$moderatorsDisplay.= $avatar.$nameSp.$role.$company;
						$moderatorsDisplay.= $avatar.$nameSp.$companyRoleStr;
						$moderatorcount++;
						}

						if(($user->panelist_at))
						if (in_array($presentationId, $user->panelist_at)) {
						//$panelistsDisplay.= $avatar.$nameSp.$role.$company;
						$panelistsDisplay.= $avatar.$nameSp.$companyRoleStr;
						$panelistCount++;
						}

						if(($user->facilitator_at))
						if (in_array($presentationId, $user->facilitator_at)) {
						//$facilitatorDisplay.= $avatar.$nameSp.$role.$company;
						$facilitatorDisplay.= $avatar.$nameSp.$companyRoleStr;
						$facilitatorCount++;
						}

						if(($user->collaborator_at))
						if (in_array($presentationId, $user->collaborator_at)) {
						//$collaboratorDisplay.= $avatar.$nameSp.$role.$company;
						$collaboratorDisplay.= $avatar.$nameSp.$companyRoleStr;
						$collaboratorCount++;
						//echo $collaboratorDisplay.$collaboratorCount;
						}
					}
				}

				if($speakerCount>1){$s='s';}else{$s='';}
				if($speakersDisplay!==''){$speakersDisplay='<strong>Speaker'.$s.':</strong>'.$speakersDisplay.'</br>';}; // cambiar strong por h1
				if($moderatorcount>1){$s='s';}else{$s='';};
				if($moderatorsDisplay!==''){$moderatorsDisplay='<strong>Moderator'.$s.':</strong>'.$moderatorsDisplay.'</br>';};// cambiar strong por h1
				if($panelistCount>1){$s='s';}else{$s='';};
				if($panelistsDisplay!==''){$panelistsDisplay='<strong>Panelist'.$s.':</strong>'.$panelistsDisplay.'</br>';};// cambiar strong por h1
				if($facilitatorCount>1){$s='s';}else{$s='';};
				if($facilitatorDisplay!==''){$facilitatorDisplay='<strong>Facilitator'.$s.':</strong>'.$facilitatorDisplay.'</br>';};// cambiar strong por h1
				if($collaboratorCount>1){$s='s';}else{$s='';};
				if($collaboratorDisplay!==''){$collaboratorDisplay='<strong>Collaborator'.$s.':</strong>'.$collaboratorDisplay.'</br>';};// cambiar strong por h1

				//manage time of the presentation
				$time= get_field('time');
				$time= explode(":", $time);
				$hour = $time[0];
				$mins = $time[1];
				$time=$hour.'.'.$mins;
				if ($hour>12) {
					$displayTime=($hour-12).':'.$mins.' PM';
				} elseif ($hour==12) {
					$displayTime=($hour).':'.$mins.' PM';
				} else {
					$displayTime=($hour).':'.$mins.' AM';};

				// define subtitle
				$subtitle= ' - ' . get_field('sub_title');
				if(get_field('sub_title')==''){$subtitle= '';}

				$content = apply_filters( 'the_content', get_the_content() );
				$content = str_replace( ']]>', ']]&gt;', $content );

				$linkToForum = get_permalink();

				$forum.='<div class="textTrack'.$i.' moveDiv" day="' . $daytag . '" time="' .$time. '" hour="' .$hour. '" mins="' .$mins. '"><div class="body-text clearfix">
									<h2><a href="'.$linkToForum.'">'.get_the_title().'</a></h2>
									<div class="timeTrack">' .  $displayTime . $subtitle. '</div>' . $speakersDisplay.$moderatorsDisplay.$panelistsDisplay.$collaboratorDisplay.$content .'<div class="link-pages"></div>
								</div></div>';
			$i++;
			endwhile;
			echo $forum;

			}

			callLoop($forumId); /// busco todas las presentaciones con el mismo foro seteado que la pagina
			/* Todas los Events (ID) que tienen que aparecer en todos los foros: E:G Morning Break */
			callLoop('17997');
			callLoop('18170');
			callLoop('18182');
			callLoop('19440');
			callLoop('17707');

			$forumsArray=array($forumId,17997,18170,18182,19440,17707);
			$where_in = implode(',', $forumsArray);

			$query = "SELECT * FROM `" . $wpdb->prefix . "event_hours` WHERE `event_id` IN ($where_in) ORDER BY `before_hour_text` ASC";

			$event_hours =	$wpdb->get_results($query);
			$event_hours_count = count($event_hours);

			foreach ( $event_hours as $session ) {

				$args = array(
				    'post_type' => 'companies',
				    'order' => 'ASC',
				    'meta_query' => array(
				        array(
				            'key' => 'sponsoredsession',
				            'value' => $session->event_hours_id,
							'compare' => 'LIKE'
				        )
				    )
				);

				$loop = new WP_Query($args);
				
				//si hay post en este loop colocar sponsor by
				if ( have_posts() ) {

					while ($loop->have_posts()) : $loop->the_post();

						$thumb_id = get_post_thumbnail_id();
						$thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail-size', true);
						$img= $thumb_url[0];

						$startHour = explode(':',$session->start);

						echo '<img class="imgMove" day="'.$session->category.'" starthour="'.$startHour[0].'.'.$startHour[1].'" endhour="'.$session->end.'" src="'.$img.'"/>';

					endwhile;

				};//close if

				wp_reset_postdata();

			}

			?>
			<div class="link-pages"><?php wp_link_pages(); ?></div>
		</div>

		<?php } ?>

	<!-- CLOSE page -->
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
