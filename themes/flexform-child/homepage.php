<?php
/*
Template Name: Home Page
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

<!-- Full-width block re-using styles -->
<div class="top-sponsors-logos inner-page-wrap has-right-sidebar has-one-sidebar row clearfix">
	 <div class="span3 sponsors_title">
		<h3>Sponsors <br>announced:</h3>
	</div> 
	<div class=" sponsors_logo logo_1">
		<a target="_self" href="<?php the_field("sponsors_logo_1_link"); ?>"><img class="top-sponsor" src="<?php the_field("sponsors_logo_1"); ?>"></a>
		<div class="image-caption" style="opacity: 1;"><?php the_field("sponsor_logo_1_type"); ?></div>
	</div>
	<div class=" sponsors_logo logo_2">
		<a target="_self" href="<?php the_field("sponsors_logo_2_link"); ?>"><img class="top-sponsor" src="<?php the_field("sponsors_logo_2"); ?>"></a>
		<div class="image-caption" style="opacity: 1;"><?php the_field("sponsor_logo_2_type"); ?></div>
	</div>
	<div class=" sponsors_logo logo_3">
		<a target="_self" href="<?php the_field("sponsors_logo_3_link"); ?>"><img class="top-sponsor" src="<?php the_field("sponsors_logo_3"); ?>"></a>
		<div class="image-caption" style="opacity: 1;"><?php the_field("sponsor_logo_3_type"); ?></div>
	</div>
	<div class=" sponsors_logo logo_4">
		<a style="position:relative;" target="_self" href="<?php the_field("sponsors_logo_4_link"); ?>"><img class="top-sponsor" src="<?php the_field("sponsors_logo_4"); ?>"></a>
		<div class="image-caption" style="opacity: 1;"><?php the_field("sponsor_logo_4_type"); ?></div>
	</div>
</div>

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

		<aside class="sidebar right-sidebar span4">
			<!-- Video -->
			<div>
				<p><span style="color:#cea042;"><strong>Watch why you must attend DD14</strong></span></p>
			</div>
			<div>
				<iframe width="336" height="193" src="//www.youtube.com/embed/aYGuzAmfyCY" frameborder="0" allowfullscreen></iframe>
				</br>
				<a href="https://www.youtube.com/channel/UCLKFQ99UR0KRtF3BTQzurOw/videos" target="_blank">
					<p style="text-align: right; color: #b8b8b8;"><small>VIEW ALL VIDEOS ></small></p>
				</a>
			</div>
			</br>
			<!-- Start Feed -->
			<div class="inner-wrap" id="home-feed-inform">
					<?php
							include_once( ABSPATH . WPINC . '/feed.php' );

							/**
							* Recibo un item rss y limpia el formato para hacer más facil el print de los campos
							*/
							function limpiar_formato_feed($rss_item){
									$item = array();
									$item['link'] = $rss_item->get_link();
									$item['date'] = $rss_item->get_date('F j, Y');
									$item['title'] = $rss_item->get_title();
									$item['category'] = $rss_item->get_category()->get_label();
									$item['categories'] = $rss_item->get_categories();
									$item['image'] = null;
									$DOM = new DOMDocument();
									@$DOM->loadHTML($rss_item->get_description());
		

									$imagenes = $DOM->getElementsByTagName('img');
									$parrafos = $DOM->getElementsByTagName('p');
									$description = "";
									foreach($parrafos as $parrafo){
											$description = $description ."<p>".utf8_decode($parrafo->nodeValue)."</p>";
									}
									$pos = 80;
									if(strlen($description) > $pos){
											$pos = strpos($description, ' ', $pos);
									}
									$item['description'] = substr($description, 0, $pos)."...";

									$images=array();

									foreach ($imagenes as $element) {
										$toPush=$element->getAttribute('src');
										array_push($images,$toPush);
									}

									$item['image']=$images[0];

									return $item;
							}

							$cantidad_posts_feed = 4;
							$url_feed_inform = "http://inform.tmforum.org/tag/dd14/feed/";
							$feed_inform = fetch_feed($url_feed_inform);

							/** FEED INFORM **/
							if (!is_wp_error($feed_inform)) {
									$maxitems = $feed_inform->get_item_quantity($cantidad_posts_feed);
									$feed_items_inform = $feed_inform->get_items(0, $maxitems);
							}
							$items_feed = array();
							if(count($feed_items_inform) > 0) {
									foreach($feed_items_inform as $feed_item_inform) {
											$items_inform[] = limpiar_formato_feed($feed_item_inform);
									}
							}

					?>
					<?php if(count($items_inform) > 0) { ?>
						<section class="feed-related-posts">
							<div class="home-titles">
								<img src="/wp-content/uploads/2014/09/inform-imago.png">
								<h4>The Official Industry &amp;<br><strong> Digital Disruption News Source</strong></h4>
							</div>
							<!--- FEED INFORM -->
							<?php foreach($items_inform as $item){ ?>
								<article class="feed-item">
									<p class="feed-date-category">
										<span class="category"><?php echo $item['category']; ?></span>
										<span class="date"> / <?php echo $item['date']; ?></span>
									</p>
									<figure class="feed-image">
										<?php if($item['image']){ ?>
											<a href="<?php echo $item['link']; ?>" target="_blank">
												<img width="100%" src="<?php echo $item['image']; ?>" alt="<?php echo $item['title']; ?>" title="<?php echo $item['title']; ?>">
											</a>
										<?php } ?>
									</figure>
									<div class="feed-content">
										<a href="<?php echo $item['link']; ?>" target="_blank">
											<h4 class="feed-title"><?php echo $item['title']; ?></h4>
										</a>
									</div>
								</article>
								<?php } ?>
						</section>
					<?php } ?>
			<div class="latest-news">
				<a href="http://inform.tmforum.org/tag/DD14/" target="_blank" class="view-all">
					<span>Read <strong>latest news</strong> on </span>
					<img src="/wp-content/uploads/2014/09/TMForumInform_logo2.png">
				</a>
			</div>
			<div style="clear:both"></div>
			<!-- End Feed -->
			<?php dynamic_sidebar($right_sidebar); ?>
		</aside>

	<?php } else if ($sidebar_config == "both-sidebars") { ?>

		<aside class="sidebar right-sidebar span3">
			<?php dynamic_sidebar($right_sidebar); ?>
		</aside>

	<?php } ?>

</div>

<?php endif; ?>

<div class="responsive-sponsors">
	<!-- This block is used to move the Sponsors Logos on <768px-width screens.
	It is hidden on bigger screens by default.
	Uses a jQuery function called moveSponsors(); that you'll find in the /js/tmfcustom.js file. -->
	<div class="main-sponsors"></div>
	<div class="secondary-sponsors">
		<div class="title"></div>
		<div class="row1"></div>
		<div class="row2"></div>
	</div>
</div>

<!--// WordPress Hook //-->
<?php get_footer(); ?>
