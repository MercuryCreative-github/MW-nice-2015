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

<style type="text/css">
	.page-template-homepage-php #main-container .container{
	    margin: 0;
	    padding: 0;
	    width: 100%!important;
    }	.page-template-homepage-php #main-container section{
	    display: table;  width:100%;
    }
    }.page-template-homepage-php #main-container section>div.cell{
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
	<div class="cell">
	<div class="sec-main-content">
	<div class="section04-title"><h1>THE BUZZ</h1></div>
	<div class="section04-info">
		<div class="inform-feed">

						<!-- Start Feed -->
			<div class="inner-wrap" id="home-feed-inform">
					<?php
							include_once( ABSPATH . WPINC . '/feed.php' );

							/**
							* Recibo un item rss y limpia el formato para hacer más facil el print de los campos
							*/
							function limpiar_formato_feed($rss_item){

									$item = array();
									$item['link'] 	= $rss_item->get_link();
									$item['title'] 	= $rss_item->get_title();

									if ($author = $rss_item->get_author()){
											$item['author'] = $author->get_name();
									}else {$item['author'] ="";}

									$item['image'] 	= null;
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
							$url_feed_inform = "http://inform.tmforum.org/tag/tm-forum-live-2015/feed/";
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
							<!--- FEED INFORM -->
							<?php foreach($items_inform as $item){ ?>
								<article class="feed-item">
								<figure class="feed-image">
										<?php if($item['image']){ ?>
											<a href="<?php echo $item['link']; ?>" target="_blank">
												<img width="100%" src="<?php echo $item['image']; ?>" alt="<?php echo $item['title']; ?>" title="<?php echo $item['title']; ?>">
											</a>
										<?php } ?>
									</figure>
									<div class="feed-content">
									<p class="feed-author">

									<?php echo $item['author']; ?>

									</p>
										<a href="<?php echo $item['link']; ?>" target="_blank">
											<h4 class="feed-title"><?php echo $item['title']; ?></h4>
										</a>
										<div class="feed-content-text">
										<!--a href="<?php echo $item['link']; ?>" target="_blank">
										<p><?php echo $item['description']; ?></p>
										</a-->
									</div>
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
	<div class="twitter-feed">

<div id='twitter_widget' class='widget twitter_widget'>
            <div class="widget-heading clearfix">
                        <h2 class="tw-title">Latest on Twitter</h2>
                        <a class="twitter-timeline" width"100%" height="380" href="https://twitter.com/tmforumorg" data-widget-id="365265624051617792" data-chrome="noheader transparent" data-link-color="#338ECC" data-border-color="#ffffff" data-tweet-limit="4" data-src-2x="false" data-src="false" >
                            Tweets by @tmforumorg
                        </a>
                        <script>
                        !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
                    </script>
                </div>
            </div>
            <div class="clear"></div>

		</div>
	</div>
	</div>
</section>

<section id="hp-section" class="section05">
<div class="sec-main-content">
	<div class="section05-title"><h1>THE REVIEWS</h1></div>

	<ul class="reviews">
		<li>
			<div class="review-photo"><img src="/wp-content/uploads/2015/02/wolfgang-gentzsch.png"></div>
			<div class="review-content">
				<div class="review-text">“I was very impressed by the large number of IT and business leaders, and many of the presentations have left a permanent impression. The large number of IT celebrities around the world stood out. I can’t wait to come to Nice again next year!”</div>
				<div class="review-name"><img src="/wp-content/uploads/2015/02/icon-reviews.png"><p><strong>Wolfgang Gentzsch</strong><br/>CEO, The UberCloud</p></div>
			</div>
		</li>
		<li>
			<div class="review-photo"><img src="/wp-content/uploads/2015/02/ulf_sm.gif"></div>
			<div class="review-content">
				<div class="review-text">"This year at TM Forum Live!, there are more participants than ever from other industries wanting to know what telecom networks can do for them. And that is happening because cloud, mobility and broadband are transforming their businesses.”</div>
				<div class="review-name"><img src="/wp-content/uploads/2015/02/icon-reviews.png"><p><strong>Ulf Ewaldsson</strong><br/>SVP and CTO, Ericsson</p></div>
			</div>
		</li>
		<li>
			<div class="review-photo"></div>
			<div class="review-content">
				<div class="review-text">“Congrats on the 2014 event, the thematic was very well received and the event meticulously organized, great feedback from attendees, vendors and industry icons alike. The future looks bright!”</div>
				<div class="review-name"><img src="/wp-content/uploads/2015/02/icon-reviews.png"><p>CIO, Global Digital Service Provider</p></div>
			</div>
		</li>
	</ul>



</div>
</section>




<!--// WordPress Hook //-->
<?php get_footer(); ?>
