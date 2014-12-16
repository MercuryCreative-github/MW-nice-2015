<?php 
	$option = get_option('montreal_theme_options'); 
?>

<footer class="black">
	<div class="container">
	
		<div class="row bigtoppadding">
			<?php dynamic_sidebar( 'footer-widgets' ); ?>
		</div>
		
		<div class="greyhorizontal midmargin"></div>
		
		<div class="row">
		
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 3444288e90b247662206560f83abce370fc36145
			<div class="four columns">
				<p class="greytext meta">
					 © <?php echo date('Y'); ?> <a href="<?php echo home_url(); ?>" class="greytext meta"><?php echo bloginfo('name'); ?></a> <?php echo bloginfo('description'); ?>
				</p>
			</div>
			
			<div class="five columns">
				<div class="meta">
					<?php wp_nav_menu( array( 'menu_id' => '', 'theme_location' => 'footer', 'container' => 'false' ) ); ?>
				</div>
			</div>
			
			<div class="three columns right">
				<p class="meta">
					<?php if( $option['facebook_link'] !='' ) : ?><a href="<?php echo $option['facebook_link']; ?>" class="greytext" target="_blank"><?php _e('Facebook', 'montreal'); ?></a> / &nbsp; <?php endif; ?>
					<?php if( $option['twitter_link'] !='' ) : ?><a href="<?php echo $option['twitter_link']; ?>" class="greytext" target="_blank"><?php _e('Twitter', 'montreal'); ?></a> / &nbsp; <?php endif; ?>
					<?php if( $option['google_link'] !='' ) : ?><a href="<?php echo $option['google_link']; ?>" class="greytext" target="_blank"><?php _e('Google+', 'montreal'); ?></a><?php endif; ?>
				</p>
			</div>
			
<<<<<<< HEAD
=======
			<div class="six columns">
				<p class="greytext meta">
					 © <?php echo date('Y'); ?> <a href="<?php echo home_url(); ?>" class="greytext meta"><?php echo bloginfo('name'); ?></a> <?php echo bloginfo('description'); ?>
				</p>
			</div>	
>>>>>>> master
=======
>>>>>>> 3444288e90b247662206560f83abce370fc36145
		</div>
		
	</div>
</footer>

<?php 
	echo $option['google_analytics'];
	wp_footer(); 
?>

</body>
</html>