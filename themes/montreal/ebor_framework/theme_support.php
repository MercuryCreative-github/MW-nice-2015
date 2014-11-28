<?php 

	/////////////////////////////////////////////
	////////ADD THEME SUPPORT///////////////////
	///////////////////////////////////////////
	
	//ADD FEATURED IMAGES
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'client', 160, 80, true);
	
	//POST FORMATS
	add_theme_support( 'post-formats', array( 'gallery', 'video', 'image' ) );
	
	//FEED LINKS
	add_theme_support( 'automatic-feed-links' );
	
	add_editor_style('editor-style.css');
	
	if ( ! isset( $content_width ) ) $content_width = 940;
	
	add_action('after_setup_theme', 'montreal_setup');
	function montreal_setup(){
		load_theme_textdomain('montreal', get_template_directory() . '/languages');
	}