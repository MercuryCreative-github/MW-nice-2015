<?php
/*
Template Name: Home Page at the Event
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

<section id="hp-section" class="hp-section02">
<div class="cell">
<div class="sec-main-content">
<div class="section02">
<div>
<h1>FEATURE VIDEO</h1>
</div>
<div>
<!-- feed for feature video -->
			<?php

			include_once( ABSPATH . WPINC . '/feed.php' );

			// Get a SimplePie feed object from the specified feed source.
			$rss = fetch_feed( 'http://inform.tmforum.org/featured-video-2/' );

			if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly

			    // Figure out how many total items there are, but limit it to 5. 
			    $maxitems = $rss->get_item_quantity( 1 ); 

			    // Build an array of all the items, starting with element 0 (first element).
			    $rss_items = $rss->get_items( 0, $maxitems );

			
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

			              	$items_video_inform_feature[]=array(
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
			
					<?php if(isset($items_video_inform_feature) && count($items_video_inform_feature) > 0) { ?>
					<div class="feture-video-active">
						<?php foreach($items_video_inform_feature as $item){ ?>
									<?php if($item['video']){ ?>
										<?php echo $item['video']; ?>
									<?php } ?>
						<?php } ?>
					</div>
					<?php } ?>
			<div style="clear:both"></div>

			<?php endif; ?>
			<!-- End -->

</div>
</div>
</div>
</div>
</section>

<section id="hp-section" class="hp-section03">
		<div class="sec-main-content">		
			<div class="inform-feed-videos">
				<div class="inform-logo"><img src="/wp-content/uploads/2015/05/TMForumInform_logo2.png"/></div>
				<div class="btn-view-more"><a class="sf-button medium orange standard" href="http://inform.tmforum.org/tm-forum-live-videos/" target="_blank">VIEW ALL VIDEOS</a></div>
				<div class="clear"></div>
			<!-- Feed inform videos -->
			<?php

			include_once( ABSPATH . WPINC . '/feed.php' );

			// Get a SimplePie feed object from the specified feed source.
			$rss = fetch_feed( 'http://inform.tmforum.org/tm-forum-live-videos-1/' );

			if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly

			    // Figure out how many total items there are, but limit it to 5. 
			    $maxitems = $rss->get_item_quantity( 4 ); 

			    // Build an array of all the items, starting with element 0 (first element).
			    $rss_items = $rss->get_items( 0, $maxitems );

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

			              	$items_video_inform_live[]=array(
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
			
					<?php if(isset($items_video_inform_live) && count($items_video_inform_live) > 0) { ?>
					<div class="inform-all-videos">
						<?php foreach($items_video_inform_live as $item){ ?>
							<div class="inform-video">
								<figure class="feed-image">
									<?php if($item['video']){ ?>
										<?php echo $item['video']; ?>
									<?php } ?>
								</figure>
								<div class="feed-content">
										<a href="<?php echo $item['link']; ?>" target="_blank">
											<p class="feed-title-event"><?php echo $item['title']; ?></p>
										</a>
								</div>
							</div>
						<?php } ?>
					</div>
					<?php } ?>
			<div style="clear:both"></div>
			<?php endif; ?>
			<!-- End -->
			</div>
			
			<div class="twitter-feed">	
				<div id='twitter_widget' class='widget twitter_widget'>
			    	<div class="widget-heading clearfix">
						<h2 class="tw-title">Latest on Twitter</h2>
	            		<!--script>[CBC country="cn" show="n"]</script-->
	           			<a class="twitter-timeline" width"100%" height="380" href="https://twitter.com/tmforumorg" data-widget-id="365265624051617792" data-chrome="noheader transparent" data-link-color="#338ECC" data-border-color="#ffffff" data-tweet-limit="4" data-src-2x="false" data-src="false" >
	               		Tweets by @tmforumorg
	            		</a> 
				           <script>
				               !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
				           </script>
	            		<!--script> [/CBC] </script-->
	            		<div class="clear"></div>    
					</div>
				</div>
			</div>
		</div>
</section>

<section id="hp-section" class="section04">
	<div class="sec-main-content">
	<div class="section04-header">
		<div class="inform-logo"><img src="/wp-content/uploads/2015/05/TMForumInform_logo2.png"/><h1> //LIVE! News</h1><div class="clear"></div></div>
		<div class="btn-view-more"><a class="sf-button medium orange standard" href="http://inform.tmforum.org/tag/tm-forum-live-2015/" target="_blank">SEE ALL NEWS</a></div>
		<div class="clear"></div>
	</div>
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
									if(!empty($images))
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
								<article class="feed-item feed-event">
								<figure class="feed-image">
										<?php if($item['image']){ ?>
											<a href="<?php echo $item['link']; ?>" target="_blank">
												<img width="100%" src="<?php echo $item['image']; ?>" alt="<?php echo $item['title']; ?>" title="<?php echo $item['title']; ?>">
											</a>
										<?php } ?>
									</figure>
									<div class="feed-content">
										<p class="feed-author"><?php echo $item['author']; ?></p>
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

<div class="feed-press">
	
		<div class="inform-feed press-releases">
			<h1>//Press Releases
			<a 	class="sf-button medium orange standard right" 
				href="http://inform.tmforum.org/category/tm-forum-press-releases/" 
				target="_blank">VIEW ALL
			</a>
			</h1>

			<!-- Start Feed -->
			<div class="inner-wrap" id="home-feed-inform">
					<?php
							include_once( ABSPATH . WPINC . '/feed.php' );
							/**
							* Recibo un item rss y limpia el formato para hacer más facil el print de los campos
							*/
							function releases_formato_feed($rss_item){

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
									if(!empty($images))
									$item['image']=$images[0];

									return $item;
							}
							$cantidad_posts_feed = 2;
							$url_feed_inform = "http://inform.tmforum.org/category/tm-forum-press-releases/feed/";
							$feed_inform = fetch_feed($url_feed_inform);

							/** FEED INFORM **/

							$feed_items_inform = array();

							if (!is_wp_error($feed_inform)) {
									$maxitems = $feed_inform->get_item_quantity($cantidad_posts_feed);
									$feed_items_inform = $feed_inform->get_items(0, $maxitems);
							}

							$items_feed = array();
							if(count($feed_items_inform) > 0) {
									foreach($feed_items_inform as $feed_item_inform) {
											$items_releases[] = releases_formato_feed($feed_item_inform);
									}
							}
					?>
					<?php if(count($items_releases) > 0) { ?>
						<section class="feed-related-posts">
							<!--- FEED INFORM -->
							<?php foreach($items_releases as $item){ ?>
								<article class="feed-item feed-event">
								<figure class="feed-image">
										<?php if($item['image']){ ?>
											<a href="<?php echo $item['link']; ?>" target="_blank">
												<img width="100%" src="<?php echo $item['image']; ?>" alt="<?php echo $item['title']; ?>" title="<?php echo $item['title']; ?>">
											</a>
										<?php } ?>
									</figure>
									<div class="feed-content">
										<p class="feed-author"><?php echo $item['author']; ?></p>
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
	<div class="inform-feed press-coverage">
			<h1>//Press Coverage
				<a 	class="sf-button medium orange standard right" 
					href="http://inform.tmforum.org/category/tmforum-live-press-coverage/" 
					target="_blank">VIEW ALL
				</a>
			</h1>


			<!-- Start Feed -->
			<div class="inner-wrap" id="home-feed-inform">
					<?php
							include_once( ABSPATH . WPINC . '/feed.php' );
							/**
							* Recibo un item rss y limpia el formato para hacer más facil el print de los campos
							*/
							function coverage_formato_feed($rss_item){

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

									if(!empty($images))
									$item['image']=$images[0];

									return $item;
							}
							$cantidad_posts_feed = 2;
							$url_feed_inform = "http://inform.tmforum.org/category/tmforum-live-press-coverage/feed/";
							$feed_inform = fetch_feed($url_feed_inform);

							/** FEED INFORM **/
							$feed_items_inform = array();

							if (!is_wp_error($feed_inform)) {
									$maxitems = $feed_inform->get_item_quantity($cantidad_posts_feed);
									$feed_items_inform = $feed_inform->get_items(0, $maxitems);
							}

							$items_feed = array();
							if(count($feed_items_inform) > 0) {
									foreach($feed_items_inform as $feed_item_inform) {
											$items_coverage[] = coverage_formato_feed($feed_item_inform);
									}
							}
					?>
					<?php if(count($items_coverage) > 0) { ?>
						<section class="feed-related-posts">
							<!--- FEED INFORM -->
							<?php foreach($items_coverage as $item){ ?>
								<article class="feed-item feed-event">
								<figure class="feed-image">
										<?php if($item['image']){ ?>
											<a href="<?php echo $item['link']; ?>" target="_blank">
												<img width="100%" src="<?php echo $item['image']; ?>" alt="<?php echo $item['title']; ?>" title="<?php echo $item['title']; ?>">
											</a>
										<?php } ?>
									</figure>
									<div class="feed-content">
										<p class="feed-author"><?php echo $item['author']; ?></p>
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

<section id="hp-section" class="section05">
<div class="sec-main-content">
	
<div class="hp-banner-app">
	<div class="app-logo"><img src="/wp-content/uploads/2015/05/logo-app-hp.png"></div>
	<div class="app-info">
		<div class="app-qr"><img src="/wp-content/uploads/2015/05/QR.jpg"></div>
		<div class="app-sponsor">Sponsored by<br/><img src="/wp-content/uploads/2015/05/app-solvatio.png"></div>
	</div>
</div>
<div class="clear"></div>
</div>
</section>

<section id="hp-section" class="section06">
	<div class="sec-main-content">
		<div class="keynote-video-feed"><!-- Start Feed -->
			<div class="inner-wrap" id="home-feed-keynote-video">
			<?php

			include_once( ABSPATH . WPINC . '/feed.php' );

			// Get a SimplePie feed object from the specified feed source.
			$rss = fetch_feed( 'http://inform.tmforum.org/keynotes-videos/' );

			if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly

			    // Figure out how many total items there are, but limit it to 5. 
			    $maxitems = $rss->get_item_quantity( 4 ); 

			    // Build an array of all the items, starting with element 0 (first element).
			    $rss_items = $rss->get_items( 0, $maxitems );

			endif;
			?>

			
			<ul>
			    <?php if ( $maxitems == 0 ) : ?>
			        <li><?php _e( 'No items', 'my-text-domain' ); ?></li>
			    <?php else : ?>
			        <?php // Loop through each feed item and display each item as a hyperlink. ?>
			         <?php if(is_array($rss_item)) ?>
			        <?php foreach ( $rss_items as $item ) : ?>
			            <li>
			              <?php 
			              	$data = $item->data;

			              	$video = $data['child']['']['video'][0]['data'];

			              	$items_video_keynotes[]=array(
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
			
					<?php if(count($items_video_keynotes) > 0) { ?>
					<div class="watch-keynote-videos">
						<h1>WATCH KEYNOTES ON REPLAY <a class="sf-button medium orange standard right" href="/streaming-keynotes-live/" target="_blank">VIEW MORE</a></h1>
						<ul>
							<!--- FEED INFORM -->
							<?php foreach($items_video_keynotes as $item){ ?>
								<li class="keynote-video">
									<figure class="feed-image">
										<?php if($item['video']){ ?>
											<?php echo $item['video']; ?>
										<?php } ?>
									</figure>
									<div class="feed-content">
										<a href="<?php echo $item['link']; ?>" target="_blank">
											<p class="feed-title-event"><?php echo $item['title']; ?></p>
										</a>
									</div>
								</li>
								<?php } ?>
							</ul>
						</div>
					<?php } ?>
			<div style="clear:both"></div>
			<!-- End Feed -->
			</div>
		</div>
	</div>
</section>


<!--// WordPress Hook //-->
<?php get_footer(); ?>