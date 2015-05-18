<?php

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
        $main_css_version = filemtime( get_stylesheet_directory() . '/style.css');
     	wp_register_style('main-css', get_stylesheet_directory_uri() . '/style.css', array(), $main_css_version, 'all');
        wp_enqueue_style('main-css'); // Enqueue it!

		// Exhibitors pages
		if ( is_page_template( 'exhibitors-template.php' ) ) {
		  	wp_register_style('aidesigns', get_stylesheet_directory_uri() . '/css/exhibitors-template.css', array(), $main_css_version, 'all');
    		wp_enqueue_style('aidesigns'); // Enqueue it!
		}

		// Pricing css
		if ( is_page_template( 'pricing-tables.php' ) ) {
		    wp_register_style('pricing-tables-css', get_stylesheet_directory_uri() . '/css/pricing-tables.css', array(), $main_css_version, 'all');
    		wp_enqueue_style('pricing-tables-css'); // Enqueue it!
		}

		// Speakers special css
		if ( is_page_template( 'speakers.php' ) || is_page_template( 'speakers-with-thumbs.php' )) {
		    wp_register_style('speakers-css', get_stylesheet_directory_uri() . '/css/speakers-keynotes.css', array(), $main_css_version, 'all');
    		wp_enqueue_style('speakers-css'); // Enqueue it!
		}

		// Platinum Program
		if ( is_page_template( 'platinum-program.php' ) ) {
		    wp_register_style('platinum-programme-css', get_stylesheet_directory_uri() . '/css/platinum-program.css', array(), $main_css_version, 'all');
    		wp_enqueue_style('platinum-program-css'); // Enqueue it!
		}

		// TMF custom styles
		wp_register_style('tmf-custom-css', get_stylesheet_directory_uri() . '/css/tmfcustom.css', array(), $main_css_version, 'all');
    	wp_enqueue_style('tmf-custom-css'); // Enqueue it!

    	// Responsive fixes
		wp_register_style('tmf-responsive-css', get_stylesheet_directory_uri() . '/css/tmf-responsive.css', array(), $main_css_version, 'all');
    	wp_enqueue_style('tmf-responsive-css'); // Enqueue it!

    	// Print Styles
		wp_register_style('tmf-print-css', get_stylesheet_directory_uri() . '/css/tmf-print.css', array(), $main_css_version, 'all');
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

