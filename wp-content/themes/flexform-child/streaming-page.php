<?php
/*
Template Name: Keynotes Streaming
*/
?><?php get_header(); ?>
	
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
			<?php the_content(); ?>	

			<?php

			// var set and unset
	$SpeakerHtmlOutput='';
	$presentationsHtmlOutput='';

    // OutPut functions START HERE. Please read last.
    if (!function_exists('get_presentations')) {
    	function get_presentations($sessionStarts,$summit_slug,$sessionId,$sessionColor){

	    	$args = array(
				'post_type'  => 'agenda_tracks',
				'meta_key'	 => '_TMF_presentations_start_date',
				'orderby'	 => 'meta_value_num',
				'order' 		=> 'ASC',
				'meta_query' => array(
					array(
						'key'     => '_TMF_presentation_session',
						'value'   => $sessionId,
						'compare' => 'LIKE',
					),
				),
			);

			// This are all the presentations that have him/her listed as spekear/moderator/etc
			$presentationToCheck = new WP_Query( $args );
			$presentationsHtmlOutput='';

			// The Loop
			if ( $presentationToCheck->have_posts() ) {

				while ( $presentationToCheck->have_posts() ) {

					// variables unset
					unset($arrayByRole);
					$arrayByRole = array();
					$speacificArray='';

					// needed variables
					$presentationToCheck->the_post();
					$presentationSlug = $presentationToCheck->post_name;
					$presentationToCheckId=get_the_ID();
					$presentationTitle=get_the_title();
					$presentationContent=get_the_content();
					$presentationSubtitle=get_post_meta($presentationToCheckId,'_TMF_presentations_subtitle',true);
					$presentationStart=date('g:i a',get_post_meta($presentationToCheckId,'_TMF_presentations_start_date',true));
					$presentationEnd=date('g:i a',get_post_meta($presentationToCheckId,'_TMF_presentations_end_date',true));
					$role_to_update='';

					$roles=array('speaker','panelist','collaborator','facilitator','moderator');

					foreach ($roles as $role_to_update) {

						$role_to_fetch=	$role_to_update.'s_meta';
						$presentationSpeakers=get_post_meta($presentationToCheckId,$role_to_fetch,true);

						if(is_array($presentationSpeakers) && !empty($presentationSpeakers)){

							$speacificArray=$role_to_update;

							foreach ( $presentationSpeakers as $presentationSpeaker ) {

								// needed variables
								$userMeta = get_user_meta( $presentationSpeaker, $role_to_update.'_at',true);
								$userJobRole = get_user_meta( $presentationSpeaker, 'job_role',true);
								$userCompanies = get_user_meta( $presentationSpeaker, 'company',true);

								if(!empty($userCompanies)){
									// we are using just the first company.
									$userCompanyId = $userCompanies[0];
									$userCompanyName= get_the_title($userCompanyId);
								}

								$user = get_user_by( 'id', $presentationSpeaker );

								// if the user has the checked role in this presentation
								if(is_array($userMeta)){

									$hasThisRole=in_array($presentationToCheckId,$userMeta);

									$SpeakerHtmlOutput='';

									if($hasThisRole && is_object($user)){
										//speaker output to store
										$SpeakerHtmlOutput.='<p>- <a href="/speaker-profile/?id='.$user->ID.'">'.$user->display_name.'</a>, ';
										$SpeakerHtmlOutput.='<em>'.($userJobRole).'</em>, ';
										if(!empty($userCompanies)){$SpeakerHtmlOutput.='<strong>'.$userCompanyName.'</strong>';}
										$SpeakerHtmlOutput.='</p>';

										// this array contains inside one array per role and inside each of them, the speakers data.
										$arrayByRole[$speacificArray][]=$SpeakerHtmlOutput;
									
									} //close if($hasThisRole)

								} //close if(is_array($userMeta)

							} //close foreach ( $presentationSpeakers as $presentationSpeaker )
						
						} //close if(is_array($presentationSpeakers) && !empty($presentationSpeakers))

					} //close foreach ($roles as $role_to_update)

					$presentationSesion=$sessionId;
					$presentationLink = get_permalink();

					//Presentations output
					$presentationsHtmlOutput.='<div class="summit-presentation">';
					$presentationsHtmlOutput.='<div class="presentation-time" style="border-color:'.$sessionColor.';">'.$presentationStart.'</div>';
					$presentationsHtmlOutput.='<div class="presentation-info" id="'.$presentationSlug.'">';
					$presentationsHtmlOutput.='<div class="presentation-title" >';
					$presentationsHtmlOutput.='<a href="'.$presentationLink.'">'.$presentationTitle.'</a>';
					$presentationsHtmlOutput.='</div>';
					$presentationsHtmlOutput.='<div class="presentation-subtitle">'.$presentationSubtitle.'</div>';
					$presentationsHtmlOutput.='<div class="presentation-content" style="display:none">'.$presentationContent.'</div>';
					
					foreach ($roles as $rolesToshow) {

						$roleLabel=$rolesToshow;
						if(isset($arrayByRole[$rolesToshow]))
								if(count($arrayByRole[$rolesToshow])>1)
										$roleLabel=$rolesToshow.'s';
						

						if(!empty($arrayByRole[$rolesToshow])){
							$presentationsHtmlOutput.='<div class="presentation-speaker"><strong>'.ucwords($roleLabel).'</strong>';

							foreach ($arrayByRole[$rolesToshow] as $speakerData) {
								$presentationsHtmlOutput.=$speakerData;
							}

							$presentationsHtmlOutput.='</div>';
						} //close if
					} //close foreach

					$presentationsHtmlOutput.='</div>'; //close presentation-info
					$presentationsHtmlOutput.='</div>'; //close summit-presentation

			    }// close while ( $presentationToCheck->have_posts()
			} // close THE LOOP if ( $presentationToCheck->have_posts() 

    		wp_reset_query();

			return $presentationsHtmlOutput;
	}} // end if get_presentations


	$summit_slug='keynotes';

	// The Vars to run the Query that gets all the Presentations with this Forum Asociated based on the $summit_slug
	$args = array(
	'post_type' 	=> 'tmf_sessions',
	'order' 		=> 'ASC',
	'meta_key'	 	=> '_TMF_session_start_date',
	'orderby'	 	=> 'meta_value_num',
	'tax_query'		=> array(
			array(
				'taxonomy' => 'tmf_summit_category',
				'field'    => 'slug',
				'terms'    => $summit_slug,
			),
		),
	);

	// WP Query
	$loop = new WP_Query( $args );

	// Variables set
	$sessions='';
	$storedDay = '';
	$i=0;

	while ( $loop->have_posts() ) : $loop->the_post();

	// needed variables
	$i++;
	$sessionId = get_the_ID();
	$sessionTitle = get_the_title();
	$prefix = '_TMF_';
	$sessionStarts = get_post_meta( $sessionId, $prefix . 'session_start_date',true);
	$sessionChair = get_post_meta( $sessionId, $prefix . 'chair',true);
	$sessionSponsors = get_post_meta( $sessionId, $prefix . 'sponsors',true);
	$sessionColor = get_post_meta ( $sessionId, $prefix . 'summit_colorpicker',true);
	$sessionIcon = get_post_meta ( $sessionId, $prefix . 'summit_image',true);

	// If a new day stars, we write the DAY
	if($storedDay!==date('l,  F j',$sessionStarts)){
		$storedDay=date('l,  F j',$sessionStarts);

		if(isset($sessionIcon) && $sessionIcon != null){
			$sessions.= '<div class="summit-day"><p>';
			$sessions.= '<img src="'.$sessionIcon.'"/>';
		}else{
			$sessions.= '<div class="summit-day"><p style="padding: 0 0 5px 15px;">';
		}
		$sessions.= $storedDay.'</p></div>';
	}

	// Sessions output depends on functions
	$sessions.= '<div class="session-name">'.$sessionTitle.'</div>';
	$sessions.= '<div class="clear"></div>';
	$sessions.= '<div id="session-'.$sessionId.'">'.get_presentations($sessionStarts,$summit_slug,$sessionId,$sessionColor).'</div>';

	

	wp_reset_query();


	$i++;
	endwhile;

	echo $sessions;



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