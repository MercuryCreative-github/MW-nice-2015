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
    if (!function_exists('get_keynote_streaming')) {
    	function get_keynote_streaming($sessionStarts,$summit_slug,$sessionId,$sessionColor,$storedDay,$storedMonth){

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
			$indice = 0;

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
					$presentationStartNum=get_post_meta($presentationToCheckId,'_TMF_presentations_start_date',true);
					$presentationEndNum=get_post_meta($presentationToCheckId,'_TMF_presentations_end_date',true);
					



					//echo $presentationStart;

					$presentationStart=date('g:i a',get_post_meta($presentationToCheckId,'_TMF_presentations_start_date',true));
					$presentationEnd=date('g:i a',get_post_meta($presentationToCheckId,'_TMF_presentations_end_date',true));
					$role_to_update='';

					$role_to_update=('speaker');

					

						$role_to_fetch=	$role_to_update.'s_meta';
						$presentationSpeakers=get_post_meta($presentationToCheckId,$role_to_fetch,true);

						if(is_array($presentationSpeakers) && !empty($presentationSpeakers)){

							$speacificArray=$role_to_update;

							if(count($presentationSpeakers)>2){
								$span=4;
							}else{$span=12;}

							$indiceS=0;

							foreach ( $presentationSpeakers as $presentationSpeaker ) {

								$indiceS++;

								// Get the user id of the user and the id of the image
								$userMetaImageId = get_user_meta($presentationSpeaker,'image_id',true);
								$userMetaImage =  wp_get_attachment_image_src( $userMetaImageId, 'thumbnail' );
								// if $userMetaImage (an array) is empty/false

								if(!($userMetaImage)){
								$userMetaImage[] ='/wp-content/uploads/2014/09/default_speaker.png';
								}

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
										if($indiceS%3==1 || $indiceS==1){$SpeakerHtmlOutput.='<div class="row-fluid">';}
										$SpeakerHtmlOutput.='<div class="speakerTrack span'.$span.'">';
											$SpeakerHtmlOutput.='<div class="streaming-img"><a href="/speaker-profile/?id='.$user->ID.'"><img src="'.$userMetaImage[0].'"></a></div>';
											$SpeakerHtmlOutput.='<div class="streaming-txt"><a href="/speaker-profile/?id='.$user->ID.'" style="color:#AEACAC";>'.$user->display_name.'</a><br/>';
											$SpeakerHtmlOutput.='<em>'.($userJobRole).'</em>,';
											if(!empty($userCompanies)){$SpeakerHtmlOutput.='<strong> '.$userCompanyName.'</strong></div>';}
										$SpeakerHtmlOutput.='</div>';
										if($indiceS%3==0 || $indiceS==count($presentationSpeakers)){$SpeakerHtmlOutput.='</div>';}

										// this array contains inside one array per role and inside each of them, the speakers data.
										$arrayByRole[$speacificArray][]=$SpeakerHtmlOutput;
									
									} //close if($hasThisRole)

								} //close if(is_array($userMeta)

							} //close foreach ( $presentationSpeakers as $presentationSpeaker )
						
						} //close if(is_array($presentationSpeakers) && !empty($presentationSpeakers))


					$presentationSesion=$sessionId;
					$presentationLink = get_permalink();

					$rolesToshow = $role_to_update;	

					if(!empty($arrayByRole[$rolesToshow])){
					//Presentations output

					$keynotesCount= count($arrayByRole[$rolesToshow]);

					$span = min(12,4*$keynotesCount);
					$indice++;

					if($indice%3==1 || $indice==1){$presentationsHtmlOutput.='<div class="row-fluid">';}

					$presentationsHtmlOutput.='<div class="streaming-keynotes span'.$span.'" data-start="'.$presentationStartNum.'" data-end="'.$presentationEndNum.'">';
						$presentationsHtmlOutput.='<div class="nday">';
							$presentationsHtmlOutput.='<div class="dday-table" style="border-color: #AEACAC">';
								$presentationsHtmlOutput.='<p>'.$storedMonth.'<br/><span class="number-day">0'.$storedDay.'</span></p>';
							$presentationsHtmlOutput.='</div>';
							$presentationsHtmlOutput.='<div class="fday">'.$presentationStart.'</div>';
						$presentationsHtmlOutput.='</div>';
					

						$roleLabel=$rolesToshow;
						if(isset($arrayByRole[$rolesToshow]))
								if(count($arrayByRole[$rolesToshow])>1)
										$roleLabel=$rolesToshow.'s';
						

						if(!empty($arrayByRole[$rolesToshow])){
							$presentationsHtmlOutput.='<div class="presentation-speaker">';

							foreach ($arrayByRole[$rolesToshow] as $speakerData) {
								$presentationsHtmlOutput.=$speakerData;
							}

							$presentationsHtmlOutput.='</div>';
						} //close if 
						else{$presentationsHtmlOutput.='df';}


					if($indice%3==0 || $indice ==3){$presentationsHtmlOutput.='</div>';}


					$presentationsHtmlOutput.='</div>'; //close summit-presentation
					}

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
	$storedMonth=date('M',$sessionStarts);
	$storedDay=date('j',$sessionStarts);
	// Sessions output depends on functions
	$sessions.= '<div id="session-'.$sessionId.'">'.get_keynote_streaming($sessionStarts,$summit_slug,$sessionId,$sessionColor,$storedDay,$storedMonth).'</div>';

	

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

<script>
	$=jQuery;

	function countDown(){

	var now = (new Date)

	$('.streaming-keynotes').each(function(){

		max = 100000000000000000000;
		presentationStart=$(this).data('start')*1000;
		presentationEnd=$(this).data('end')*1000;

		h1 = "Streaming Keynotes Live!";
		h2 = '';

		if(now<presentationStart && presentationEnd<now){
			h1 = "Now wathing: $presentationTitle";
			h2 = "Streaming Keynotes Live!";
			$(this).addClass('streamingNow');
		}
		else if(presentationStart>now){
			h1 = "Streaming Keynotes Live!";
			countNum=Math.min(max,presentationStart);
		}
		
	})

	timeZoneDiff = 4

	var countNum = (new Date(countNum)) - now -timeZoneDiff*1000*60*60;

	countNumH = Math.floor(countNum/(1000*60*60))
	countNumM = Math.floor(countNum/(1000*60)) - countNumH*60 + timeZoneDiff+1
	countNumS = Math.floor(countNum/(1000)) - (countNumM-timeZoneDiff-1)*60 - countNumH*60*60
	if(countNumM>60){countNumM-=60;countNumH++}

	if(countNumH==0){countNumH=''}else if(countNumH==1){countNumH=countNumH+' hour '}else{countNumH=countNumH+' hours '}
	if(countNumM==0){countNumM=''}else if(countNumM==1){countNumM=countNumM+' minute '}else{countNumM=countNumM+' minutes '}
	
	h2 = countNumH+countNumM+countNumS+" seconds to live!";
	console.log(countNum)

	$('h1.light').text(h1);
	$('h1.light').append('<small>');
	$('h1.light small').addClass('streamingSubTitle').text(h2);

	}
	setInterval(countDown, 1000);




</script>