/* Companies Posts Type */
add_action('init', 'cpt_companies');
function cpt_companies() {
register_post_type('companies', array(
	'label' => 'Companies',
	'menu_icon' => 'dashicons-megaphone',
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

	if (!current_user_can('edit_posts')) {
		show_admin_bar(false);
	}
	return $profile_fields;
}
add_filter('user_contactmethods', 'modify_contact_methods');
// End Remove Hide color options for users


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
add_action('admin_summit-slugter', 'profile_admin_buffer_end');



add_action('profile_update','create_company_on_user_save',20,1);
add_action( 'user_register', 'create_company_on_user_save',20,1);

// Create New Company from user edit/create
if(!function_exists("create_company_on_user_save")){
	function create_company_on_user_save($user_id){

	        $new_company=array();

	        $user = get_user_meta($user_id);

	        if(!empty($_POST['new_company'])){

	        	$args = array(
	        	 'post_title'    => $_POST['new_company'],
	        	 'post_type'  => 'companies',
	        	 'post_status'   => 'publish',

	        	 );

	        	$post_ID = wp_insert_post($args);

	        $new_company[]= $post_ID;
	        delete_user_meta($user_id, 'company');
	        add_user_meta($user_id, 'company', $new_company);
	      	delete_user_meta($user_id, 'new_company');

	    	}
	}
}

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

	$jobRoleMeta = get_user_meta( (int)$userId, "job_role",true );

	if( !empty( $jobRoleMeta )) {
		$jobRoleMeta = $jobRoleMeta;
		return ($jobRoleMeta);

	}
	return $jobRole;
}

/*acton subscription form */
// When sending Suscription form at the Sidebar
add_action("gform_after_submission_4", "custom_post_submission_newsletters_subscribe", 10, 2);

if (!function_exists('custom_post_submission_newsletters_subscribe')) {
    function custom_post_submission_newsletters_subscribe($entry, $form) {

    if($entry['2.1'] == true){
      $agile = $entry['2.1'];
    }else{
      $agile = 'false';
       }
    if($entry['3.1'] == true){
      $digital = $entry['3.1'];
    }else{
      $digital = 'false';
       }
    if($entry['4.1'] == true){
      $customer = $entry['4.1'];
    }else{
      $customer = 'false';
       }

    //include ActonConnection class
        require_once (get_stylesheet_directory() .'/core/classes/class.Acton-WordPress-Connection.php');
        // declare new ActonWordPressConnection object
        $ao_gf1 = new ActonConnection;
        //match fields
        // format: setPostItems('your Act-On data field name','your custom form html input name')
        // @param string
        $ao_gf1->setPostItems('Email', $entry['5']);
        // @param string true /false
        $ao_gf1->setPostItems('Digest Agile Business IT', $agile);
        // @param string true /false
        $ao_gf1->setPostItems('Digest Open Digital Ecosystem', $digital);
        // @param string true /false
        $ao_gf1->setPostItems('Digest Customer Engagement', $customer);
      //Update with ACTON form external URL
        // processConnection method, with your external post URL passed as the argument
        $ao_gf1->processConnection('http://marketing.tmforum.org/acton/eform/1332/00de/d-ext-0002');
    }
}

//Keep updated / join the mailing list
add_action("gform_after_submission_5", "join_the_mailing_list", 10, 2);

if(!function_exists('join_the_mailing_list')){
	function join_the_mailing_list($entry, $form) {

	    $check_boxes = array();

		if($entry['8.0'] !== ''){
	      $check_boxes[] = $entry['8.0'];
	    }
	    if($entry['8.1'] !== ''){
	     $check_boxes[]  = $entry['8.1'];
	    }
	    if($entry['8.2'] !== ''){
	      $check_boxes[]  = $entry['8.2'];
	    }
	    if($entry['8.3'] !== ''){
	      $check_boxes[]  = $entry['8.3'];
	    }
	    if($entry['8.4'] !== ''){
	      $check_boxes[]  = $entry['8.4'];
	    }
	    if($entry['8.5'] !== ''){
	     $check_boxes[]  = $entry['8.5'];
	    }
	    if($entry['8.6'] !== ''){
	     $check_boxes[]  = $entry['8.6'];
	    }

	    $check_boxes =  implode(", ",$check_boxes);

	    //include ActonConnection class
        require_once (get_stylesheet_directory() .'/core/classes/class.Acton-WordPress-Connection.php');
        $ao_gf1 = new ActonConnection;
        $ao_gf1 -> setPostItems('salutation', $entry['1']);
        $ao_gf1 -> setPostItems('fname', $entry['9']);
        $ao_gf1 -> setPostItems('lname', $entry['10']);
        $ao_gf1 -> setPostItems('email', $entry['4']);
        $ao_gf1 -> setPostItems('phone', $entry['5']);
        $ao_gf1 -> setPostItems('jobtitle', $entry['6']);
        $ao_gf1 -> setPostItems('company', $entry['7']);
        $ao_gf1 -> setPostItems('information', $check_boxes);
        $ao_gf1 -> processConnection('http://marketing.tmforum.org/acton/eform/1332/00e6/d-ext-0001');
	}
}


// [summits_shortcode summit-slug="summit-slug-value"]
function summits_shortcode_func( $atts ) {

	// var set and unset
	$SpeakerHtmlOutput='';
	$presentationsHtmlOutput='';

    // OutPut functions START HERE. Please read last.
    if (!function_exists('get_presentations')) {
    	function get_presentations($sessionStarts,$summit_slug,$sessionId,$sessionColor){

	    	$args = array(
				'post_type'  => 'agenda_tracks',
				'meta_key'	 => '_TMF_presentations_start_date',
				'orderby'	 => 'meta_value_num',
				'order' 		=> 'ASC',
				'meta_query' => array(
					array(
						'key'     => '_TMF_presentation_session',
						'value'   => $sessionId,
						'compare' => 'LIKE',
					),
				),
			);

			// This are all the presentations that have him/her listed as spekear/moderator/etc
			$presentationToCheck = new WP_Query( $args );
			$presentationsHtmlOutput='';

			// The Loop
			if ( $presentationToCheck->have_posts() ) {

				while ( $presentationToCheck->have_posts() ) {

					// variables unset
					unset($arrayByRole);
					$arrayByRole = array();
					$speacificArray='';

					// needed variables
					$presentationToCheck->the_post();
					$presentationSlug = $presentationToCheck->post_name;
					$presentationToCheckId=get_the_ID();
					$presentationTitle=get_the_title();
					$presentationContent=get_the_content();
					$presentationSubtitle=get_post_meta($presentationToCheckId,'_TMF_presentations_subtitle',true);
					$presentationStart=date('g:i a',get_post_meta($presentationToCheckId,'_TMF_presentations_start_date',true));
					$presentationEnd=date('g:i a',get_post_meta($presentationToCheckId,'_TMF_presentations_end_date',true));
					$role_to_update='';

					$roles=array('speaker','panelist','collaborator','facilitator','moderator');

					foreach ($roles as $role_to_update) {

						$role_to_fetch=	$role_to_update.'s_meta';
						$presentationSpeakers=get_post_meta($presentationToCheckId,$role_to_fetch,true);

						if(is_array($presentationSpeakers) && !empty($presentationSpeakers)){

							$speacificArray=$role_to_update;

							foreach ( $presentationSpeakers as $presentationSpeaker ) {

								// needed variables
								$userMeta = get_user_meta( $presentationSpeaker, $role_to_update.'_at',true);
								$userJobRole = get_user_meta( $presentationSpeaker, 'job_role',true);
								$userCompanies = get_user_meta( $presentationSpeaker, 'company',true);

								if(!empty($userCompanies)){
									// we are using just the first company.
									$userCompanyId = $userCompanies[0];
									$userCompanyName= get_the_title($userCompanyId);
								}

								$user = get_user_by( 'id', $presentationSpeaker );

								// if the user has the checked role in this presentation
								if(is_array($userMeta)){

									$hasThisRole=in_array($presentationToCheckId,$userMeta);

									$SpeakerHtmlOutput='';

									if($hasThisRole && is_object($user)){
										//speaker output to store
										$SpeakerHtmlOutput.='<p>- <a href="/speaker-profile/?id='.$user->ID.'">'.$user->display_name.'</a>, ';
										$SpeakerHtmlOutput.='<em>'.($userJobRole).'</em>, ';
										if(!empty($userCompanies)){$SpeakerHtmlOutput.='<strong>'.$userCompanyName.'</strong>';}
										$SpeakerHtmlOutput.='</p>';

										// this array contains inside one array per role and inside each of them, the speakers data.
										$arrayByRole[$speacificArray][]=$SpeakerHtmlOutput;
									
									} //close if($hasThisRole)

								} //close if(is_array($userMeta)

							} //close foreach ( $presentationSpeakers as $presentationSpeaker )
						
						} //close if(is_array($presentationSpeakers) && !empty($presentationSpeakers))

					} //close foreach ($roles as $role_to_update)

					$presentationSesion=$sessionId;
					$presentationLink = get_permalink();

					//Presentations output
					$presentationsHtmlOutput.='<div class="summit-presentation">';
					$presentationsHtmlOutput.='<div class="presentation-time" style="border-color:'.$sessionColor.';">'.$presentationStart.'</div>';
					$presentationsHtmlOutput.='<div class="presentation-info" id="'.$presentationSlug.'">';
					$presentationsHtmlOutput.='<div class="presentation-title" >';
					$presentationsHtmlOutput.='<a href="'.$presentationLink.'">'.$presentationTitle.'</a>';
					$presentationsHtmlOutput.='</div>';
					$presentationsHtmlOutput.='<div class="presentation-subtitle">'.$presentationSubtitle.'</div>';
					$presentationsHtmlOutput.='<div class="presentation-content" style="display:none">'.$presentationContent.'</div>';
					
					foreach ($roles as $rolesToshow) {

						$roleLabel=$rolesToshow;
						if(isset($arrayByRole[$rolesToshow]))
								if(count($arrayByRole[$rolesToshow])>1)
										$roleLabel=$rolesToshow.'s';
						

						if(!empty($arrayByRole[$rolesToshow])){
							$presentationsHtmlOutput.='<div class="presentation-speaker"><strong>'.ucwords($roleLabel).'</strong>';

							foreach ($arrayByRole[$rolesToshow] as $speakerData) {
								$presentationsHtmlOutput.=$speakerData;
							}

							$presentationsHtmlOutput.='</div>';
						} //close if
					} //close foreach

					$presentationsHtmlOutput.='</div>'; //close presentation-info
					$presentationsHtmlOutput.='</div>'; //close summit-presentation

			    }// close while ( $presentationToCheck->have_posts()
			} // close THE LOOP if ( $presentationToCheck->have_posts() 

    		wp_reset_query();

			return $presentationsHtmlOutput;
	}} // end if get_presentations

	if (!function_exists('get_chair')) {
	function get_chair($sessionChair){

		// variables set
		$chairHtmlOutput='';

		if(is_string($sessionChair) && $sessionChair!=='')

		// User query to get Chair
		$user_query = new WP_User_Query( array( 'include' => $sessionChair ) );

			if ( ! empty( $user_query->results ) ) {

				foreach ( $user_query->results as $user ) {

					// needed variables
					$chairJobRole = get_user_meta( $user->ID, 'job_role',true);
					$chairCompanies = get_user_meta( $user->ID, 'company',true);
					$chairCompanyName='';
					if(!empty($chairCompanies)){
						$chairCompanyId = $chairCompanies[0];
						$chairCompanyName= get_the_title($chairCompanyId);
					}

					//Chair output
					$chairHtmlOutput.='<div>';
					$chairHtmlOutput.='Chair: '.$user->display_name.', '.$chairJobRole.', '.$chairCompanyName;
					$chairHtmlOutput.='</div>';
				}
			}


		wp_reset_query();
		return $chairHtmlOutput;
	}}  // end get_chair

	if (!function_exists('get_sponsors')) {
	function get_sponsors($sessionSponsors){

		// variables set
		$sponsorsHtmlOutput='';

		if(is_array($sessionSponsors) && !empty($sessionSponsors) )

		// sponsors get
		foreach ($sessionSponsors as $sponsorId) {

			// needed variables
			$sponsorLogo = get_the_post_thumbnail( $sponsorId, 'medium');
			$sponsorUrl = get_post_meta( $sponsorId, 'url', true );
			$sponsorName = get_the_title( $sponsorId );

			//Sponsors output
			$sponsorsHtmlOutput.='<a href="'.$sponsorUrl.'" target="_blank">'.$sponsorLogo.'</a>';

		}
			wp_reset_query();
			return $sponsorsHtmlOutput;
	}} // end get_sponsors

    // OutPut functions FINISH HERE


    // Shortcode functionality HERE

    // shortcode variables
    $a = shortcode_atts( array(
        'summit_slug' => 'default',
        'link_to_presentation' => 'no',
    ), $atts );

    // summit var definitions bases on shortcode input.
    extract($a);

	// The Vars to run the Query that gets all the Presentations with this Forum Asociated based on the $summit_slug
	$args = array(
	'post_type' 	=> 'tmf_sessions',
	'order' 		=> 'ASC',
	'meta_key'	 	=> '_TMF_session_start_date',
	'orderby'	 	=> 'meta_value_num',
	'tax_query'		=> array(
			array(
				'taxonomy' => 'tmf_summit_category',
				'field'    => 'slug',
				'terms'    => $summit_slug,
			),
		),
	);

	// WP Query
	$loop = new WP_Query( $args );

	// Variables set
	$sessions='';
	$storedDay = '';
	$i=0;

	while ( $loop->have_posts() ) : $loop->the_post();

	// needed variables
	$i++;
	$sessionId = get_the_ID();
	$sessionTitle = get_the_title();
	$prefix = '_TMF_';
	$sessionStarts = get_post_meta( $sessionId, $prefix . 'session_start_date',true);
	$sessionChair = get_post_meta( $sessionId, $prefix . 'chair',true);
	$sessionSponsors = get_post_meta( $sessionId, $prefix . 'sponsors',true);
	$sessionColor = get_post_meta ( $sessionId, $prefix . 'summit_colorpicker',true);
	$sessionIcon = get_post_meta ( $sessionId, $prefix . 'summit_image',true);

	// If a new day stars, we write the DAY
	if($storedDay!==date('l,  F j',$sessionStarts)){
		$storedDay=date('l,  F j',$sessionStarts);

		if(isset($sessionIcon) && $sessionIcon != null){
			$sessions.= '<div class="summit-day"><p>';
			$sessions.= '<img src="'.$sessionIcon.'"/>';
		}else{
			$sessions.= '<div class="summit-day"><p style="padding: 0 0 5px 15px;">';
		}
		$sessions.= $storedDay.'</p></div>';
	}

	// Sessions output depends on functions
	$sessions.= '<div class="summit-session">';
	$sessions.= '<div class="session-name">'.$sessionTitle.'</div>';
	$sessions.= '<div class="session-chair" style="color:'.$sessionColor.';">'.get_chair($sessionChair).'</div>';
	$sessions.= '</div>';
	$sessions.= '<div class="session-sponsor">'.get_sponsors($sessionSponsors).'</div>';
	$sessions.= '<div class="clear"></div>';
	$sessions.= '<div id="session-'.$sessionId.'">'.get_presentations($sessionStarts,$summit_slug,$sessionId,$sessionColor).'</div>';

	if($i==1){
		$sessions.='<script>
		function hideShowContent(where,subtitleCheck){
			var $ = jQuery;

			// if in the link_to_presentation we write all it is not going to run the script
			if("all"!==subtitleCheck)
				$(".presentation-info", where).each(function(){
					var here=$(this);
					subtitle = $(".presentation-subtitle",here).text().toLowerCase();

					if(subtitle!==subtitleCheck)

						if($(".presentation-content",here).text()==""){
							text=$(".presentation-title a",this).text();
							$(".presentation-title a",this).before("<span>"+text+"</span>");
							$(".presentation-title a",this).remove();

						}
						else{
							$(".presentation-title",here).click(function(e){
								e.preventDefault();
								$(".presentation-content",here).slideToggle();
							});
						}
				})

			return true;
		}</script>';
	}

	wp_reset_query();

	$script='
		<script>

		jQuery("document").ready(function(){

			var declared;
			where = jQuery("#session-'.$sessionId.'");

			//after enter to the if call for the function, then run the function.
			//When the function run, it return true: now declared is not undefined so it is not going to run the function again.

			subtitleCheck = "'.$link_to_presentation.'".toLowerCase();

			if("all"!==subtitleCheck){
			jQuery(".presentation-content",where).hide();
			declared=hideShowContent(where,"'.$link_to_presentation.'");
			}

			/*var hash =  window.location.hash;
			// it is talking to the child called: presentation-content
			if(jQuery(hash).index()>0){jQuery(".presentation-content",hash).slideToggle()};*/
		})

		</script>';

	$sessions.=$script;

	$i++;
	endwhile;

	return $sessions;

} // end of shortcode

add_shortcode( 'summits_shortcode', 'summits_shortcode_func' );
?>
<?php

//STAR FEATURE

// [fetured_speaker_shortcode speaker_summit_slug="summit-slug-value"]
function fetured_speaker_shortcode_func( $atts ) {

    // OutPut functions START HERE. Please read last.
    if (!function_exists('get_featured')) {
    function get_featured($speaker_summit_slug,$sessionID){

    	$speakersDisplayArray=array();

    	$args = array(
			'post_type'  => 'agenda_tracks',
			'meta_key'	 => '_TMF_presentations_start_date',
			'orderby'	 => 'meta_value_num',
			'order' 		=> 'ASC',
			'meta_query' => array(
				array(
					'key'     => '_TMF_presentation_session',
					'value'   => $sessionID,
					'compare' => 'LIKE',
				),
			),
		);

    	// This are all the presentations that have him/her listed as spekear/moderator/etc
		$presentationToCheck = new WP_Query( $args );

		// Presentation Loop
		if ( $presentationToCheck->have_posts() ) {

			while ( $presentationToCheck->have_posts() ) {

		    	// Call the speakers
		    	$presentationToCheck->the_post();
		    	// Call the speakers
				$presentationId = get_the_ID();

				$args = array(
				'order ' => 'ASC',
				'role'=>'speaker',
				'meta_query' =>array(
					array(
						'value' => $presentationId ,
						'compare' => 'LIKE'),)
				);// meta_query);

				// The Query

				$user_query = new WP_User_Query( $args );

				// User Loop
				if ( ! empty( $user_query->results ) ) {
					foreach ( $user_query->results as $user ) {

						$categorySpeakers = get_user_meta($user->ID, '_TMF_speakers_categories', true);
						$categoryDisplay = '';

						if(is_array($categorySpeakers)){
							foreach ($categorySpeakers as $categorySpeaker) {
								if($categorySpeaker=='check1'){$categoryDisplay.=' featured';}
							}
						}

						if($categoryDisplay == ' featured'){

							// var set and unset
							$speakersDisplay='<div class="speakerTrack">';

							// Get the user id of the user and the id of the image
							$userMetaImageId = get_user_meta($user->ID,'image_id',true);
							$userMetaImage =  wp_get_attachment_image_src( $userMetaImageId, 'thumbnail' );
							// if $userMetaImage (an array) is empty/false

							if(!($userMetaImage)){
							$userMetaImage[] ='/wp-content/uploads/2014/09/default_speaker.png';
							}

							$speakersDisplay.= '<div class="speakerSidebar'.$categoryDisplay.'">';
								$speakersDisplay.= '<a href="/speaker-profile/?id='.$user->ID.'">';
									$speakersDisplay.='<img src="'.$userMetaImage[0].'">';
								$speakersDisplay.= '</a>';
								$speakersDisplay.= '<a href="/speaker-profile/?id='.$user->ID.'" style="color:#AEACAC;">' . $user->first_name.' '.$user->last_name.'</a>';

							// Get companies and user mapping along with job role as per new conventions
							// Get companies and job role
							$companyIds = getUserCompanies( esc_html( $user->ID ) );

							$i = 0;

							foreach( $companyIds as $companyId ) {
								if( (int)$companyId == 0 ) continue;
								$role = '';
								$company = '';

								$jobRole = getUserJobRolesByCompanyId( $user->ID, $companyId );
								if( empty( $jobRole ) ) {
									$jobRole = esc_html( $user->role );
								}

								if( !empty( $jobRole ) || (int)$companyId > 0 ) {
									if( $i == 0 ) {
										$role .= '<br>';
									} else {
										$role .= ' ';
									}
									$role .= '<em>'.$jobRole.'</em>';
									$company = ', <strong>'.get_the_title( $companyId ).'</strong>';  // cambia , por </br>
								}
								$speakersDisplay .= $role . $company;
								$i++;
							} // end foreach( $companyIds as $company )

							$speakersDisplay .= '</div><hr></div>';

						} // end if categoryDisplay == featured
					if(!empty($speakersDisplay))

					$speakersDisplayArray[$user->ID]=$speakersDisplay;

					} // end foreach user_query->results as user

				} //end if ! empty( $user_query->results )

			} // end while ( $presentationToCheck->have_posts

		} // end if ( $presentationToCheck->have_posts() )


		return $speakersDisplayArray;


	}} // end get_presentations

    // OutPut functions FINISH HERE


    // Shortcode functionality HERE

    // shortcode variables
    $a = shortcode_atts( array(
        'speaker_summit_slug' => 'default',
    ), $atts );

    // summit var definitions bases on shortcode input.
    extract($a);

	// The Vars to run the Query that gets all the Presentations with this Forum Asociated based on the $summit_slug
	$args = array(
	'post_type' 	=> 'tmf_sessions',
	'order' 		=> 'ASC',
	'meta_key'	 	=> '_TMF_session_start_date',
	'orderby'	 	=> 'meta_value_num',
	'tax_query'		=> array(
			array(
				'taxonomy' => 'tmf_summit_category',
				'field'    => 'slug',
				'terms'    => $speaker_summit_slug,
			),
		),
	);

	// WP Query
	$loop = new WP_Query( $args );

	// Variables set
	$theSessions='';
	$theSessions.='<h4 class="light"><strong>Featured</strong> Speakers:</h4><hr>';

	$speakersDisplayArray=array();

	$i=0;
	while ( $loop->have_posts() ) : $loop->the_post();

	// needed variables
	$sessionID = get_the_ID();

	// save the array with the speakers in a var.
	$speakersArray= get_featured($speaker_summit_slug,$sessionID);
	// add the elements of the new array with the ones of the previous one.
	$speakersDisplayArray=array_merge($speakersDisplayArray,$speakersArray);


	$i++;
	endwhile;

	//remove the element of the array that appear twice
	$speakersDisplayArray=array_unique($speakersDisplayArray);
	$theSessions.=implode('',$speakersDisplayArray);

	wp_reset_query();

	return $theSessions;

} // end of shortcode

add_shortcode( 'fetured_speaker_shortcode', 'fetured_speaker_shortcode_func' );

//END FEATURE

?>
<?php

if(!function_exists('update_presentation_on_user_save')){

	function update_presentation_on_user_save($user_id){

        if (!$user_id>0) return;

        $user = get_user_by('id', $user_id);

        // remove the speaker from all the presentations that he/she not longer belongs.
        function removeSpeaker($speaker_role,$user,$user_id){

	        $role_to_update=$speaker_role.'s_meta';
	        $justErasedFrom = array();

	        if(!function_exists(eraseFromPresent)){

				function eraseFromPresent($user_id,$presentationToCheckId,$role_to_update){

					echo 'hay que borrar '.$user_id.' de '.$presentationToCheckId.'<br>'; //die;

					$justErasedFrom[]=$presentationToCheckId;

					$presentationMeta = get_post_meta($presentationToCheckId, $role_to_update,true);

					if(is_array($presentationMeta)){

						$key = array_search($user_id, $presentationMeta);

						if(($key) !== false) {
							unset($presentationMeta[$key]);
							update_post_meta( $presentationToCheckId, $role_to_update, $presentationMeta );
						}
					}
				}
			}

	        $args = array(
				'post_type'  => 'agenda_tracks',
				'meta_key'   => $role_to_update,
				'meta_query' => array(
					array(
						'key'     => $role_to_update,
						'value'   => $user_id,
						'compare' => 'LIKE',
					),
				),
				'posts_per_page'=>-1,
			);


			// This are all the presentations that have him/her listed as spekear/moderator/etc
			$presentationToCheck = new WP_Query( $args );

			// The Loop
			if ( $presentationToCheck->have_posts() ) {

				while ( $presentationToCheck->have_posts() ) {

					$presentationToCheck->the_post();
					$presentationToCheckId=get_the_ID();

					// this is the new data sumbitted
					$role_at = $speaker_role.'_at';
					$new_data=($user->$role_at);

					// if(!empty($new_data)){
					// 	eraseFromPresent($user_id,$presentationToCheckId,$role_to_update);
					// }
					// else if(is_array($new_data)){
					// 	if(!in_array($presentationToCheckId,$new_data)){
					// 		eraseFromPresent($user_id,$presentationToCheckId,$role_to_update);
					// 	}
					// }

					if(!in_array($presentationToCheckId,$new_data)){

					echo 'hay que borrar '.$user_id.' de '.$presentationToCheckId.'<br>'; //die;

					$justErasedFrom[]=$presentationToCheckId;

					$presentationMeta = get_post_meta($presentationToCheckId, $role_to_update,true);

					$key = array_search($user_id, $presentationMeta);


					if(($key) !== false) {
								unset($presentationMeta[$key]);
								update_post_meta( $presentationToCheckId, $role_to_update, $presentationMeta );
							}
				}

				}

			}

			/* Restore original Post Data */
			wp_reset_postdata();

			return $justErasedFrom;

		} // removeSpeaker ends

        // add the speaker from all the presentations that he/she does not yet belong.
        function addSpeaker($speaker_role,$user,$user_id,$justErasedFrom){

        $role_to_update=$speaker_role.'s_meta';

        $args = array(
			'post_type'  => 'agenda_tracks',
			'post_status'=> 'publish',
			'post__not_in'	 => $justErasedFrom,
			'orderby' => 'ID',
			'order' => 'ASC',
			'posts_per_page'=>-1,
		);


		// This are all the presentations that DONT have him/her listed as spekear/moderator/etc
		$presentationToAdd = new WP_Query( $args );

		// The Loop
		if ( $presentationToAdd->have_posts() ) {

			while ( $presentationToAdd->have_posts() ) {

				$presentationToAdd->the_post();
				$presentationToAddId=get_the_ID();

				// this is the new data sumbitted
				$role_at = $speaker_role.'_at';
				$posted_data=$_POST[$role_at];

				$new_data= explode(',',$posted_data);

				if(!empty($posted_data))
				if(in_array($presentationToAddId,$new_data)){

					echo 'hay que agregar '.$user_id.' a '.$presentationToAddId.'<br>';
					$presentationMeta = get_post_meta($presentationToAddId, $role_to_update,true);

					$presentationMeta[]=$user_id;
					$presentationMeta=array_unique($presentationMeta);

					delete_post_meta($presentationToAddId, $role_to_update);
					add_post_meta( $presentationToAddId, $role_to_update, $presentationMeta );
					$updatedMeta = get_post_meta( $presentationToAddId, $role_to_update, true);
				}

			}

		}else {
			echo 'wrong query'; die;
		}

		/* Restore original Post Data */
		wp_reset_postdata();

		} // removeSpeaker ends


		$roles=array('speaker','panelist','collaborator','facilitator','moderator');

		foreach ($roles as $role_to_update) {
			$justErasedFrom = array();
			$justErasedFrom = removeSpeaker($role_to_update,$user,$user_id);
			addSpeaker($role_to_update,$user,$user_id,$justErasedFrom);

		}

	}
}

add_action('profile_update','update_presentation_on_user_save',10,1);
add_action('user_register', 'update_presentation_on_user_save',10,1);


/**
 * Save user metadata when a presentation is saved.
 *
 * @param int $post_id The post ID.
 * @param post $post The post object.
 * @param bool $update Whether this is an existing post being updated or not.
 */
function save_presentation( $post_id, $post, $update ) {

    	if(!function_exists('update_speakers_by_role')){


		    function update_speakers_by_role($role_to_update) {

				$speakerIds = explode (',',$_POST[$role_to_update.'s_meta']);
				$sizeSpeakers = count( $speakerIds );
				$presentationIds[] = $_POST['post_ID'];

				// remove the presentation to the unselected users
					$args = array(
					'meta_query' =>array(array('meta_key' => $role_to_update.'_at' ,'value' => $presentationId ,'compare' => 'LIKE'),)
					);

					$user_query = new WP_User_Query( $args );

					if ( ! empty( $user_query->results ) ) {
					foreach ( $user_query->results as $user ) {

						$userMeta = get_user_meta( $user->ID, $role_to_update.'_at' );

						if(!$userMeta){}


						else if( !empty( $userMeta ) ) {
							$presentationIds = $userMeta[0];
							if(is_array ( $presentationIds ))
							if(($key = array_search($_POST['post_ID'], $presentationIds)) !== false) {
								unset($presentationIds[$key]);
								update_user_meta( $user->ID, $role_to_update.'_at', $presentationIds );
							}
						}
						}
					}


				// add the preentation to the users selected
				if( $sizeSpeakers > 0 ) {
					for( $i = 0; $i < $sizeSpeakers; $i++ ) {
						$userMeta = get_user_meta( $speakerIds[$i], $role_to_update.'_at' );

						if( !empty( $userMeta ) ) {
							$presentationIds = $userMeta[0];
							if(is_array ( $presentationIds ))
							if( !in_array( $_POST['post_ID'], $presentationIds )) {
								$presentationIds[] = $_POST['post_ID'];
								update_user_meta( $speakerIds[$i], $role_to_update.'_at', $presentationIds );
							}
						}

						if(!$userMeta){
							$presentationIds[] = $_POST['post_ID'];
							add_user_meta( $speakerIds[$i], $role_to_update.'_at',  $presentationIds);

						}
					}
				}
		};

	};

		$roles=array('speaker','panelist','collaborator','facilitator','moderator');

		foreach ($roles as $role_to_update) {
			update_speakers_by_role($role_to_update);
		}
}

add_action( 'save_post', 'save_presentation', 10, 3 );



/**
 * Add custom fields to Yoast SEO analysis
 */

add_filter('wpseo_pre_analysis_post_content', 'add_custom_to_yoast');

function add_custom_to_yoast( $content ) {
	global $post;
	$pid = $post->ID;

	$custom = get_post_custom($pid);
	unset($custom['_yoast_wpseo_focuskw']); // Don't count the keyword in the Yoast field!

	foreach( $custom as $key => $value ) {


		if ( 'agenda_tracks' == get_post_type($pid) ) {
		// Returns true when 'agenda_tracks.php' is being used.

			if($key=='_TMF_presentation_session'){

				$custom_content .= 'Session Title: '.get_the_title($value[0]). '</br>';

			}
			else if($key=='speakers_meta' ||$key=='panelists_meta' ||$key=='collaborators_meta' ||$key=='facilitators_meta' ||$key=='moderators_meta' ){

				$title= substr($key,0,-6);
					foreach (unserialize($value[0]) as $speaker) {
							$custom_content .= $title . ' : ' . get_user_meta($speaker,'first_name',true) . ' ' . get_user_meta($speaker,'last_name',true). '</br>';
					}
			}
			else if($key=='_TMF_presentations_start_date'){

				$custom_content .= 'Presentation Starts: '.date('F j, Y, g:i a',$value[0]). '</br>';

			}
			else if($key=='_TMF_presentations_end_date'){

				$custom_content .= 'Presentation Ends: '.date('F j, Y, g:i a',$value[0]). '</br>';

			}

			else{
			  if (is_array($value)){
			  	$custom_content .= implode ( ',' , $value) . '</br>';
			  }else{
			  	$custom_content .=$value[0]. '</br>';
			  }
			}

		} else if( basename( get_page_template() ) == 'speakers-template.php') {

			// we may need code here

			$blogusers = get_users( 'role=Speaker' );
			// Save user ID to pass on data to Speaker page
			$user_id = esc_html( $user->ID );
			$avatar = get_user_meta($sid, 'image',1);

			foreach ( $blogusers as $user ) {

				$custom_content.= wp_get_attachment_image($user->image) . '<br/>';
				$custom_content.= esc_html( $user->display_name ) . '<br/>';

				// New mapping of user and companies with job role
				// Get companies and job role
				$companyIds = getUserCompanies( esc_html( $user->ID ), true );

				if( (int)$companyIds > 0 ) {
					$jobRole = getUserJobRolesByCompanyId( $user->ID, $companyIds );
					if( empty( $jobRole ) ) {
					 	$jobRole = esc_html( $user->role );
					}
					$custom_content.= esc_html( $jobRole ) . '<br/>';
					$custom_content.= get_the_title( $companyIds );
				}

			}

		} else if( basename( get_page_template() ) == 'homepage.php') {

		 	$custom_content.= '<div class="sec-main-content">
	<div class="section05-title"><h1>THE REVIEWS</h1></div>
	<ul class="reviews">
		<li style="display: list-item;">
			<div class="review-photo"><img src="/wp-content/uploads/2015/02/wolfgang-gentzsch.png"></div>
			<div class="review-content">
				<div class="review-text">“I was very impressed by the large number of IT and business leaders, and many of the presentations have left a permanent impression. The large number of IT celebrities around the world stood out. I can’t wait to come to Nice again next year!”</div>
				<div class="review-name"><img src="/wp-content/uploads/2015/02/icon-reviews.png"><p><strong>Wolfgang Gentzsch</strong><br>CEO, The UberCloud</p></div>
			</div>
		</li>
		<li style="display: none;">
			<div class="review-photo"><img src="/wp-content/uploads/2015/02/ulf_sm.gif"></div>
			<div class="review-content">
				<div class="review-text">"This year at TM Forum Live!, there are more participants than ever from other industries wanting to know what telecom networks can do for them. And that is happening because cloud, mobility and broadband are transforming their businesses.”</div>
				<div class="review-name"><img src="/wp-content/uploads/2015/02/icon-reviews.png"><p><strong>Ulf Ewaldsson</strong><br>SVP and CTO, Ericsson</p></div>
			</div>
		</li>
		<li style="display: none;">
			<div class="review-photo"></div>
			<div class="review-content">
				<div class="review-text">“Congrats on the 2014 event, the thematic was very well received and the event meticulously organized, great feedback from attendees, vendors and industry icons alike. The future looks bright!”</div>
				<div class="review-name"><img src="/wp-content/uploads/2015/02/icon-reviews.png"><p>CIO, Global Digital Service Provider</p></div>
			</div>
		</li>
	</ul>
</div>';

		} else {
		}


	}

	$content = $content . ' ' . $custom_content;

	// comment this line to hide results after finishing.
	//var_dump($content);
	return $content;

	remove_filter('wpseo_pre_analysis_post_content', 'add_custom_to_yoast'); // don't let WP execute this twice
}

/*---	Testimonial shortcode	---*/
function scTestimonials()
{
	$testimonial_query = new WP_Query(array(
			'post_type' => 'testimonials',
  			'post_status' => 'publish',
			'orderby' => 'rand',
  			'posts_per_page' => 1
		));


	if( $testimonial_query->have_posts() )
	{
		while($testimonial_query->have_posts())
		{
			$testimonial_query->the_post();
			$prefix = '_TMF_';
			$testimonial_id = get_the_ID();
			$testimonials_author_id = get_post_meta( $testimonial_id, $prefix . 'testimonial_author',true);

			$authorData = get_user_meta($testimonials_author_id);

			$authorName =  $authorData['first_name'][0].' '.$authorData['last_name'][0];
			$testimonialQuote = get_the_content();

			if($authorData['image'][0] != NULL){
				$imgSRC = $authorData['image'][0];
			}else{
				$imgSRC = '/wp-content/uploads/2014/09/default_speaker.png';
			}

			$authorRole = $authorData['job_role'][0];
			$companyId = getUserCompanies( $testimonials_author_id, true );
			$companyName =  get_the_title( $companyId );


		}
	}
	wp_reset_query();

	return $authorName.'-|-'.$testimonialQuote.'-|-'.$imgSRC.'-|-'.$authorRole.'-|-'.$companyName;
}
add_shortcode('show_testimonials','scTestimonials');
?>