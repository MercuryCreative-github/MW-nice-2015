<?php
/*
Template Name: Event Sponsors
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
		<div class="page-content span6"></div>
		<aside class="sidebar left-sidebar span3">
			<?php dynamic_sidebar($left_sidebar); ?>
		</aside>
	<?php } else { ?>
		<div class="page-content clearfix">
		<div class="row">
			<div class="wpb_content_element span6 questions wpb_text_column" style="margin-left: 10px;">
				<div class="wpb_wrapper clearfix">
					<ul>
						<li><a class="anchorScroll" href="#corpsponsors">Corporate Sponsors</a></li>
						<li><a class="anchorScroll" href="#confsponsors">Conference Sponsors</a></li>
						<li><a class="anchorScroll" href="#exhibitors">Exhibitors</a></li>
						<li><a class="anchorScroll" href="#networking">Networking/Activity Sponsors</a></li>
					</ul>
				</div> 
			</div>
			<div class="wpb_content_element span6 questions wpb_text_column">
				<div class="wpb_wrapper clearfix">
					<ul>
						<li><a class="anchorScroll" href="#officialSponsor">Official Sponsor</a></li>
						<li><a class="anchorScroll" href="#eas">Executive Appointment Service</a></li>
						<li><a class="anchorScroll" href="#media">Media Sponsors</a></li>
					</ul>
				</div> 
			</div>
		</div>

		
		<h2 id="corpsponsors">Corporate Sponsors</h2>
		<div class="sponsor sponsor-corporate">
			<?php
				$args = array(
					'post_type' => 'companies',
					'categories-companies'  => 'corporate',
				);
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post(); ?>
				  <div class="sponsor-item">
					  <a href="<?php the_field('url') ?>" title="<?php the_title(); ?>">
					  	<?php the_post_thumbnail('small'); ?>
					  </a>
					   <p><?php the_field('tag') ?></p>
				  </div>
			<?php endwhile; ?>
		</div>
		<div class="back-to-top scroll-to-top"><a href="#header-section">back to top<i class="icon-arrow-up"></i></a></div>

		<h2 id="confsponsors">Conference Sponsors</h2>
		<div class="sponsor sponsor-onference">
			<?php
				$args = array(
					'post_type' => 'companies',
					'categories-companies'  => 'conference',
				);
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post(); ?>
				  <div class="sponsor-item">
					  <a href="<?php the_field('url') ?>" title="<?php the_title(); ?>">
					  	<?php the_post_thumbnail('medium'); ?>
					  </a>
					  <p><?php the_field('tag') ?></p>
				  </div>
			<?php endwhile; ?>
		</div>
		<div class="back-to-top scroll-to-top"><a href="#header-section">back to top<i class="icon-arrow-up"></i></a></div>

		<h2 id="exhibitors">Exhibitors Sponsors</h2>
		<div class="sponsor sponsor-exhibitors">
			<?php
				$args = array(
					'post_type' => 'companies',
					'categories-companies'  => 'exhibitors',
				);
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post(); ?>
				  <div class="sponsor-item">
					  <a href="<?php the_field('url') ?>" title="<?php the_title(); ?>">
					  	<?php the_post_thumbnail('medium'); ?>
					  </a>
				  </div>
			<?php endwhile; ?>
		</div>
		<div class="back-to-top scroll-to-top"><a href="#header-section">back to top<i class="icon-arrow-up"></i></a></div>

		<h2 id="networking">Networking/Activity Sponsors</h2>
		<div class="sponsor sponsor-networking">
			<?php
				$args = array(
					'post_type' => 'companies',
					'categories-companies'  => 'networking',
				);
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post(); ?>
				  <div class="sponsor-item">
					  <a href="<?php the_field('url') ?>" title="<?php the_title(); ?>">
					  	<?php the_post_thumbnail('medium'); ?>
					  </a>
				  </div>
			<?php endwhile; ?>
		</div>
		<div class="back-to-top scroll-to-top"><a href="#header-section">back to top<i class="icon-arrow-up"></i></a></div>

		<h2 id="officialSponsor">Official Sponsor</h2>
		<div class="sponsor sponsor-official">
			<?php
				$args = array(
					'post_type' => 'companies',
					'categories-companies'  => 'official',
				);
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post(); ?>
				  <div class="sponsor-item">
					  <a href="<?php the_field('url') ?>" title="<?php the_title(); ?>">
					  	<?php the_post_thumbnail('medium'); ?>
					  </a>
				  </div>
			<?php endwhile; ?>
		</div>
		<div class="back-to-top scroll-to-top"><a href="#header-section">back to top<i class="icon-arrow-up"></i></a></div>

		<h2 id="eas">Executive Appointment Service</h2>
		<div class="sponsor sponsor-eas">
			<?php
				$args = array(
					'post_type' => 'companies',
					'categories-companies'  => 'executive-appointment-service',
				);
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post(); ?>
				  <div class="sponsor-item">
					  <a href="<?php the_field('url') ?>" title="<?php the_title(); ?>">
					  	<?php the_post_thumbnail('medium'); ?>
					  </a>
				  </div>
			<?php endwhile; ?>
		</div>
		<div class="back-to-top scroll-to-top"><a href="#header-section">back to top<i class="icon-arrow-up"></i></a></div>

		<h2 id="media">Media Sponsors</h2>
		<div class="sponsor sponsor-media">
			<?php
				$args = array(
					'post_type' => 'companies',
					'categories-companies'  => 'media-sponsors',
				);
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post(); ?>
				  <div class="sponsor-item">
					  <a href="<?php the_field('url') ?>" title="<?php the_title(); ?>">
					  	<?php the_post_thumbnail('medium'); ?>
					  </a>
				  </div>
			<?php endwhile; ?>
		</div>
		<div class="back-to-top scroll-to-top"><a href="#header-section">back to top<i class="icon-arrow-up"></i></a></div>


		<?php the_content(); ?>

	<?php } ?>	

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

<?php get_footer(); ?>
