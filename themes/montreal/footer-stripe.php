<?php 
	$option = get_option('montreal_theme_options'); 
?>

<footer class="black fixed">
	<div class="container">
		<section class="row smallpadding">
		
			<div class="three columns">
				<p class="greytext meta">
					© <?php echo date('Y'); ?> <a href="<?php echo home_url(); ?>" class="greytext meta"><?php echo bloginfo('name'); ?></a>
				</p>
			</div>
			
			<div class="six columns">
				<h6 class="space center whitetext meta fade"><?php _e('CLICK AND DRAG PORTFOLIO TO LEFT OR RIGHT', 'montreal'); ?></h6>
			</div>
				
			<div class="three columns right">
				<p class="meta">
					<?php if( $option['facebook_link'] !='' ) : ?><a href="<?php echo $option['facebook_link']; ?>" class="greytext"><?php _e('Facebook', 'montreal'); ?></a> / &nbsp; <?php endif; ?>
					<?php if( $option['twitter_link'] !='' ) : ?><a href="<?php echo $option['twitter_link']; ?>" class="greytext"><?php _e('Twitter', 'montreal'); ?></a> / &nbsp; <?php endif; ?>
					<?php if( $option['google_link'] !='' ) : ?><a href="<?php echo $option['google_link']; ?>" class="greytext"><?php _e('Google+', 'montreal'); ?></a><?php endif; ?>
				</p>
			</div>
			
		</section>
	</div>
</footer>

<?php 
	echo $option['google_analytics'];
	wp_footer(); 
?>

</body>
</html>