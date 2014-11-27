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
									// get the selected day
									$day=get_field('day');
									$dayAtt='';
									$speakersDisplay='';
									$daytag='';
									$time='';
									$hour='';
									$mins='';
									$displayTime='';
									$subtitle='';
									$content='';

									for($j=0;$j<count($day);$j++){

									$dayAtt = $day[$j];
									$term = get_term_by('id', $dayAtt,'events_category');
									$daytag.= ($term -> slug);
									}

									$forumLink = get_permalink( get_field('forum') );
									$forum = '<a href="'.$forumLink.'">'.get_the_title( get_field('forum') ).'</a>';

									//manage time of the presentation
									$time= get_field('time');
									$time= explode(":", $time);
									$hour = $time[0];
									$mins = $time[1];
									$time=$hour.'.'.$mins;
									if($hour>12){$displayTime=($hour-12).':'.$mins.' PM';}
									else{$displayTime=($hour).':'.$mins.' AM';};

									if($daytag=='monday'){$dnumber='08';}
									else if($daytag=='tuesday'){$dnumber='09';}
									else if($daytag=='wednesday'){$dnumber='10';}
									else if($daytag=='thursday'){$dnumber='11';}
									else {$dnumber='';}

									$sidebarSchedule= '<div><div class="dday-table dday01-table"><p>DEC<span class="number-day">'.$dnumber.'</span></p></div><div class="fday"><strong>'.$forum.'</strong><br>'.$displayTime.'</div></div></br>';

									// define subtitle
									$subtitle= get_field('sub_title');
								?>


									<h2><?php the_title(); echo '<br> <small>'.$subtitle.'</small>'; ?> </h2>



								<?php the_content();

								echo '<p class="seeMoreForum">> See more from '.$forum.'</p>';

								?>

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
				<?php echo '<div class="widget-heading clearfix"style="margin-top:45px"><h4>Presentation schedule</h4></div>'.$sidebarSchedule; ?>
				</div>




				<div class="speakerTrack">
					<?php

					//print_r(get_field('speakers'));
					$speakersDisplay='';
					$moderatorsDisplay='';
					$panelistsDisplay='';
					$facilitatorDisplay='';
					$collaboratorsDisplay='';

					for ($s=0; $s < count(get_field('speakers')); $s++) {
								$speaker=get_field('speakers');
								$sid = $speaker[$s]['ID'];

								if($sid>0){
									?>

									<?php
									$avatar = get_user_meta($sid, 'image',1);
									$avatar = '<hr><a href="/speaker-profile/?id='.$sid.'">'.wp_get_attachment_image($avatar).'</a>';

									//$avatar = ''; // borra esta linea para que aparezca el avatar

									$nameSp = '<div class="speakerSidebar">' . get_user_meta($sid, 'first_name',1).' '.get_user_meta($sid, 'last_name',1);
									$role = ' - <em>'.get_user_meta($sid, 'role',1).'</em>'; // cambia - por </br>
									// company is a post object so the method to get the value is longer
									// first we get the ID from the custom field
									$companyId = get_user_meta($sid,'company',1);
									$companyId = $companyId[0];
									// then we GET the post data
									$companyObj = get_post($companyId);
									// from that object we use the title
									$companyTitle = $companyObj->post_title;
									$company = ', <strong>'.$companyTitle.'</strong></div><div class="clear" style="margin:0"></div>';  // cambia , por </br>

									if($role==' - <em></em>'){$role='';} // cambia - por </br>
									if($company==', <strong></strong>'){$company='';} // cambia , por </br>
									$speakersDisplay.= $avatar.$nameSp.$role.$company;
								    //print_r(get_user_meta($sid)) ; /* do not erase */
								}
					}


					for ($s=0; $s < count(get_field('moderators')); $s++) {
								$speaker=get_field('moderators');
								$sid = $speaker[$s]['ID'];


								if($sid>0){
									?>

									<?php
									$avatar = get_user_meta($sid, 'image',1);
									$avatar = '<hr><a href="/speaker-profile/?id='.$sid.'">'.wp_get_attachment_image($avatar).'</a>';

									//$avatar = ''; // borra esta linea para que aparezca el avatar

									$nameSp = '<div class="speakerSidebar">' . get_user_meta($sid, 'first_name',1).' '.get_user_meta($sid, 'last_name',1);
									$role = ' - <em>'.get_user_meta($sid, 'role',1).'</em>'; // cambia - por </br>
									// company is a post object so the method to get the value is longer
									// first we get the ID from the custom field
									$companyId = get_user_meta($sid,'company',1);
									$companyId = $companyId[0];
									// then we GET the post data
									$companyObj = get_post($companyId);
									// from that object we use the title
									$companyTitle = $companyObj->post_title;
									$company = ', <strong>'.$companyTitle.'</strong></div><div class="clear" style="margin:0"></div>';  // cambia , por </br>

									if($role==' - <em></em>'){$role='';} // cambia - por </br>
									if($company==', <strong></strong>'){$company='';} // cambia , por </br>
									$moderatorsDisplay.= $avatar.$nameSp.$role.$company;
								    //print_r(get_user_meta($sid)) ; /* do not erase */
								}
					}


					for ($s=0; $s < count(get_field('panelists')); $s++) {
								$speaker=get_field('panelists');
								$sid = $speaker[$s]['ID'];


								if($sid>0){
									?>

									<?php
									$avatar = get_user_meta($sid, 'image',1);
									$avatar = '<hr><a href="/speaker-profile/?id='.$sid.'">'.wp_get_attachment_image($avatar).'</a>';

									//$avatar = ''; // borra esta linea para que aparezca el avatar

									$nameSp = '<div class="speakerSidebar">' . get_user_meta($sid, 'first_name',1).' '.get_user_meta($sid, 'last_name',1);
									$role = ' - <em>'.get_user_meta($sid, 'role',1).'</em>'; // cambia - por </br>
									// company is a post object so the method to get the value is longer
									// first we get the ID from the custom field
									$companyId = get_user_meta($sid,'company',1);
									$companyId = $companyId[0];
									// then we GET the post data
									$companyObj = get_post($companyId);
									// from that object we use the title
									$companyTitle = $companyObj->post_title;
									$company = ', <strong>'.$companyTitle.'</strong></div><div class="clear" style="margin:0"></div>';  // cambia , por </br>

									if($role==' - <em></em>'){$role='';} // cambia - por </br>
									if($company==', <strong></strong>'){$company='';}   // cambia , por </br>
									$panelistsDisplay.= $avatar.$nameSp.$role.$company;
								    //print_r(get_user_meta($sid)) ; /* do not erase */
								}
					}

					for ($s=0; $s < count(get_field('facilitators')); $s++) {
								$speaker=get_field('facilitators');
								$sid = $speaker[$s]['ID'];


								if($sid>0){
									?>

									<?php
									$avatar = get_user_meta($sid, 'image',1);
									$avatar = '<hr><a href="/speaker-profile/?id='.$sid.'">'.wp_get_attachment_image($avatar).'</a>';

									//$avatar = ''; // borra esta linea para que aparezca el avatar

									$nameSp = '<div class="speakerSidebar">' . get_user_meta($sid, 'first_name',1).' '.get_user_meta($sid, 'last_name',1);
									$role = ' - <em>'.get_user_meta($sid, 'role',1).'</em>'; // cambia - por </br>
									// company is a post object so the method to get the value is longer
									// first we get the ID from the custom field
									$companyId = get_user_meta($sid,'company',1);
									$companyId = $companyId[0];
									// then we GET the post data
									$companyObj = get_post($companyId);
									// from that object we use the title
									$companyTitle = $companyObj->post_title;
									$company = ', <strong>'.$companyTitle.'</strong></div><div class="clear" style="margin:0"></div>';  // cambia , por </br>

									if($role==' - <em></em>'){$role='';} // cambia - por </br>
									if($company==', <strong></strong>'){$company='';}   // cambia , por </br>
									$facilitatorDisplay.= $avatar.$nameSp.$role.$company;
								    //print_r(get_user_meta($sid)) ; /* do not erase */
								}
					}

					for ($s=0; $s < count(get_field('collaborators')); $s++) {
								$speaker=get_field('collaborators');
								$sid = $speaker[$s]['ID'];


								if($sid>0){
									?>

									<?php
									$avatar = get_user_meta($sid, 'image',1);
									$avatar = '<hr><a href="/speaker-profile/?id='.$sid.'">'.wp_get_attachment_image($avatar).'</a>';

									//$avatar = ''; // borra esta linea para que aparezca el avatar

									$nameSp = '<div class="speakerSidebar">' . get_user_meta($sid, 'first_name',1).' '.get_user_meta($sid, 'last_name',1);
									$role = ' - <em>'.get_user_meta($sid, 'role',1).'</em>'; // cambia - por </br>
									// company is a post object so the method to get the value is longer
									// first we get the ID from the custom field
									$companyId = get_user_meta($sid,'company',1);
									$companyId = $companyId[0];
									// then we GET the post data
									$companyObj = get_post($companyId);
									// from that object we use the title
									$companyTitle = $companyObj->post_title;
									$company = ', <strong>'.$companyTitle.'</strong></div><div class="clear" style="margin:0"></div>';  // cambia , por </br>

									if($role==' - <em></em>'){$role='';} // cambia - por </br>
									if($company==', <strong></strong>'){$company='';}   // cambia , por </br>
									$facilitatorDisplay.= $avatar.$nameSp.$role.$company;
								    //print_r(get_user_meta($sid)) ; /* do not erase */
								}
					}

				if(count(get_field('speakers'))>1){$s='s';}else{$s='';}
				if($speakersDisplay!==''){$speakersDisplay='<div class="home-titles"><h4>Speaker'.$s.':</h4></div>'.$speakersDisplay.'</br>';}; // cambiar strong por h1
				if(count(get_field('moderators'))>1){$s='s';}else{$s='';}
				if($moderatorsDisplay!==''){$moderatorsDisplay='<div class="home-titles"><h4>Moderator'.$s.':</h4></div>'.$moderatorsDisplay.'</br>';};// cambiar strong por h1
				if(count(get_field('panelists'))>1){$s='s';}else{$s='';}
				if($panelistsDisplay!==''){$panelistsDisplay='<div class="home-titles"><h4>Panelist'.$s.':</h4></div>'.$panelistsDisplay.'</br>';};// cambiar strong por h1
				if(count(get_field('facilitators'))>1){$s='s';}else{$s='';}
				if($facilitatorDisplay!==''){$facilitatorDisplay='<div class="home-titles"><h4>Facilitator'.$s.':</h4></div>'.$facilitatorDisplay.'</br>';};// cambiar strong por h1
				if(count(get_field('collaborators'))>1){$s='s';}else{$s='';}
				if($collaboratorsDisplay!==''){$collaboratorsDisplay='<div class="home-titles"><h4>Collaborator'.$s.':</h4></div>'.$collaboratorsDisplay.'</br>';};// cambiar strong por h1

				echo $speakersDisplay.$moderatorsDisplay.$panelistsDisplay.$facilitatorDisplay.$collaboratorsDisplay;

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
