<?php
	/*
	Template Name: Page With Sidebar
	*/
	get_header(); 
	the_post(); 
	global $post; 
	$option = get_option('montreal_theme_options'); 
?>

<div class="bigpadding" style="background:url(<?php echo $option['background_image']; ?>);"></div>

<div class="container white bigpadding">
	
		<section class="row bigtoppadding the-content">
			
			<article <?php post_class('seven columns blogpost'); ?> style="padding-top: 0;">
			
				<section class="row">
				<?php the_title('<h3 class="blacktext bold midbottommargin center uppercase">', '</h3>'); ?>
				<div class="eight columns alpha centered blackhorizontal"></div>
				<div class="eight columns alpha centered midtopmargin">
					<p class="center meta">
						<?php echo get_post_meta( $post->ID, '_cmb_the_subtitle', true ); ?>
					</p>
				</div>
				</section>
				
				<?php the_content(); ?>
				
			</article>
			
			<?php get_sidebar(); ?>
			
		</section>

</div><!-- end of #container -->

<?php 
	get_footer();