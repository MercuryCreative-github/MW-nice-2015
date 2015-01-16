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
         	wp_register_style('main-css', get_stylesheet_directory_uri() . '/style.css', array(), '8.6', 'all');
            wp_enqueue_style('main-css'); // Enqueue it!

		// TMF custom styles
		wp_register_style('tmf-custom-css', get_stylesheet_directory_uri() . '/css/tmfcustom.css', array(), '8.6', 'all');
    	wp_enqueue_style('tmf-custom-css'); // Enqueue it!

    	// Pricing css
		if ( is_page_template( 'pricing-tables.php' ) ) {
		    wp_register_style('pricing-tables-css', get_stylesheet_directory_uri() . '/css/pricing-tables.css', array(), '8.6', 'all');
    		wp_enqueue_style('pricing-tables-css'); // Enqueue it!
		}

    	// Responsive fixes
		wp_register_style('tmf-responsive-css', get_stylesheet_directory_uri() . '/css/tmf-responsive.css', array(), '8.6', 'all');
    	wp_enqueue_style('tmf-responsive-css'); // Enqueue it!
    	
    	// Print Styles
		wp_register_style('tmf-print-css', get_stylesheet_directory_uri() . '/css/tmf-print.css', array(), '8.6', 'all');
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
<?php 

add_action('gform_after_submission_2', 'send_to_acton', 10, 2);

if (!function_exists('send_to_acton')) {
	function send_to_acton($entry,$form) 
	{
		//include ActonConnection class
		require_once (get_stylesheet_directory() .'class.Acton-WordPress-Connection.php');
		// declare new ActonWordPressConnection object
		$ao_gf1 = new ActonConnection;

		// format: setPostItems('your Act-On data field name','your custom form html input name')
		$ao_gf1->setPostItems('First Name Submitters',$entry['21.3']); // HTML input name attribute is "First Name", Act-On data field name should match that
		$ao_gf1->setPostItems('Last Name Submitters',$entry['21.6']); // please note that Act-On does not accept filed names with punctuation marks in them, so rename as necessary
		$ao_gf1->setPostItems('Job title Submitters',$entry['22']);
		$ao_gf1->setPostItems('Company Submitters',$entry['23']);
		$ao_gf1->setPostItems('Email Submitters',$entry['24']);
		$ao_gf1->setPostItems('First Name',$entry['1.3']);
		$ao_gf1->setPostItems('Last Name',$entry['1.6']);
		$ao_gf1->setPostItems('Job title',$entry['2']);
		$ao_gf1->setPostItems('Company',$entry['3']);
		$ao_gf1->setPostItems('Email',$entry['4']);
		$ao_gf1->setPostItems('Twitter',$entry['5']);
		$ao_gf1->setPostItems('Phone',$entry['6']);
		$ao_gf1->setPostItems('Mobile',$entry['7']);
		$ao_gf1->setPostItems('Blogs',$entry['8']);
		$ao_gf1->setPostItems('Bio',$entry['10']);
		$ao_gf1->setPostItems('Company Description',$entry['11']);
		$ao_gf1->setPostItems('Summit',$entry['9']);
		$ao_gf1->setPostItems('Session title',$entry['17']);
		$ao_gf1->setPostItems('Why are you right for this presentation?',$entry['13']);

		// processConnection method, with your external post URL passed as the argument
		$ao_gf1->processConnection('http://marketing.tmforum.org/acton/form/1332/00ed:d-0001/0/index.htm');
	}
}
?>