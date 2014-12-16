<?php 
	//ENQUEUE JQUERY & CUSTOM SCRIPTS
	function ebor_load_scripts() {
		$protocol = is_ssl() ? 'https' : 'http';
		
		wp_enqueue_style( 'ebor-font1', "$protocol://fonts.googleapis.com/css?family=Oswald:400,300,700" );
		wp_enqueue_style( 'ebor-font2', "$protocol://fonts.googleapis.com/css?family=Droid+Serif:400italic,700italic" );
		wp_enqueue_style( 'ebor-font3', "$protocol://fonts.googleapis.com/css?family=Ubuntu" );
		wp_enqueue_style( 'ebor-mediaelementplayer', get_template_directory_uri() . '/player/skin/mediaelementplayer.css' );
		wp_enqueue_style( 'ebor-plugins', get_template_directory_uri() . '/css/plugins.css' );
		wp_enqueue_style( 'ebor-styles', get_template_directory_uri() . '/styles.php' );
		wp_enqueue_style( 'ebor-style', get_stylesheet_uri() );
		wp_enqueue_style( 'ebor-custom', get_template_directory_uri() . '/custom.css' );
		
		wp_enqueue_script( 'ebor-modernizr', get_template_directory_uri() . '/js/libs/modernizr-2.0.6.min.js', array('jquery') );
		wp_enqueue_script( 'ebor-mediaelement', get_template_directory_uri() . '/player/lib/mediaelement.js', array('jquery') );
		wp_enqueue_script( 'ebor-mediaelementplayer', get_template_directory_uri() . '/player/lib/mediaelementplayer.js', array('jquery') );
		wp_enqueue_script( 'ebor-maps', 'http://maps.google.com/maps/api/js?sensor=true', array('jquery'), false, true );
		wp_enqueue_script( 'ebor-gumby', get_template_directory_uri() . '/js/libs/gumby.min.js', array('jquery'), false, true );
		wp_enqueue_script( 'ebor-gumby-tabs', get_template_directory_uri() . '/js/libs/gumby.tabs.js', array('jquery'), false, true );
		wp_enqueue_script( 'ebor-gumby-toggle', get_template_directory_uri() . '/js/libs/gumby.toggleswitch.js', array('jquery'), false, true );
		wp_enqueue_script( 'ebor-plugins', get_template_directory_uri() . '/js/plugins.js', array('jquery'), false, true );
		wp_enqueue_script( 'ebor-main', get_template_directory_uri() . '/js/main.js', array('jquery'), false, true );
		if( is_page_template('page-home.php') )
			wp_enqueue_script( 'ebor-supersized', get_template_directory_uri() . '/js/supersized.js', array('jquery') );
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) 
			wp_enqueue_script( 'comment-reply' );
	}
	add_action('wp_enqueue_scripts', 'ebor_load_scripts');
	
	function ebor_load_non_standard_scripts() {
		echo '<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->';
	}
	add_action('wp_head', 'ebor_load_non_standard_scripts');