<?php
	/*
	Template Name: TM Forum Live 2015
	*/
	get_header(); 
	the_post();
	$option = get_option('montreal_theme_options'); 
	
?>

<div class="container slideshow">

<div class="container slideshow" style="background-position: right 120px;background-image: url(http://tmforumlive15.staging.wpengine.com/wp-content/uploads/2014/06/TMForumLive2015EyeCandy-2.jpg);
background-size: cover;border: none;background-repeat: no-repeat; background-color: #012332;">
<div class="container slideshow">
		<section class="row largepadding">
	<div class="twelve columns intro">
		<div class="whitetext">

<div class="wpb_row vc_row-fluid">
	<div class="vc_span12 home_slider wpb_column column_container">
		<div class="wpb_wrapper">
			
	<div class="wpb_single_image wpb_content_element vc_align_center">
		<div class="wpb_wrapper">
		<img width="593" height="375" src="<?php the_field("home_page_intro_logo"); ?>" class="vc_box_border_grey attachment-full" alt="Hola">	
					

</div> 
	</div> 
	<div class="wpb_text_column wpb_content_element ">
		<div class="wpb_wrapper">
			<?php the_field("home_page_intro_text"); ?>

		</div> 
	</div> 
		</div> 
	</div> 
</div>


		</div>
	</div>
	</section>
</div>

<div class="container white bigpadding">
<section <?php post_class('row the-content'); ?>>
		<?php the_content(); ?>
</section>
</div>

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