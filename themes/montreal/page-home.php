<?php
	/*
	Template Name: Homepage
	*/
	get_header(); 
	the_post();
	$option = get_option('montreal_theme_options'); 
	
	$images = array(
		get_post_meta( $post->ID, '_cmb_home_gallery1', true ), 
		get_post_meta( $post->ID, '_cmb_home_gallery2', true ),
		get_post_meta( $post->ID, '_cmb_home_gallery3', true ), 
		get_post_meta( $post->ID, '_cmb_home_gallery4', true ),
		get_post_meta( $post->ID, '_cmb_home_gallery5', true ), 
		get_post_meta( $post->ID, '_cmb_home_gallery6', true )
	); 
	$images = array_filter(array_map(NULL, $images)); 
?>

<div class="container slideshow" style="background:url(<?php echo $option['background_image_faded']; ?>);">
	<section class="row largepadding">
	<div class="six columns bigpadding intro">
		<div class="bigtoppadding whitetext"><?php the_content(); ?></div>
	</div>
	</section>
</div>

<script type="text/javascript">
	jQuery(window).load(function($){
					
		jQuery.supersized({
		
			// Functionality
			slideshow               :   1,			// Slideshow on/off
			autoplay				:	1,			// Slideshow starts playing automatically
			start_slide             :   1,			// Start slide (0 is random)
			stop_loop				:	0,			// Pauses slideshow on last slide
			random					: 	0,			// Randomize slide order (Ignores start slide)
			slide_interval          :   <?php echo get_post_meta( $post->ID, '_cmb_home_gallery_animation_delay', true ); ?>,		// Length between transitions
			transition              :   <?php echo get_post_meta( $post->ID, '_cmb_home_gallery_animation', true ); ?>, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
			transition_speed		:	1000,		// Speed of transition
			new_window				:	1,			// Image links open in new window/tab
			pause_hover             :   0,			// Pause slideshow on hover
			keyboard_nav            :   1,			// Keyboard navigation on/off
			performance				:	1,			// 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
			image_protect			:	1,			// Disables image dragging and right click with Javascript
													   
			// Size & Position						   
			min_width		        :   0,			// Min width allowed (in pixels)
			min_height		        :   0,			// Min height allowed (in pixels)
			vertical_center         :   1,			// Vertically center background
			horizontal_center       :   1,			// Horizontally center background
			fit_always				:	0,			// Image will never exceed browser width or height (Ignores min. dimensions)
			fit_portrait         	:   1,			// Portrait images will not exceed browser height
			fit_landscape			:   0,			// Landscape images will not exceed browser width
													   
			// Components							
			slide_links				:	'blank',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
			thumb_links				:	0,			// Individual thumb links for each slide
			thumbnail_navigation    :  0,			// Thumbnail navigation
			slides 					:  	[			// Slideshow Images
			
			<?php 
				$ebor_home_images = count($images); $ebor_i = 0;
				foreach ($images as $image) {
					echo (++$ebor_i === $ebor_home_images) ? '{image : "' . $image . '"}' : '{image : "' . $image . '"},';
				} 
			?>			
										],
										
			// Theme Options			   
			progress_bar			:	1,			// Timer for each slide							
			mouse_scrub				:	0
			
		});
		
	});
</script>

<?php if(get_post_meta( $post->ID, '_cmb_the_portfolio_switch', true ) !='on') : ?>
	<div class="smallpadding" style="background:url(<?php echo $option['background_image']; ?>);"></div>
	
		<div class="container white bigpadding">
			<section class="row smallbottompadding">
			<h3 class="blacktext bold midbottommargin center"><?php _e('OUR RECENT WORK','montreal'); ?></h3>
			<!-- BLACKHORIZONTAL -->
			<div class="three columns alpha centered blackhorizontal">
			</div>
			<div class="four columns centered smalltoppadding">
				<p class="center">
					<a class="smallfont greytext" href="<?php echo home_url('/portfolio'); ?>"><?php _e('VIEW ALL PORTFOLIO','montreal'); ?></a>
				</p>
			</div>
			</section>
			<!-- BASIC PORTFOLIO ITEM ROW -->
			<section class="row midbottompadding">
		
			<?php 
				$home_portfolio = new WP_Query('post_type=portfolio&posts_per_page=3'); 
				if( $home_portfolio->have_posts() ) : $counter = '0'; while( $home_portfolio->have_posts() ) : $home_portfolio->the_post(); 
				$counter++; 
			?>
				<div class="item four columns <?php if($counter == '1'){ echo 'alpha'; } ?>">
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
					<h5 class="blacktext extrabold smalltoppadding uppercase"><?php the_title(); ?><span class="right light">0<?php echo $counter; ?></span></h5>
					<h6 class="blacktext uppercase"><?php echo the_simple_terms(); ?></h6>
					<a href="<?php the_permalink(); ?>" class="blacktext smallfont"><?php echo $option['view_project']; ?></a>
				</div>
			<?php 
				endwhile; 
				endif; 
				wp_reset_query(); 
			?>
			
			</section>
		</div>
	
	<div class="smallpadding" style="background:url(<?php echo $option['background_image']; ?>);"></div>
<?php endif; ?>


<?php if(get_post_meta( $post->ID, '_cmb_the_quote_switch', true ) == 'on') : ?>
	<div class="container largepadding" style="background:url(<?php echo $option['background_image_faded']; ?>);">
		<section class="row bigpadding">

			<div class="alpha centered six columns whitehorizontal midmargin"></div>
	
				<div class="alpha eleven columns centered">
					<h2 class="italic center whitetext quote">"<?php echo get_post_meta( $post->ID, '_cmb_the_home_quote', true ); ?>"</h2>
				</div>
	
			<div class="alpha centered six columns whitehorizontal smallmargin"></div>
		
		</section>
	</div>
