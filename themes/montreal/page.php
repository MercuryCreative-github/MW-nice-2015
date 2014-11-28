<?php 
	get_header();
	the_post(); 
	$option = get_option('montreal_theme_options'); 
?>

<div class="bigpadding" style="background:url(<?php echo $option['background_image']; ?>);"></div>

<div class="container white bigpadding">

	<section class="row">
	
		<?php the_title('<h3 class="blacktext bold midbottommargin center uppercase">', '</h3>'); ?>
		
		<div class="five columns alpha centered blackhorizontal"></div>
		
		<div class="four columns alpha centered midtopmargin">
			<p class="center meta">
				<?php echo get_post_meta( $post->ID, '_cmb_the_subtitle', true ); ?>
			</p>
		</div>
		
	</section>
	
	<section <?php post_class('row bigtoppadding the-content'); ?>>
		<?php the_content(); ?>
	</section>

</div>

<?php 
	get_footer();