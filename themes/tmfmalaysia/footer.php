<?php 
	$option = get_option('montreal_theme_options'); 
?>

<footer class="black">
	<div class="container">
	
<!-- 		<div class="rowfix clearfix" style="padding: 20px 0;">
				<?php dynamic_sidebar( 'footer-widgets' ); ?>
		</div>  -->
		
		
		
		<div class="row">
		
			<div class="rowfix">
				<img class="footer-logo" src="/wp-content/uploads/2014/07/logo-footer.png"/>
				<p class="greytext meta">
					© <?php echo date('Y'); ?> <a href="<?php echo home_url(); ?>" class="greytext meta"><?php echo bloginfo('name'); ?></a> TM Forum Live! Digital Disruption  <!--<?php //echo bloginfo('description'); ?>-->
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