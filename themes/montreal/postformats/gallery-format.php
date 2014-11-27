<?php 
	global $post; 
?>

<div class="flexslider">
	<ul class="slides">
		<?php 
			$images = array(
				get_post_meta( $post->ID, '_cmb_gallery1', true ),
				get_post_meta( $post->ID, '_cmb_gallery2', true ),
				get_post_meta( $post->ID, '_cmb_gallery3', true ),
				get_post_meta( $post->ID, '_cmb_gallery4', true ),
				get_post_meta( $post->ID, '_cmb_gallery5', true ),
				get_post_meta( $post->ID, '_cmb_gallery6', true ),
				get_post_meta( $post->ID, '_cmb_gallery7', true ),
				get_post_meta( $post->ID, '_cmb_gallery8', true )
			);
			$images = array_filter(array_map(NULL, $images));
			
			foreach ($images as $image ){
				echo '<li><img src="'.$image.'" alt="'.get_the_title().'"></li>';
			}
		?>
	</ul>
</div>