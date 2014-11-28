<?php
	/*
	Template Name: Thanks
	*/
	get_header(); 
	the_post(); 
	$option = get_option('montreal_theme_options'); 
?>

<div class="container bigpadding" style="background:url(<?php echo $option['background_image']; ?>);"></div>

<div class="container white bigpadding">

	<section class="row largepadding">
		<div <?php post_class('eight columns centered'); ?>>
			<h2 class="center italic midbottompadding"><?php the_title(); ?></h2>
			<p class="center meta">
				<?php the_content(); ?>
			</p>
		</div>
	</section>
	
</div>

<?php 
	get_footer();