<?php 
	get_header(); 
	the_post();

	$portfolio_format = get_post_meta( $post->ID, '_cmb_the_portfolio_size', true );
	get_template_part( '/postformats/portfolio-' . $portfolio_format );

	get_footer(); 
?>