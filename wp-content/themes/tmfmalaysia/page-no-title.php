<?php 

	/*
	Template Name: TM Forum Malaysia No Title
	*/ 

	get_header();
	the_post(); 
	$option = get_option('montreal_theme_options'); 
?>

<div class="bigpadding" style="background:url(<?php echo $option['background_image']; ?>);"></div>

<div class="container white">


	
	<section <?php post_class('row bigtoppadding the-content'); ?>>
		<?php the_content(); ?>
	</section>

</div>

<?php 
	get_footer();



