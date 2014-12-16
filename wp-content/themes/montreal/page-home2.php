<?php
	/*
	Template Name: Homepage2
	*/
	get_header(); 
	the_post();
	$option = get_option('montreal_theme_options'); 
	
	$images = array(
		get_post_meta( $post->ID, '_cmb_home_gallery1', true ), 
		get_post_meta( $post->ID, '_cmb_home_gallery2', true ),
		get_post_meta( $post->ID, '_cmb_home_gallery3', true ), 
		get_post_meta( $post->ID, '_cmb_home_gallery4', true ),
		get_post_meta( $post->ID, '_cmb_home_gallery5', true ), 
		get_post_meta( $post->ID, '_cmb_home_gallery6', true )
	); 
	$images = array_filter(array_map(NULL, $images)); 
?>

<div class="container slideshow" style="background:url(<?php echo $option['background_image_faded']; ?>);">
	<section class="row largepadding">
	<div class="six columns bigpadding intro">
		<div class="bigtoppadding whitetext"><?php the_content(); ?></div>
	</div>
	</section>
</div>

<script type="text/javascript">
	jQuery(window).load(function($){
					
		jQuery.supersized({
		
			// Functionality
			slideshow               :   1,			// Slideshow on/off
			autoplay				:	1,			// Slideshow starts playing automatically
			start_slide             :   1,			// Start slide (0 is random)
			stop_loop				:	0,			// Pauses slideshow on last slide
			random					: 	0,			// Randomize slide order (Ignores start slide)
			slide_interval          :   <?php echo get_post_meta( $post->ID, '_cmb_home_gallery_animation_delay', true ); ?>,		// Length between transitions
			transition              :   <?php echo get_post_meta( $post->ID, '_cmb_home_gallery_animation', true ); ?>, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
			transition_speed		:	1000,		// Speed of transition
			new_window				:	1,			// Image links open in new window/tab
			pause_hover             :   0,			// Pause slideshow on hover
			keyboard_nav            :   1,			// Keyboard navigation on/off
			performance				:	1,			// 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
			image_protect			:	1,			// Disables image dragging and right click with Javascript
													   
			// Size & Position						   
			min_width		        :   0,			// Min width allowed (in pixels)
			min_height		        :   0,			// Min height allowed (in pixels)
			vertical_center         :   1,			// Vertically center background
			horizontal_center       :   1,			// Horizontally center background
			fit_always				:	0,			// Image will never exceed browser width or height (Ignores min. dimensions)
			fit_portrait         	:   1,			// Portrait images will not exceed browser height
			fit_landscape			:   0,			// Landscape images will not exceed browser width
													   
			// Components							
			slide_links				:	'blank',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
			thumb_links				:	0,			// Individual thumb links for each slide
			thumbnail_navigation    :  0,			// Thumbnail navigation
			slides 					:  	[			// Slideshow Images
			
			<?php 
				$ebor_home_images = count($images); $ebor_i = 0;
				foreach ($images as $image) {
					echo (++$ebor_i === $ebor_home_images) ? '{image : "' . $image . '"}' : '{image : "' . $image . '"},';
				} 
			?>			
										],
										
			// Theme Options			   
			progress_bar			:	1,			// Timer for each slide							
			mouse_scrub				:	0
			
		});
		
	});
</script>

	get_footer();