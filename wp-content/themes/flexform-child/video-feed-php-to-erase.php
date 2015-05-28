<?php
/*
Template Name: Home Page at the Event2
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

<style type="text/css">
	.page-template-homepageattheevent-php #main-container .container{
	    margin: 0;
	    padding: 0;
	    width: 100%!important;
    }	.page-template-homepageattheevent-php #main-container section{
	    display: table;  width:100%;
    }
    }.page-template-homepageattheevent-php #main-container section>div.cell{
	    display: table-cell;
	    vertical-align: middle;
	    width:100%;
    }

</style>
<!-- Full-width block re-using styles -->
<div class="inner-page-wrap has-right-sidebar has-one-sidebar row clearfix" style="padding: 0;margin: 0;">


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
	<?php } else if ($sidebar_config == "both-sidebars") { ?>

		<aside class="sidebar right-sidebar span3">
			<?php dynamic_sidebar($right_sidebar); ?>
		</aside>

	<?php } ?>

</div>

<?php endif; ?>





<section id="hp-section" class="section04">
	<div class="sec-main-content">

	<div class="inform-feed press-coverage">
			<!-- Start Feed -->
			<div class="inner-wrap" id="home-feed-inform">
					<?php


			include_once( ABSPATH . WPINC . '/feed.php' );

			// Get a SimplePie feed object from the specified feed source.
			$rss = fetch_feed( 'http://tmforum.staging.wpengine.com/video-feed-5/' );

			if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly

			    // Figure out how many total items there are, but limit it to 5. 
			    $maxitems = $rss->get_item_quantity( 5 ); 

			    // Build an array of all the items, starting with element 0 (first element).
			    $rss_items = $rss->get_items( 0, $maxitems );

			endif;
			?>

			<ul>
			    <?php if ( $maxitems == 0 ) : ?>
			        <li><?php _e( 'No items', 'my-text-domain' ); ?></li>
			    <?php else : ?>
			        <?php // Loop through each feed item and display each item as a hyperlink. ?>
			        <?php foreach ( $rss_items as $item ) : ?>
			            <li>
			              <?php 
			              	$data = $item->data;

			              	$video = $data['child']['']['video'][0]['data'];

			              	$items_coverage[]=array(
			              		'link'=> $item->get_link(),
			              		'video'=> $video,
			              		'description' => esc_html( $item->get_description() ),
			              		'title' => esc_html( $item->get_title() ),
			              		)
			              	
			              ?>
			            </li>
			        <?php endforeach; ?>
			    <?php endif; ?>
			</ul>

			<?php 
			echo "<pre>";
			var_dump($items_coverage);
			echo "</pre>"; 
			?>		

					<?php if(count($items_coverage) > 0) { ?>
						<section class="feed-related-posts">
							<!--- FEED INFORM -->
							<?php foreach($items_coverage as $item){ ?>
								<article class="feed-item feed-event">
								<figure class="feed-image">
										<?php if($item['video']){ ?>
											<a href="<?php echo $item['link']; ?>" target="_blank">
												<?php echo $item['video']; ?>
											</a>
										<?php } ?>
									</figure>
									<div class="feed-content">
										<p class="feed-author"><?php echo $item['description']; ?></p>
										<?php echo $item['title']; ?>
										<a href="<?php echo $item['link']; ?>" target="_blank">
											<p class="feed-title-event"><?php echo $item['title']; ?></p>
										</a>
									</div>
								</article>
								<?php } ?>
						</section>
					<?php } ?>
			<div style="clear:both"></div>
			<!-- End Feed -->
		</div>
	</div>
</div>
	</div>
</section>

