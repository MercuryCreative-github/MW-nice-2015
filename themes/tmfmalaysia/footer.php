<?php 
	$option = get_option('montreal_theme_options'); 
?>

<footer class="withe">
	<div class="container">
		<div class="row">
			<div class="footer-widgets-menu">
				<?php dynamic_sidebar( 'footer-menu' ); ?>
			</div>
		</div>
	</div>
</footer>
<footer class="black">
	<div class="container">
		<div class="row">
			<div class="footer-bottom twelve columns">
				<div class="footer-tmf-info">
					<img src="/wp-content/uploads/2014/07/tmforum-logo.png"/>
					<p class="greytext meta">
						 © 2015<!--<?php //echo date('Y'); ?>--> <a href="<?php echo home_url(); ?>" class="greytext meta"><?php echo bloginfo('name'); ?></a> <?php echo bloginfo('description'); ?>
					</p>
				</div>
                <div class="footer-buttons-widgets">
				                
                    <div id="text-6" class="three columns widget_text">			
                
                        <div class="textwidget">
                        <ul>
                        <li class="button register">
                        <a id="register" target="_blank">REGISTER</a>
                        </li>
                        </ul>
                        </div>
                
              		</div>
                      
                    <div id="text-12" class="three columns widget_text">			
                    
                        <div class="textwidget">
                        
                        <ul>
                        <li class="button register updated">
                        <a id="updated" style="cursor: pointer;">KEEP UPDATED</a>
                        </li>
                        </ul>
                
                        </div>
                	</div>
                    				
                </div>
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