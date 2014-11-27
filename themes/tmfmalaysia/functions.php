<?php

// Menu

// Add Your Menu Locations
function register_menu_location() {
  register_nav_menus(
    array(  
    	'date' => __( 'Date and Location' )
    )
  );
} 
add_action( 'init', 'register_menu_location' );

// Change icons to square (sign) icons
add_filter( 'storm_social_icons_type', create_function( '', 'return "icon-sign";' ) );


	//ENQUEUE JQUERY & CUSTOM SCRIPTS
	function enqueue_tmf_scripts() {
		wp_enqueue_script( 'tmf-main', get_stylesheet_directory_uri() . '/js/tmf-main.js', array('jquery'), false, true );

	}
	add_action('wp_enqueue_scripts', 'enqueue_tmf_scripts');


 ?>