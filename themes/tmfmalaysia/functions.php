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


/* TMF LOAD SCRIPTS
	================================================== */

	function tmf_enqueue_general_scripts() {

		//TMF CUSTOM JS REGISTER
		wp_register_script('jquery.nicescroll.js', get_stylesheet_directory_uri() . '/js/jquery.nicescroll.js', 'jquery', NULL, FALSE);
		wp_register_script('tmfcustomjs', get_stylesheet_directory_uri() . '/js/tmfcustom.js?ver=5', 'jquery', NULL, FALSE);

	    // TMF CUSTOM JS ENQUEUE
		if (! is_page_template( 'pricingt.php' ) || ! is_page_template( 'agendag.php' )) {
		wp_enqueue_script('jquery.nicescroll.js');
		wp_enqueue_script('tmfcustomjs?ver=5');
		}
	}


	//ENQUEUE JQUERY & CUSTOM SCRIPTS
	function enqueue_tmf_scripts() {
		wp_enqueue_script( 'tmf-main', get_stylesheet_directory_uri() . '/js/tmf-main.js', array('jquery'), false, true );

	}
	add_action('wp_enqueue_scripts', 'enqueue_tmf_scripts');

		function sfs_enqueue_styles() {
		wp_dequeue_style('main-css');
         	wp_register_style('main-css', get_stylesheet_directory_uri() . '/style.css', array(), '7.7', 'all');
            wp_enqueue_style('main-css'); // Enqueue it!

		// Pricing css
		if ( is_page_template( 'pricing-tables.php' ) ) {
		    wp_register_style('pricing-tables-css', get_stylesheet_directory_uri() . '/css/pricing-tables.css', array(), '7.7', 'all');
    		wp_enqueue_style('pricing-tables-css'); // Enqueue it!
		}

		// TMF custom styles
		wp_register_style('tmf-custom-css', get_stylesheet_directory_uri() . '/css/tmfcustom.css', array(), '7.7', 'all');
    	wp_enqueue_style('tmf-custom-css'); // Enqueue it!

    	// Responsive fixes
		wp_register_style('tmf-responsive-css', get_stylesheet_directory_uri() . '/css/tmf-responsive.css', array(), '7.7', 'all');
    	wp_enqueue_style('tmf-responsive-css'); // Enqueue it!
    	
    	// Print Styles
		wp_register_style('tmf-print-css', get_stylesheet_directory_uri() . '/css/tmf-print.css', array(), '7.7', 'all');
    	wp_enqueue_style('tmf-print-css'); // Enqueue it!

	}

	add_action('wp_enqueue_scripts', 'sfs_enqueue_styles');

/* Agenda Tracks Posts Type */
add_action('init', 'cpt_presentations');
function cpt_presentations() {
register_post_type('Presentations', array(
	'label' => 'Presentation',
	'menu_icon' => 'dashicons-book',
	'description' => 'Post type for Presentation.',
	'public' => true,
	'show_ui' => true,
	'show_in_menu' => true,
	'show_in_admin_bar' => true,
	'can_export' => true,
	'delete_with_user' => false,
	'capability_type' => 'post',
	'map_meta_cap' => true,
	'hierarchical' => false,
	'rewrite' => array('slug' => 'presentations', 'with_front' => true),
	'query_var' => true,
	'supports' => array('title','editor','revisions'),
	'labels' => array (
		'name' => 'Presentations',
		'singular_name' => 'Presentation',
		'menu_name' => 'Presentations',
		'add_new' => 'Add Presentation',
		'add_new_item' => 'Add New Presentation',
		'edit' => 'Edit',
		'edit_item' => 'Edit Presentation',
		'new_item' => 'New Presentation',
		'view' => 'View Presentations',
		'view_item' => 'View Presentation',
		'search_items' => 'Search Presentations',
		'not_found' => 'No Presentations Found',
		'not_found_in_trash' => 'No Presentations Found in Trash',
		'parent' => 'Parent Presentation',
)
) ); }


 ?>