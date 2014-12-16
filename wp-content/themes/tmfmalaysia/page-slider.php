<?php
	/*
	Template Name: TM Forum Malaysia Slider
	*/
	get_header(); 
	the_post();
	$option = get_option('montreal_theme_options'); 
	$images = array(
		get_post_meta( $post->ID, '_cmb_home_gallery1', true ), 
	); 
	$images = array_filter(array_map(NULL, $images)); 
?>

<div class="container slideshow" style="background:url(<?php echo get_the_post_thumbnail( $post_id, full ); ?> );">
	<section class="row largepadding">	
			<div class="whitetext">
				<div class="wpb_row vc_row-fluid">
					<div class="vc_span12 home_slider wpb_column column_container">
						<div class="wpb_wrapper">	
							<h1><?php the_field("home_page_intro_text"); ?></h1>
						</div> 
					</div> 
				</div>
			</div>
	</section>
</div>

<div class="container white bigpadding">
<section <?php post_class('row the-content'); ?>>
		<?php the_content(); ?>
</section>
</div>