<?php
/*
Template Name: Speakers
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

			</div>

			<aside class="sidebar left-sidebar span3">
				<?php dynamic_sidebar($left_sidebar); ?>
			</aside>

		<?php } else { ?>

		<div class="page-content clearfix">
		<!--//
		<div class="speaker-description">
			<h2>Here is just a small selection of the experts presenting at TM Forum Live!</h2>
			<p style="margin-bottom: 50px;">Watch this space for the full speaker list coming very soon.</p>
		</div>
		//-->
			<div class="span12 speakers-actions">
				<div class="filters span9">
					<button type="button" class="high">Highlighted</button>
					<button type="button" class="key">Keynotes</button>
					<button type="button" class="all active">Full Speakers List</button>
				</div>
				<div class="form span3">
					<input type="search" class="find-speaker" placeholder="Search for Speakers">
				</div>
			</div>
			<?php

			function create_page_content(){

				$page_content='';

				  $args  = array(
				    //'meta_key ' => 'last_name',
				    'order ' => 'ASC',
				    'orderby' => 'meta_value',
				    'role' => 'speaker',
				    // check for two meta_values
					'meta_query' => array(
							array(
								'key'     => 'last_name',
							),
						)
				    );

				// Save user ID to pass on data to Speaker page
				$user_id = esc_html( $user->ID );

				$user_query = new WP_User_Query( $args );

				// User Loop
				foreach ( $user_query->results as $user ) {
				

						$categorySpeakers = get_user_meta($user->ID, '_TMF_speakers_categories', true);
						$categoryDisplay='';

						if(is_array($categorySpeakers)){

							foreach ($categorySpeakers as $categorySpeaker) {
								if($categorySpeaker=='check1'){$categoryDisplay.=' highlighted';}
									else{$categoryDisplay.=' keynote';};
							}
						}

						$page_content.= '<div class="speaker-box speaker-item'.$categoryDisplay.'">';
						$page_content.= '<a href="/speaker-profile/?id=' . esc_html( $user->ID ) . '" title="View ' . esc_html( $user->display_name ) . ' page">';
						
						// Get the user id of the user and the id of the image
						$userMetaImageId = get_user_meta($user->ID,'image_id',true);
						// Asign a size to the image
						$userMetaImage =  wp_get_attachment_image_src( $userMetaImageId, 'thumbnail' ); 

						// if $userMetaImage (an array) is empty/false
						if(!($userMetaImage)){
						$userMetaImage[] ='/wp-content/uploads/2014/09/default_speaker.png';
						}
						//the ferst element of the $userMetaImage array is the url of the image
						$page_content.= '<div class="thumb"><img src="'.$userMetaImage[0].'" onload="speakerImgSize(this);"/></div>';
						$page_content.= '<div class="speaker-data">';
						$page_content.= '<p class="name">' . esc_html( $user->display_name ) . '</p>';
						
						// New mapping of user and companies with job role
						// Get companies and job role
						$companyIds = getUserCompanies( esc_html( $user->ID ), true );
						
						if( (int)$companyIds > 0 ) {
							$jobRole = getUserJobRolesByCompanyId( $user->ID, $companyIds );
							if( empty( $jobRole ) ) {
								$jobRole = esc_html( $user->role );
							}
							$page_content.= '<p class="role">' . esc_html( $jobRole ) . '</p>';
							$page_content.= '<p><strong class="company">' . get_the_title( $companyIds ) . '</strong></p>';
						} 
						


						$page_content.= '</div>';
						$page_content.= '</a>';
						$page_content.= '</div> <!-- End Speaker -->';
				} // ends foreach $blogusers as $user

				return $page_content;

			} // ends function create page content

			echo create_page_content();

			?>

		<?php } // ends else of $sidebar_config == "both-sidebars" ?>

	<script>
		
		/* Search Speaker function */
		jQuery('.find-speaker').keyup(function() {

			jQuery('.speaker-item').each(function(){
				// the value of the input field to toUpperCase
				searchingFor=jQuery('.find-speaker').val().toUpperCase();
				// if what we are searchingFor is part of any piece of text inside the speaker item, show it. Else hide it.
				if(jQuery(this).text().toUpperCase().indexOf(searchingFor)>=0){jQuery(this).show();}else {jQuery(this).hide();}
				
			})
	    });

		/* Filtering Highlited, Keynotes Speakers */
		jQuery('.filters .all').click(function() {
			jQuery('.speaker-item').fadeIn();

	    });

		jQuery('.filters .high').click(function() {
			jQuery('.speaker-item').stop(true,true).fadeOut(function(){
	        	jQuery('.speaker-item.highlighted').fadeIn();				
			});
	    });

		jQuery('.filters .key').click(function() {
	        jQuery('.speaker-item').stop(true,true).fadeOut(function(){
	       		jQuery('.speaker-item.keynote').fadeIn();	        	
	        });
	    });

	    /* Higlighting selected option */
		jQuery('.filters button').click(function() {
			jQuery('.find-speaker').val('');
	        jQuery('.filters button').removeClass('active');
	        jQuery(this).addClass('active');
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

<!-- Reading and applying filters for the Speakers list -->
<?php
	$filter = $_GET['filter'];
	if($filter == "high") {
	    echo '<script>jQuery(document).ready(function(){jQuery("button.high").click();});</script>';
	}
	if($filter == "key") {
	    echo '<script>jQuery(document).ready(function(){jQuery("button.key").click();});</script>';
	}
?>


<?php get_footer(); ?>