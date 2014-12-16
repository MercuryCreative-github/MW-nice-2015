<?php 
	/////////////////////////////////////////////
	////////FILTERS, ACTIONS & HOOKS////////////
	///////////////////////////////////////////
	
	function custom_excerpt_length( $length ) {
		return 20;
	}
	add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
	
	function new_excerpt_more( $more ) {
		return '...';
	}
	add_filter('excerpt_more', 'new_excerpt_more');
	
	function xf_tag_cloud($tag_string){
		return preg_replace("/style='font-size:.+pt;'/", '', $tag_string);
	}
	add_filter('wp_generate_tag_cloud', 'xf_tag_cloud',10,3);
	
	add_filter('widget_text', 'do_shortcode');