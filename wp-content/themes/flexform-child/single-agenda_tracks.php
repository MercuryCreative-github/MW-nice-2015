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

	$full_width_display = get_post_meta($post->ID, 'sf_full_width_display', true);
	$show_author_info = get_post_meta($post->ID, 'sf_author_info', true);
	$show_social = get_post_meta($post->ID, 'sf_social_sharing', true);
	$show_related =  get_post_meta($post->ID, 'sf_related_articles', true);
	$remove_breadcrumbs = get_post_meta($post->ID, 'sf_no_breadcrumbs', true);

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
?>

<?php if (have_posts()) : the_post(); ?>

	<?php
		$post_author = get_the_author_link();
		$post_date = get_the_date();
		$post_categories = get_the_category_list(', ');

		$media_type = $media_image = $media_video = $media_gallery = '';

		$use_thumb_content = get_post_meta($post->ID, 'sf_thumbnail_content_main_detail', true);
		$post_format = get_post_format($post->ID);
		if ( $post_format == "" ) {
			$post_format = 'standard';
		}
		if ($use_thumb_content) {
		$media_type = get_post_meta($post->ID, 'sf_thumbnail_type', true);
		} else {
		$media_type = get_post_meta($post->ID, 'sf_detail_type', true);
		}
		$media_slider = get_post_meta($post->ID, 'sf_detail_rev_slider_alias', true);

		if ((($sidebar_config == "left-sidebar") || ($sidebar_config == "right-sidebar") || ($sidebar_config == "both-sidebars")) && !$full_width_display) {
			$media_width = 770;
			$media_height = NULL;
			$video_height = 433;
			} else {
			$media_width = 1170;
			$media_height = NULL;
			$video_height = 658;
		}
		$figure_output = '';

		if ($full_width_display) {
			$figure_output .= '<figure class="media-wrap full-width-detail">';
		} else {
			$figure_output .= '<figure class="media-wrap">';
		}

		if ($post_format == "standard") {

			if ($media_type == "video") {

				$figure_output .= sf_video_post($post->ID, $media_width, $video_height, $use_thumb_content)."\n";

			} else if ($media_type == "slider") {

				$figure_output .= sf_gallery_post($post->ID, $use_thumb_content)."\n";

			} else if ($media_type == "layer-slider") {

				$figure_output .= '<div class="layerslider">'."\n";

				$figure_output .= do_shortcode('[rev_slider '.$media_slider.']')."\n";

				$figure_output .= '</div>'."\n";

			} else if ($media_type == "custom") {

				$figure_output .= $custom_media."\n";

			} else {

				$figure_output .= sf_image_post($post->ID, $media_width, $media_height, $use_thumb_content)."\n";

			}

		} else {

			$figure_output .= sf_get_post_media($post->ID, $media_width, $media_height, $video_height, $use_thumb_content);

		}

		$figure_output .= '</figure>'."\n";
	?>

	<div class="inner-page-wrap no-top-spacing <?php echo $page_wrap_class; ?> clearfix">

		<?php if ($full_width_display && $media_type != "none") {
			echo $figure_output;
		} ?>

		<!-- OPEN article -->
		<?php if ($sidebar_config == "left-sidebar") { ?>
		<article <?php post_class('clearfix span8 agenda-tracks'); ?> id="<?php the_ID(); ?>">
		<?php } elseif ($sidebar_config == "right-sidebar") { ?>
		<article <?php post_class('clearfix span8'); ?> id="<?php the_ID(); ?>">
		<?php } else { ?>
		<article <?php post_class('clearfix row'); ?> id="<?php the_ID(); ?>">
		<?php } ?>

		<?php if ($sidebar_config == "both-sidebars") { ?>
			<div class="page-content span6 clearfix">
		<?php } else if ($sidebar_config == "no-sidebars") { ?>
			<div class="page-content span12 clearfix">
		<?php } else { ?>
			<div class="page-content clearfix">
		<?php } ?>

				<div class="row">
					<div class="span8">
						<section class="article-body-wrap">
							<div class="body-text clearfix">
								<?php




									$forumId = get_post_meta(get_the_ID(), '_TMF_presentation_session', true);
									$forumLink = get_permalink($forumId);

									$forum = '<a href="'.$forumLink.'">'.get_the_title( $forumId ).'</a>';

									//manage time of the presentation
									$sessionId= get_post_meta(get_the_ID(), '_TMF_presentation_session', true);
									$sessionTime= get_post_meta($sessionId, '_TMF_session_start_date', true);

								    	// variables set
								    	$presentationsHtmlOutput='';

								    	$args = array(
											'post_type'  => 'agenda_tracks',
											'meta_key'	 => '_TMF_presentations_start_date',
											'orderby'	 => 'meta_value',
											'order' 		=> 'ASC',
											'meta_query' => array(
												array(
													'key'     => '_TMF_presentation_session',
													'value'   => $sessionId,
													'compare' => 'LIKE',
												),
											),
										);


										// This are all the presentations in the same session
										$presentationToCheck = new WP_Query( $args );

										$sidebarSchedule='';

										// The Loop
										if ( $presentationToCheck->have_posts() ) {

											while ( $presentationToCheck->have_posts() ) {

												// needed variables				
												$presentationToCheck->the_post();
												$presentationToCheckId=get_the_ID();
												$presentationTitle=get_the_title();
												$presentationSubtitle=get_post_meta($presentationToCheckId,'_TMF_presentations_subtitle',true);
												$dnumber=date('d',get_post_meta($presentationToCheckId,'_TMF_presentations_start_date',true));
												$dmonth=date('M',get_post_meta($presentationToCheckId,'_TMF_presentations_start_date',true));
												$displayTime=date('h:i',get_post_meta($presentationToCheckId,'_TMF_presentations_start_date',true));
												$presentationLink = get_permalink();

												$sidebarSchedule.= '<div>';
												$sidebarSchedule.= '<div class="dday-table dday01-table">';
												$sidebarSchedule.= '<p>'.$dmonth.'<span class="number-day">'.$dnumber.'</span></p>';
												$sidebarSchedule.= '</div>';
												$sidebarSchedule.= '<div class="fday">';
												$sidebarSchedule.='<a href="'.$presentationLink .'">'.$presentationTitle.'</a><br>';
												$sidebarSchedule.= $displayTime.'</div></div></br>';
												
											}
										}

								    wp_reset_query();

									// define subtitle
									$subtitle= get_post_meta(get_the_ID(),'_TMF_presentations_subtitle',true);
								?>


								<div class="single-presentation"><?php '<h3>'.the_title(); echo '</h3> <div class="presentation-subtitle">'.$subtitle.'</div>'; ?> </div>

								<?php the_content();?>

								<p class="seeMoreForum">> See more from <?php echo $forum ?> </p>
								

								<div class="link-pages"><?php wp_link_pages(); ?></div>
							</div>

							<?php if ($show_author_info) { ?>

							<div class="author-info-wrap clearfix">
								<div class="author-avatar"><?php if(function_exists('get_avatar')) { echo get_avatar(get_the_author_meta('ID'), '164'); } ?></div>
								<div class="post-info">
									<div class="author-name"><span><?php _e("Posted by", "swiftframework"); ?></span><a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php the_author_meta('display_name'); ?></a></div>
									<div class="post-date"><?php echo $post_date; ?></div>
								</div>
							</div>

							<?php } ?>

						</section>
					</div>
				</div>

				<?php if ($show_related) { ?>

				<div class="related-wrap">
				<?php
					$categories = get_the_category($post->ID);
					if ($categories) {
						$category_ids = array();
						foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;

						$args=array(
							'category__in' => $category_ids,
							'post__not_in' => array($post->ID),
							'showposts'=> 4, // Number of related posts that will be shown.
							'orderby' => 'rand'
						);
					}
					$related_posts_query = new wp_query($args);
					if( $related_posts_query->have_posts() ) {
						_e("<h4>Related Articles</h4>", "swiftframework");
						echo '<ul class="related-items row clearfix">';
						while ($related_posts_query->have_posts()) {
							$related_posts_query->the_post();
							$thumb_image = "";
							$thumb_image = get_post_meta($post->ID, 'sf_thumbnail_image', true);
							if (!$thumb_image) {
								$thumb_image = get_post_thumbnail_id();
							}
							$thumb_img_url = wp_get_attachment_url( $thumb_image, 'full' );
							$image = aq_resize( $thumb_img_url, 220, 152, true, false);
							?>
							<?php if ($sidebar_config == "both-sidebars" || $sidebar_config == "no-sidebars") { ?>
							<li class="related-item span3 clearfix">
							<?php } else { ?>
							<li class="related-item span2 clearfix">
							<?php } ?>
								<figure>
									<a href="<?php the_permalink(); ?>">
										<div class="overlay"><div class="thumb-info">
											<i class="icon-file-alt"></i>
										</div></div>
										<img src="<?php echo $image[0]; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" />
									</a>
								</figure>
								<h5><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h5>
							</li>
						<?php }
						echo '</ul>';
					}

					wp_reset_query();
				?>
				</div>

				<?php } ?>


				<?php if ( comments_open() ) { ?>
				<div id="comment-area">
					<?php comments_template('', true); ?>
				</div>
				<?php } ?>

			</div>

			<?php if ($sidebar_config == "both-sidebars") { ?>
			<aside class="sidebar left-sidebar span3">
				<?php dynamic_sidebar($left_sidebar); ?>
			</aside>
			<?php } ?>

		<!-- CLOSE article -->
		</article>

		<?php if ($sidebar_config == "left-sidebar") { ?>

			<aside class="sidebar left-sidebar span4">
				<?php dynamic_sidebar($left_sidebar); ?>
			</aside>

		<?php } else if ($sidebar_config == "right-sidebar") { ?>

			<aside class="sidebar right-sidebar span4">

				<div id="calendar_widget" class="widget calendar_widget">
				<?php echo '<div class="widget-heading clearfix"style="margin-top:45px"><h4><strong>Presentation</strong> Schedule</h4></div>'.$sidebarSchedule; ?>
				</div>

				<div class="speakerTrack">
					<?php

					//print_r(get_field('speakers'));
					$speakersDisplay='';
					$moderatorsDisplay='';
					$panelistsDisplay='';
					$facilitatorDisplay='';
					$collaboratorDisplay='';
					$speakerCount=0;
					$moderatorcount=0;
					$panelistCount=0;
					$facilitatorCount=0;
					$collaboratorCount=0;

					$presentationId=  get_the_ID();

				$args = array(
					'role'=>'speaker',
					'meta_query' =>array(array('value' => $presentationId ,'compare' => 'LIKE'),) // en algun meta tiene el ID de este usuario (speaker, moderator, facilitator, panelist)
				);// meta_query);

				// The Query
				add_action( 'pre_user_query', function( $user_query ) {
					$user_query->query_fields = 'DISTINCT ' . $user_query->query_fields;
				} );

				$user_query = new WP_User_Query( $args );

				// User Loop
				if ( ! empty( $user_query->results ) ) {
					
					foreach ( $user_query->results as $user ) {
						$sid = $user->ID;
						$avatar = $user->image;
						$avatar = wp_get_attachment_image($avatar);
						//$avatar = ''; // borra esta linea para que aparezca el avatar
						$nameSp = '<div class="speakerSidebar"><a href="/speaker-profile/?id='.$sid.'">' . $user->first_name.' '.$user->last_name.'</a>';
						
						// New mapping of user and companies with job role
						// Get companies and job role
						$companyIds = getUserCompanies( esc_html( $user->ID ), true );
						
						if( (int)$companyIds > 0 ) {
							$jobRole = getUserJobRolesByCompanyId( $user->ID, $companyIds );
							if( empty( $jobRole ) ) {
								$jobRole = esc_html( $user->role );
							}
							$role = ' - <em>'.$jobRole.'</em>';
							$company = ', <strong>'. get_the_title( $companyIds ).'</strong></div><div class="clear" style="margin:0"></div>';  // cambia , por </br> 
						} 
						
						//$role = ' - <em>'.$user->role.'</em>'; // cambia - por </br>
						// company is a post object so the method to get the value is longer
						// first we get the ID from the custom field
						/*$companyId = $user->company;
						$companyId = $companyId[0];
						// then we GET the post data
						$companyObj = get_post($companyId);
						// from that object we use the title
						$companyTitle = $companyObj->post_title;
						$company = ', <strong>'.$companyTitle.'</strong></div><div class="clear" style="margin:0"></div>';  // cambia , por </br>*/ 

						if($role==' - <em></em>'){$role='';} // cambia - por </br>
						if($company==', <strong></strong>'){$company='';} // cambia , por </br>

						if(($user->speaker_at)) {
							if (in_array($presentationId, $user->speaker_at)) {						
								$speakersDisplay.= $avatar.$nameSp.$role.$company;
								$speakerCount++;
							}
						}

						if(($user->moderator_at))
						if (in_array($presentationId, $user->moderator_at)) {						
						$moderatorsDisplay.= $avatar.$nameSp.$role.$company;
						$moderatorcount++;
						}

						if(($user->panelist_at))
						if (in_array($presentationId, $user->panelist_at)) {						
						$panelistsDisplay.= $avatar.$nameSp.$role.$company;
						$panelistCount++;
						}

						if(($user->facilitator_at))
						if (in_array($presentationId, $user->facilitator_at)) {						
						$facilitatorDisplay.= $avatar.$nameSp.$role.$company;
						$facilitatorCount++;
						}

						if(($user->collaborator_at))
						if (in_array($presentationId, $user->collaborator_at)) {						
						$collaboratorDisplay.= $avatar.$nameSp.$role.$company;
						$collaboratorCount++;
						}
					}
				} 

				if($speakerCount>1){$s='s';}else{$s='';}
				if($speakersDisplay!==''){$speakersDisplay='<h4>Speaker'.$s.':</h4>'.$speakersDisplay.'</br>';}; // cambiar strong por h1
				if($moderatorcount>1){$s='s';}else{$s='';};
				if($moderatorsDisplay!==''){$moderatorsDisplay='<h4>Moderator'.$s.':</h4>'.$moderatorsDisplay.'</br>';};// cambiar strong por h1
				if($panelistCount>1){$s='s';}else{$s='';};
				if($panelistsDisplay!==''){$panelistsDisplay='<h4>Panelist'.$s.':</h4>'.$panelistsDisplay.'</br>';};// cambiar strong por h1
				if($facilitatorCount>1){$s='s';}else{$s='';};
				if($facilitatorDisplay!==''){$facilitatorDisplay='<h4>Facilitator'.$s.':</h4>'.$facilitatorDisplay.'</br>';};// cambiar strong por h1
				if($collaboratorCount>1){$s='s';}else{$s='';};
				if($collaboratorDisplay!==''){$collaboratorDisplay='<h4>Collaborator'.$s.':</h4>'.$collaboratorDisplay.'</br>';};// cambiar strong por h1

				echo $speakersDisplay.$moderatorsDisplay.$panelistsDisplay.$facilitatorDisplay.$collaboratorDisplay;

					?>
					</div>

				
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