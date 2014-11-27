<?php


   
function hide_menu_items() {
	//remove_menu_page( 'edit.php?post_type=team' );
	remove_menu_page( 'edit.php?post_type=jobs' );
	remove_menu_page( 'edit.php?post_type=clients' );
	remove_menu_page( 'edit.php?post_type=portfolio' );
	remove_menu_page( 'edit.php?post_type=testimonials' );
	remove_menu_page( 'edit.php?post_type=faqs' );
	remove_menu_page( 'edit-comments.php' );
}
	add_action( 'admin_menu', 'hide_menu_items' );


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

	add_action('wp_enqueue_scripts', 'tmf_enqueue_general_scripts');


	// check if single-cat-slug exist to apply it all posts under that category
	add_filter('single_template', 'check_for_category_single_template');
		function check_for_category_single_template( $t )
		{
		  foreach( (array) get_the_category() as $cat )
		  {
		    if ( file_exists(STYLESHEETPATH . "/single-{$cat->slug}.php") ) return STYLESHEETPATH . "/single-{$cat->slug}.php";
		    if($cat->parent)
		    {
		      $cat = get_the_category_by_ID( $cat->parent );
		      if ( file_exists(STYLESHEETPATH . "/single-{$cat->slug}.php") ) return STYLESHEETPATH . "/single-{$cat->slug}.php";
		    }
		  }
		  return $t;
	}



	function sfs_enqueue_styles() {
		wp_dequeue_style('main-css');
         	wp_register_style('main-css', get_stylesheet_directory_uri() . '/style.css', array(), '7.7', 'all');
            wp_enqueue_style('main-css'); // Enqueue it!

		// Exhibitors pages
		if ( is_page_template( 'exhibitors-template.php' ) ) {
		  	wp_register_style('aidesigns', get_stylesheet_directory_uri() . '/css/exhibitors-template.css', array(), '7.7', 'all');
    		wp_enqueue_style('aidesigns'); // Enqueue it!
		}

		// Pricing css
		if ( is_page_template( 'pricing-tables.php' ) ) {
		    wp_register_style('pricing-tables-css', get_stylesheet_directory_uri() . '/css/pricing-tables.css', array(), '7.7', 'all');
    		wp_enqueue_style('pricing-tables-css'); // Enqueue it!
		}

		// Speakers special css
		if ( is_page_template( 'speakers.php' ) || is_page_template( 'speakers-with-thumbs.php' )) {
		    wp_register_style('speakers-css', get_stylesheet_directory_uri() . '/css/speakers-keynotes.css', array(), '7.7', 'all');
    		wp_enqueue_style('speakers-css'); // Enqueue it!
		}

		// Platinum Program
		if ( is_page_template( 'platinum-program.php' ) ) {
		    wp_register_style('platinum-programme-css', get_stylesheet_directory_uri() . '/css/platinum-program.css', array(), '7.7', 'all');
    		wp_enqueue_style('platinum-program-css'); // Enqueue it!
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



	/* CUSTOM MENU SETUP
	================================================== */

	
	function setup_menus2() {
		// This theme uses wp_nav_menu() in four locations.
		register_nav_menus( array(
		'exhibitors_menu' => __( 'Exhibitors Menu', "swiftframework" )
		) );
		register_nav_menus( array(
		'eventsponsors_menu' => __( 'Event Sponsors Menu', "swiftframework" )
		) );
		register_nav_menus( array(
		'agenda_menu' => __( 'Agenda Menu', "swiftframework" )
		) );
		register_nav_menus( array(
		'mediacenter_menu' => __( 'Media Center Menu', "swiftframework" )
		) );
		register_nav_menus( array(
		'justify_menu' => __( 'Justify Menu', "swiftframework" )
		) );
		register_nav_menus( array(
		'main_agenda' => __( 'Main Agenda Menu', "swiftframework" )
		) );
		register_nav_menus( array(
		'platinum-programme' => __( 'Platinum Programme', "swiftframework" )
		) );
	}

	add_action( 'after_setup_theme', 'setup_menus2' );

	//Masorny
	//function mason_script() {wp_enqueue_script( 'jquery-masonry' );}
	//add_action( 'wp_enqueue_scripts', 'mason_script' );
	// commented cause this script is causing problems with the carousel default feature from the original template


	function remove_some_widgets(){

        // Unregister Flexform sidebars
        unregister_sidebar( 'sidebar-1' );
        unregister_sidebar( 'sidebar-2' );
        unregister_sidebar( 'sidebar-3' );
        unregister_sidebar( 'sidebar-4' );
        unregister_sidebar( 'sidebar-5' );
        unregister_sidebar( 'sidebar-6' );
        unregister_sidebar( 'sidebar-7' );
        unregister_sidebar( 'sidebar-8' );
        unregister_sidebar( 'sidebar-9' );

	}
	add_action( 'widgets_init', 'remove_some_widgets', 11 );

	register_sidebar( array(
	    'name'         => __( 'Default Sidebar' ),
	    'id'           => 'default',
	    'description'  => __( 'Default sidebar to be substituted by custom sidebars' ),
	    'before_title' => '<h1>',
	    'after_title'  => '</h1>',
	) );


function calendar_create_widget(){
    include_once(plugin_dir_path( __FILE__ ).'/widgets/calendar.php');
    register_widget('calendar_widget');
}
add_action('widgets_init','calendar_create_widget');

function twitter_create_widget(){
    include_once(plugin_dir_path( __FILE__ ).'/widgets/twitter.php');
    register_widget('twitter_widget');
}
add_action('widgets_init','twitter_create_widget');

function menu_titles_create_widget(){
    include_once(plugin_dir_path( __FILE__ ).'/widgets/list_of_icons/menu_titles.php');
    register_widget('menu_titles_widget');
}
add_action('widgets_init','menu_titles_create_widget');

function menu_icons_widget_create_widget(){
    include_once(plugin_dir_path( __FILE__ ).'/widgets/list_of_icons/menu_of_icons.php');
    register_widget('menu_icons_widget');
}
add_action('widgets_init','menu_icons_widget_create_widget');

function separator_create_widget(){
    include_once(plugin_dir_path( __FILE__ ).'/widgets/list_of_icons/separator.php');
    register_widget('separator_widget');
}
add_action('widgets_init','separator_create_widget');



/* HIDE ADMIN MERCURY USERS */

add_action('pre_user_query','yoursite_pre_user_query');
function yoursite_pre_user_query($user_search) {
  global $current_user;
  $username = $current_user->user_login;

  if ($username !== 'bsastre' && $username !== 'agiannastasio' && $username !== 'mvallve' && $username !== 'jgoldfein'&& $username !== 'lmazzilli') { 
    global $wpdb;
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'tmforum'",$user_search->query_where);
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'mercurycreative'",$user_search->query_where);
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'mercury-develop'",$user_search->query_where);
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'abolani'",$user_search->query_where);
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'bsastre'",$user_search->query_where);
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'lmazzilli'",$user_search->query_where);
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'sarnatechnologies'",$user_search->query_where);
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'rohit'",$user_search->query_where);
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'ron-ron'",$user_search->query_where);
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'mvallve'",$user_search->query_where);
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'fdagata'",$user_search->query_where);
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'imedrano'",$user_search->query_where);
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'marualgorta'",$user_search->query_where);
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'amylamperti'",$user_search->query_where);
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'jgoldfein'",$user_search->query_where);
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'wpengine'",$user_search->query_where);
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'pamato'",$user_search->query_where);
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'agiannastasio'",$user_search->query_where);
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'alaxalde'",$user_search->query_where);
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'ffazzini'",$user_search->query_where);
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'kgonzalez'",$user_search->query_where);
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'kmitchell'",$user_search->query_where);
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'lcaffa'",$user_search->query_where);
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'mbertinat'",$user_search->query_where);
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'mcanobra'",$user_search->query_where);
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'mmusillo'",$user_search->query_where);
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'priyaekbote'",$user_search->query_where);
  }  
}

/* Agenda Tracks Posts Type */
add_action('init', 'cpt_agenda_tracks');
function cpt_agenda_tracks() {
register_post_type('agenda_tracks', array(
	'label' => 'Agenda Tracks',
	'menu_icon' => 'dashicons-book',
	'description' => 'Post type for Agenda Tracks.',
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
/* Companies Posts Type */
add_action('init', 'cpt_companies');
function cpt_companies() {
register_post_type('companies', array(
	'label' => 'Companies',
	'menu_icon' => 'dashicons-portfolio',
	'description' => 'Post type for Companies.',
	'public' => true,
	'show_ui' => true,
	'show_in_menu' => true,
	'show_in_admin_bar' => true,
	'can_export' => true,
	'delete_with_user' => false,
	'capability_type' => 'post',
	'map_meta_cap' => true,
	'hierarchical' => false,
	'rewrite' => array('slug' => 'companies', 'with_front' => true),
	'query_var' => true,
	'supports' => array('title','editor','thumbnail','revisions'),
	'labels' => array (
	  'name' => 'Companies',
	  'singular_name' => 'Company',
	  'menu_name' => 'Companies',
	  'add_new' => 'Add Company',
	  'add_new_item' => 'Add New Company',
	  'edit' => 'Edit',
	  'edit_item' => 'Edit Company',
	  'new_item' => 'New Company',
	  'view' => 'View Company',
	  'view_item' => 'View Company',
	  'search_items' => 'Search Companies',
	  'not_found' => 'No Companies Found',
	  'not_found_in_trash' => 'No Companies Found in Trash',
	  'parent' => 'Parent Company',
)
) ); }

function companies_taxonomy() {
    register_taxonomy(
        'categories-companies', // Taxonomy name - should be in slug form
        'companies', // post type
        array(
            'hierarchical' => true,
            'label' => 'Categories (Companies)',  // Display name
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'companies', // This controls the base slug that will display before each term
                'with_front' => false // Don't display the category base before
            )
        )
    );
}
add_action( 'init', 'companies_taxonomy');

// Add Custom User for Speaker instead of Custom Post Type
$result = add_role(
    'Speaker',
    __( 'Speaker' ),
    array(
        'read'         => true,  // true allows this capability
        'edit_posts'   => false,
        'delete_posts' => false, // Use false to explicitly deny
    )
);

// Hide color options for users
function admin_del_options() {
   global $_wp_admin_css_colors;
   $_wp_admin_css_colors = 0;
}

add_action('admin_head', 'admin_del_options');
// End Hide color options for users

// Remove Hide color options for users
function modify_contact_methods($profile_fields) {
	unset($profile_fields['googleplus']);
	unset($profile_fields['facebook']);
	unset($profile_fields['twitter']);

	if (!current_user_can(‘edit_posts’)) {
		show_admin_bar(false);
	}
	return $profile_fields;
}
add_filter('user_contactmethods', 'modify_contact_methods');
// End Remove Hide color options for users


// Avoid Yoast/SEO add OG metadata
// ** Please do ** check this is not affecting any other SEO feature before moving onto staging site
add_filter('wpseo_pre_analysis_post_content', 'mysite_opengraph_content');
function mysite_opengraph_content($val) {
    return '';
}


function remove_plain_bio($buffer) {
	$titles = array('#<h3>About Yourself</h3>#','#<h3>About the user</h3>#');
	$buffer=preg_replace($titles,'<h3>Password</h3>',$buffer,1);
	$biotable='#<h3>Password</h3>.+?<table.+?/tr>#s';
	$buffer=preg_replace($biotable,'<h3>Password</h3> <table class="form-table">',$buffer,1);
	return $buffer;
}

function profile_admin_buffer_start() { ob_start("remove_plain_bio"); }

function profile_admin_buffer_end() { ob_end_flush(); }

add_action('admin_head', 'profile_admin_buffer_start');
add_action('admin_footer', 'profile_admin_buffer_end');


// Create New Company from user edit/create

function create_company_on_user_save($user_id){
        if (!$user_id>0)
                return;

        $user = get_user_by('id', $user_id);

        if($user->new_company){

        	$post = array(
        	 'post_title'    => $user->new_company,
        	 'post_type'  => 'companies',
        	 'post_status'   => 'publish',

        	 );

        	$post_ID = wp_insert_post($post);

        update_usermeta( $user_id, 'new_company','' );
        update_usermeta( $user_id, 'company', $post_ID  );

    	}
}

add_action('profile_update','create_company_on_user_save',10,1);
add_action( 'user_register', 'create_company_on_user_save',10,1);

function getUserCompanies( $userId = 0, $isSingle = false ) {
	$unserializedArray = array();
	if( (int) $userId == 0 ) return $unserializedArray;
	
	$companiesMeta = get_user_meta( $userId, "company" );
	
	if( !empty( $companiesMeta ) ) {
		$companies = $companiesMeta[0];
		if( !is_array( $companies ) ) {
			$unserializedArray = unserialize( $companies );
			if( is_array( $unserializedArray )) {
				return ( $isSingle ? $unserializedArray[0] : $unserializedArray );
			} else {
				return array( $companies );
			}
		} else {
			return ( $isSingle ? $companies[0] : $companies );
		}
	} else {
		$unserializedArray[0] = '';
	}
	
	return ( $isSingle ? $unserializedArray[0] : $unserializedArray );
}

function getUserJobRolesByCompanyId( $userId = 0, $companyId = 0 ) {
	$jobRole = '';
	if( (int) $companyId == 0 || (int)$userId == 0 ) return $jobRole;
	
	$jobRoleMeta = get_user_meta( (int)$userId, "job_role" );
	
	if( !empty( $jobRoleMeta )) {
		$jobRoleMeta = $jobRoleMeta[0];
		foreach( $jobRoleMeta as $compId => $jobRoleVal ) {
			if( (int)$compId == (int)$companyId )
				return $jobRoleVal;
		}
	}
	return $jobRole;
}


?>
