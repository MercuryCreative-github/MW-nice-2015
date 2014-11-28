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
		
			<div class="six columns">
				<p class="greytext meta">
					 © <?php echo date('Y'); ?> <a href="<?php echo home_url(); ?>" class="greytext meta"><?php echo bloginfo('name'); ?></a> <?php echo bloginfo('description'); ?>
				</p>
			</div>	
		</div>
		
	</div>
</footer>

<?php 
	echo $option['google_analytics'];
	wp_footer(); 
?>

</body>
</html>