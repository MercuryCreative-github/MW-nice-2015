<?php 
	get_header(); 
	$option = get_option('montreal_theme_options'); 
?>

<div class="bigpadding" style="background:url(<?php echo $option['background_image']; ?>);"></div>

<div class="container white bigpadding">

	<section class="row">
		<h3 class="blacktext bold midbottommargin center uppercase"><?php _e('404, Page Not Found', 'montreal'); ?></h3>
		<div class="five columns alpha centered blackhorizontal">
		</div>
		<div class="four columns alpha centered midtopmargin">
			<p class="center meta">
				<?php echo __('Why not head back to our ', 'montreal').'<a href="' . home_url() . '">'.__('homepage', 'montreal').'</a>'; ?>
			</p>
		</div>
	</section>

</div>

<?php 
	get_footer();