<?php endif; ?>


<?php if(get_post_meta( $post->ID, '_cmb_the_blog_switch', true ) !=='on') : ?>
	<div class="container midpadding" style="background:url(<?php echo $option['background_image']; ?>)">
	
		<section class="row midpadding white smallbottommargin">
		<h3 class="blacktext bold midmargin center"><?php _e('OUR RECENT NOTES','montreal'); ?></h3>
		<div class="three columns alpha centered blackhorizontal">
		</div>
		<div class="four columns centered smalltoppadding">
			<p class="center">
				<a class="smallfont greytext" href="
				<?php if( get_option( 'show_on_front' ) == 'page' ){
						echo get_permalink( get_option('page_for_posts' ) );
					} else {
						echo home_url(); 
					}?>"><?php _e('VIEW ALL NOTES','montreal'); ?></a>
			</p>
		</div>
		</section>
		
		<?php 
			$home_blog = new WP_Query('post_type=post&posts_per_page=3'); 
			if( $home_blog->have_posts() ) : while( $home_blog->have_posts() ) : $home_blog->the_post(); 
		?>
			<article <?php post_class('row blog white blogArticle'); ?>>
				<div class="eight columns centered">
	
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<h4 class="blacktext italic center"><?php the_title(); ?></h4>
					</a>
	
					<p class="center">
						<i class="icon-time greytext"></i>
						<a class="smallfont greytext" href="#"><?php the_time(get_option('date_format')); ?></a>
						&nbsp; &nbsp; <i class="greytext icon-folder-open"></i>
						<?php the_tags('',' / ',''); ?>
						&nbsp; &nbsp; <i class="greytext icon-link"></i>
						<a class="smallfont greytext" href="<?php the_permalink(); ?>"><?php _e('READ POST', 'montreal'); ?></a>
					</p>
					
				</div>
			</article>
		<?php 
			endwhile; 
			endif; 
			wp_reset_query(); 
		?>
		
	</div>
<?php endif; ?>

<?php if( function_exists('getTweets') ) : ?>
<?php if(get_post_meta( $post->ID, '_cmb_the_twitter_switch', true ) == 'on') : ?>
<div class="container white">
	<section class="row bigpadding">
	<h2 class="light blacktext center icon-twitter"></h2>
	<div class="alpha seven columns centered">
	
	<?php $tweets = getTweets(1, get_post_meta( $post->ID, '_cmb_the_home_twitter_id', true )); ?>
	<?php foreach($tweets as $tweet){
	
	    if($tweet['text']){
	        $the_tweet = $tweet['text'];
	
	        // i. User_mentions must link to the mentioned user's profile.
	        if(is_array($tweet['entities']['user_mentions'])){
	            foreach($tweet['entities']['user_mentions'] as $key => $user_mention){
	                $the_tweet = preg_replace(
	                    '/@'.$user_mention['screen_name'].'/i',
	                    '<a href="http://www.twitter.com/'.$user_mention['screen_name'].'" class="jta-tweet-a jta-tweet-link" target="_blank">@'.$user_mention['screen_name'].'</a>',
	                    $the_tweet);
	            }
	        }
	
	        // ii. Hashtags must link to a twitter.com search with the hashtag as the query.
	        if(is_array($tweet['entities']['hashtags'])){
	            foreach($tweet['entities']['hashtags'] as $key => $hashtag){
	                $the_tweet = preg_replace(
	                    '/#'.$hashtag['text'].'/i',
	                    '<a href="https://twitter.com/search?q=%23'.$hashtag['text'].'&src=hash" class="jta-tweet-a jta-tweet-link" target="_blank">#'.$hashtag['text'].'</a>',
	                    $the_tweet);
	            }
	        }
	
	        // iii. Links in Tweet text must be displayed using the display_url
	        //      field in the URL entities API response, and link to the original t.co url field.
	        if(is_array($tweet['entities']['urls'])){
	            foreach($tweet['entities']['urls'] as $key => $link){
	                $the_tweet = preg_replace(
	                    '`'.$link['url'].'`',
	                    '<a href="'.$link['url'].'" class="jta-tweet-a jta-tweet-link" target="_blank">'.$link['url'].'</a>',
	                    $the_tweet);
	            }
	        }
	    }
	} ?>
	
		<div class="tweet">
		<ul class="tweet_list">
		<li class="tweet_first tweet_odd">
		<span class="tweet_time">
		<a href="<?php echo 'https://twitter.com/YOURUSERNAME/status/'.$tweet['id_str']; ?>" title="view tweet on twitter"><?php echo date('h:i A M d',strtotime($tweet['created_at'] . '+ 1 hour')); ?></a>
		</span>
		<span class="tweet_text"><?php echo $the_tweet; ?></span>
		</li>
		</ul>
			
		</div>
		<a href="http://www.twitter.com/<?php echo get_post_meta( $post->ID, '_cmb_the_home_twitter_id', true ); ?>" class="blacktext">
			<h6 class="center bold meta uppercase"><?php echo get_post_meta( $post->ID, '_cmb_the_home_twitter_id', true ); ?></h6>
		</a>
		
	</div>
	</section>
</div>
<?php 
	endif;
	endif; 
	get_footer();