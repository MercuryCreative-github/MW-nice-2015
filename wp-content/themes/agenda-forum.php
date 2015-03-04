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

				// The Vars to run the Query that gets all the Agenda Tracks (forum) with the speaker asociated
			$args = array(
					'post_type' => 'tmf_presentations',
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
				//echo $i.'en>'.$j.':'.$dayAtt.' - ><br>';

				}

				
					for ($s=0; $s < count(get_field('speakers')); $s++) {
								$speaker=get_field('speakers');
								$sid = $speaker[$s]['ID'];


								if($sid>0){
									?>

									<?php
									$avatar = get_user_meta($sid, 'image',1);
									$avatar = '<a href="/speaker-profile/?id='.$sid.'">'.wp_get_attachment_image($avatar).'</a>';

									$avatar = ''; // borra esta linea para que aparezca el avatar

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
									$avatar = '<a href="/speaker-profile/?id='.$sid.'">'.wp_get_attachment_image($avatar).'</a>';

									$avatar = ''; // borra esta linea para que aparezca el avatar

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
									$avatar = '<a href="/speaker-profile/?id='.$sid.'">'.wp_get_attachment_image($avatar).'</a>';

									$avatar = ''; // borra esta linea para que aparezca el avatar

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
					for ($s=0; $s < count(get_field('facilitator')); $s++) {
								$speaker=get_field('facilitator');
								$sid = $speaker[$s]['ID'];


								if($sid>0){
									?>

									<?php
									$avatar = get_user_meta($sid, 'image',1);
									$avatar = '<a href="/speaker-profile/?id='.$sid.'">'.wp_get_attachment_image($avatar).'</a>';

									$avatar = ''; // borra esta linea para que aparezca el avatar

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
				if($speakersDisplay!==''){$speakersDisplay='<strong>Speaker'.$s.':</strong>'.$speakersDisplay.'</br>';}; // cambiar strong por h1
				if(count(get_field('moderators'))>1){$s='s';}else{$s='';};
				if($moderatorsDisplay!==''){$moderatorsDisplay='<strong>Moderator'.$s.':</strong>'.$moderatorsDisplay.'</br>';};// cambiar strong por h1
				if(count(get_field('panelists'))>1){$s='s';}else{$s='';};
				if($panelistsDisplay!==''){$panelistsDisplay='<strong>Panelist'.$s.':</strong>'.$panelistsDisplay.'</br>';};// cambiar strong por h1
				if(count(get_field('facilitators'))>1){$s='s';}else{$s='';};
				if($facilitatorDisplay!==''){$facilitatorDisplay='<strong>Facilitator'.$s.':</strong>'.$facilitatorDisplay.'</br>';};// cambiar strong por h1
				if(count(get_field('collaborators'))>1){$s='s';}else{$s='';};
				if($collaboratorsDisplay!==''){$collaboratorsDisplay='<strong>Collaborator'.$s.':</strong>'.$collaboratorsDisplay.'</br>';};// cambiar strong por h1

				//manage time of the presentation
				$time= get_field('time');
				$time= split(":", $time);
				$hour = $time[0];
				$mins = $time[1];
				$time=$hour.'.'.$mins;
				if($hour>12){$displayTime=($hour-12).':'.$mins.' PM';}
				else{$displayTime=($hour).':'.$mins.' AM';};

				// define subtitle
				$subtitle= ' - ' . get_field('sub_title');
				if(get_field('sub_title')==''){$subtitle= '';}

				$content = apply_filters( 'the_content', get_the_content() );
				$content = str_replace( ']]>', ']]&gt;', $content );

				$linkToForum = get_permalink();

				$forum.='<div class="textTrack'.$i.' moveDiv" day="' . $daytag . '" time="' .$time. '" hour="' .$hour. '" mins="' .$mins. '"><div class="body-text clearfix">
									<h2><a href="'.$linkToForum.'">'.get_the_title().'</a></h2>
									<div class="timeTrack">' .  $displayTime . $subtitle. '</div>' . $speakersDisplay.$moderatorsDisplay.$panelistsDisplay.$content .'<div class="link-pages"></div>
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
			callLoop('19440');
			callLoop('17707');

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
