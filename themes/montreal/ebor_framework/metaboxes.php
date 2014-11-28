<?php
//ADD ADMIN AREA CUSTOM JQUERY
function montreal_custom_metaboxes_jquery() {
if (is_admin()) {
        wp_enqueue_script('custom_script', get_template_directory_uri().'/ebor_framework/admin.js', array('jquery'));
    }
}
add_action('init', 'montreal_custom_metaboxes_jquery'); 

add_filter( 'cmb_render_imag_select_taxonomy_id', 'imag_render_imag_select_taxonomy_id', 10, 2 );
function imag_render_imag_select_taxonomy_id( $field, $meta ) {

    wp_dropdown_categories(array(
            'show_option_none' => '&#8212; Select &#8212;',
            'hierarchical' => 1,
            'taxonomy' => $field['taxonomy'],
            'orderby' => 'name', 
            'hide_empty' => 0, 
            'name' => $field['id'],
            'selected' => $meta  

        ));
    if ( !empty($field['desc']) ) echo '<p class="cmb_metabox_description">' . $field['desc'] . '</p>';

}
  
function montreal_custom_metaboxes( $meta_boxes ) {
	$prefix = '_cmb_'; // Prefix for all fields
	
	
	//////////////////////////////////////////////////////////////////////////
	////// CREATE METABOXES FOR GALLERY POST FORMAT /////////////////////////
	////////////////////////////////////////////////////////////////////////
	
	$meta_boxes[] = array(
		'id' => 'gallery_metabox',
		'title' => __('Gallery Images', 'montreal'),
		'pages' => array('post', 'portfolio'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Gallery Image 1', 'montreal'),
				'desc' => __('Upload an image or enter an URL.', 'montreal'),
				'id' => $prefix . 'gallery1',
				'type' => 'file',
				'save_id' => false, // save ID using true
				'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
			),
			array(
				'name' => __('Gallery Image 2', 'montreal'),
				'desc' => __('Upload an image or enter an URL.', 'montreal'),
				'id' => $prefix . 'gallery2',
				'type' => 'file',
				'save_id' => false, // save ID using true
				'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
			),
			array(
				'name' => __('Gallery Image 3', 'montreal'),
				'desc' => __('Upload an image or enter an URL.', 'montreal'),
				'id' => $prefix . 'gallery3',
				'type' => 'file',
				'save_id' => false, // save ID using true
				'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
			),
			array(
				'name' => __('Gallery Image 4', 'montreal'),
				'desc' => __('Upload an image or enter an URL.', 'montreal'),
				'id' => $prefix . 'gallery4',
				'type' => 'file',
				'save_id' => false, // save ID using true
				'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
			),
			array(
				'name' => __('Gallery Image 5', 'montreal'),
				'desc' => __('Upload an image or enter an URL.', 'montreal'),
				'id' => $prefix . 'gallery5',
				'type' => 'file',
				'save_id' => false, // save ID using true
				'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
			),
			array(
				'name' => __('Gallery Image 6', 'montreal'),
				'desc' => __('Upload an image or enter an URL.', 'montreal'),
				'id' => $prefix . 'gallery6',
				'type' => 'file',
				'save_id' => false, // save ID using true
				'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
			),
			array(
				'name' => __('Gallery Image 7', 'montreal'),
				'desc' => __('Upload an image or enter an URL.', 'montreal'),
				'id' => $prefix . 'gallery7',
				'type' => 'file',
				'save_id' => false, // save ID using true
				'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
			),
			array(
				'name' => __('Gallery Image 8', 'montreal'),
				'desc' => __('Upload an image or enter an URL.', 'montreal'),
				'id' => $prefix . 'gallery8',
				'type' => 'file',
				'save_id' => false, // save ID using true
				'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
			),
		),
	);
	
	
	//////////////////////////////////////////////////////////////////////////
	////// CREATE METABOXES FOR LINK POST FORMAT ////////////////////////////
	////////////////////////////////////////////////////////////////////////
	
	$meta_boxes[] = array(
		'id' => 'link_metabox',
		'title' => __('The Link', 'montreal'),
		'pages' => array('post'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Put your Link in here', 'montreal'),
				'desc' => __('Insert your Link URL in here, e.g. http://www.google.com', 'montreal'),
				'id'   => $prefix . 'the_link',
				'type' => 'text',
			),
		)
	);
	
	
	
	//////////////////////////////////////////////////////////////////////////
	////// CREATE METABOXES FOR QUOTE POST FORMAT ///////////////////////////
	////////////////////////////////////////////////////////////////////////
	
	$meta_boxes[] = array(
		'id' => 'quote_metabox',
		'title' => __('The Quote', 'montreal'),
		'pages' => array('post'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Put your Quote in here', 'montreal'),
				'desc' => __('Insert your quote for it to appear as the post header!', 'montreal'),
				'id'   => $prefix . 'the_quote',
				'type' => 'textarea',
			),
			array(
				'name' => __('Put the Quote Author in here', 'montreal'),
				'desc' => __("You don't have to give an Author if you don't want to!", 'montreal'),
				'id'   => $prefix . 'the_author',
				'type' => 'text',
			),
		)
	);
	
	
	
	//////////////////////////////////////////////////////////////////////////
	////// CREATE METABOXES FOR VIDEO POST FORMAT ///////////////////////////
	////////////////////////////////////////////////////////////////////////
	
	$meta_boxes[] = array(
		'id' => 'video_metabox',
		'title' => __('The Video Link', 'montreal'),
		'pages' => array('post', 'portfolio'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Put the Video Url in here', 'montreal'),
				'desc' => 'e.g. &lt;iframe src=&quot;http://player.vimeo.com/video/25624940?title=0&amp;amp;byline=0&amp;amp;portrait=0&quot; frameborder=&quot;0&quot; webkitAllowFullScreen mozallowfullscreen allowFullScreen&gt;&lt;/iframe&gt;',
				'id'   => $prefix . 'the_video',
				'type' => 'textarea_code',
			),
			array(
				'name' => __('Use Self-Hosted Video?', 'montreal'),
				'desc' => __('Tick this Checkbox to use self-hosted video', 'montreal'),
				'id'   => $prefix . 'the_hosted_video_switch',
				'type' => 'checkbox',
			),
			array(
				'name' => __('Put the Hosted .mp4 URL in here.', 'montreal'),
				'desc' => 'Upload an .mp4 to your "Media" library on your WP dashboard and enter the URL in here. e.g. http://mirror.cessen.com/blender.org/peach/trailer/trailer_iphone.m4v',
				'id'   => $prefix . 'the_hosted_mp4',
				'type' => 'text',
			),
			array(
				'name' => __('Put the Hosted .webm URL in here.', 'montreal'),
				'desc' => 'Upload an .webm to your "Media" library on your WP dashboard and enter the URL in here. e.g. http://clips.vorwaerts-gmbh.de/big_buck_bunny.webm',
				'id'   => $prefix . 'the_hosted_webm',
				'type' => 'text',
			),
			array(
				'name' => __('Put the Hosted .ogg URL in here.', 'montreal'),
				'desc' => 'Upload an .ogg to your "Media" library on your WP dashboard and enter the URL in here. e.g. http://mirror.cs.umn.edu/blender.org/peach/trailer/trailer_400p.ogg',
				'id'   => $prefix . 'the_hosted_ogg',
				'type' => 'text',
			),
		)
	);
	
	
	
	//////////////////////////////////////////////////////////////////////////
	////// CREATE METABOXES FOR CONTACT PAGE ////////////////////////////////
	////////////////////////////////////////////////////////////////////////
	
	$meta_boxes[] = array(
		'id' => 'contact_metabox',
		'title' => __('Contact Page Additional Details', 'montreal'),
		'pages' => array('page'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Enter your address', 'montreal'),
				'desc' => 'Do not use an apostrophe or speech mark, this will break the map!',
				'id'   => $prefix . 'the_gMaps',
				'type' => 'text',
			),
			array(
				'name' => __('Use "The Featured Image" instead of a map?', 'montreal'),
				'desc' => __("Ticking this will disable the google map, and use 'The Featured Image' instead.", 'montreal'),
				'id'   => $prefix . 'the_map_switch',
				'type' => 'checkbox',
			),
		)
	);
	
	
	//////////////////////////////////////////////////////////////////////////
	////// CREATE METABOXES FOR PAGES             ///////////////////////////
	////////////////////////////////////////////////////////////////////////
	
	$meta_boxes[] = array(
		'id' => 'page_metabox',
		'title' => __('Subtitles for Default Page Template', 'montreal'),
		'pages' => array('page'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('The Subtitle', 'montreal'),
				'desc' => __("Feel free to leave blank if you don't want a Subtitle", 'montreal'),
				'id'   => $prefix . 'the_subtitle',
				'type' => 'text',
			),
		)
	);
	
	
	//////////////////////////////////////////////////////////////////////////
	////// CREATE METABOXES FOR TEAM MEMBERS      ///////////////////////////
	////////////////////////////////////////////////////////////////////////
	
	$meta_boxes[] = array(
		'id' => 'team_metabox',
		'title' => __('Team Member Details', 'montreal'),
		'pages' => array('team'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('The Job Title', 'montreal'),
				'desc' => __("Enter this employees Job Title", 'montreal'),
				'id'   => $prefix . 'the_job_title',
				'type' => 'text',
			),
			array(
				'name' => __('This Employees First Social Profile Link', 'montreal'),
				'desc' => __("Needs http:// prefix", 'montreal'),
				'id'   => $prefix . 'the_team_social1_link',
				'type' => 'text',
			),
			array(
				'name' => __('This Employees First Social Profile Name', 'montreal'),
				'desc' => __("e.g Facebook", 'montreal'),
				'id'   => $prefix . 'the_team_social1_name',
				'type' => 'text',
			),
			array(
				'name' => __('This Employees Second Social Profile Link', 'montreal'),
				'desc' => __("Needs http:// prefix", 'montreal'),
				'id'   => $prefix . 'the_team_social2_link',
				'type' => 'text',
			),
			array(
				'name' => __('This Employees Second Social Profile Name', 'montreal'),
				'desc' => __("e.g Facebook", 'montreal'),
				'id'   => $prefix . 'the_team_social2_name',
				'type' => 'text',
			),
			array(
				'name' => __('This Employees Third Social Profile Link', 'montreal'),
				'desc' => __("Needs http:// prefix", 'montreal'),
				'id'   => $prefix . 'the_team_social3_link',
				'type' => 'text',
			),
			array(
				'name' => __('This Employees Third Social Profile Name', 'montreal'),
				'desc' => __("e.g Facebook", 'montreal'),
				'id'   => $prefix . 'the_team_social3_name',
				'type' => 'text',
			),
		)
	);
	
	
	
	//////////////////////////////////////////////////////////////////////////
	////// CREATE METABOXES FOR ABOUT PAGE        ///////////////////////////
	////////////////////////////////////////////////////////////////////////
	
	$meta_boxes[] = array(
		'id' => 'about_metabox',
		'title' => __('About Page Settings', 'montreal'),
		'pages' => array('page'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Show the "Team" section on the About-Page? ', 'montreal'),
				'desc' => __("Ticking this will display the Team section on the About Page", 'montreal'),
				'id'   => $prefix . 'the_team_switch',
				'type' => 'checkbox',
			),
			array(
				'name' => __('Enter a title for the team area.', 'montreal'),
				'desc' => __("e.g MEET OUR TEAM", 'montreal'),
				'id'   => $prefix . 'the_team_title',
				'type' => 'text',
			),
			array(
				'name' => __('Show the "Clients" section on the About-Page? ', 'montreal'),
				'desc' => __("Ticking this will display the Clients section on the About Page", 'montreal'),
				'id'   => $prefix . 'the_client_switch',
				'type' => 'checkbox',
			),
			array(
				'name' => __('Enter a title for the Clients area.', 'montreal'),
				'desc' => __("e.g SOME OF OUR CLIENTS", 'montreal'),
				'id'   => $prefix . 'the_clients_title',
				'type' => 'text',
			),
			array(
				'name' => __('Show the "Testimonials" section on the About-Page? ', 'montreal'),
				'desc' => __("Ticking this will display the Testimonials section on the About Page", 'montreal'),
				'id'   => $prefix . 'the_testimonial_switch',
				'type' => 'checkbox',
			),
			array(
				'name' => __('Enter a title for the Testimonials area.', 'montreal'),
				'desc' => __("e.g and what they say...", 'montreal'),
				'id'   => $prefix . 'the_testimonial_title',
				'type' => 'text',
			),
		)
	);
	
	
	//////////////////////////////////////////////////////////////////////////
	////// CREATE METABOXES FOR HOME PAGE  //////////////////////////////////
	////////////////////////////////////////////////////////////////////////
	
	$meta_boxes[] = array(
		'id' => 'home_metabox',
		'title' => __('Homepage Options', 'montreal'),
		'pages' => array('page'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Hide the Blog Section on the Home-Page? ', 'montreal'),
				'desc' => __("Ticking this will HIDE the blog section on the home page", 'montreal'),
				'id'   => $prefix . 'the_blog_switch',
				'type' => 'checkbox',
			),
			array(
				'name' => __('Hide the Portfolio Section on the Home-Page? ', 'montreal'),
				'desc' => __("Ticking this will HIDE the portfolio section on the home page", 'montreal'),
				'id'   => $prefix . 'the_portfolio_switch',
				'type' => 'checkbox',
			),
			array(
				'name' => __('Show the "Quote" section on the Home-Page? ', 'montreal'),
				'desc' => __("Ticking this will display the quote section on the homepage", 'montreal'),
				'id'   => $prefix . 'the_quote_switch',
				'type' => 'checkbox',
			),
			array(
				'name' => __('Enter the quote for the Home-Page', 'montreal'),
				'desc' => __("", 'montreal'),
				'id'   => $prefix . 'the_home_quote',
				'type' => 'text',
			),
			array(
				'name' => __('Show the "Twitter" section on the Home-Page?', 'montreal'),
				'desc' => __("Ticking this will display the twitter section on the homepage - but only if you've installed and properly configured this plugin; http://wordpress.org/extend/plugins/oauth-twitter-feed-for-developers/", 'montreal'),
				'id'   => $prefix . 'the_twitter_switch',
				'type' => 'checkbox',
			),
			array(
				'name' => __('Enter the Twitter id to be displayed on the homepage', 'montreal'),
				'desc' => __("Example: envato", 'montreal'),
				'id'   => $prefix . 'the_home_twitter_id',
				'type' => 'text',
			),
			array(
				'name' => 'Home Gallery Animation Type',
				'desc' => 'Animation Type for the Full-Screen Background Slideshow',
				'id' => $prefix . 'home_gallery_animation',
				'type' => 'select',
				'options' => array(
					array('name' => 'Carousel-Right', 'value' => '6'),
					array('name' => 'Carousel-Left', 'value' => '7'),
					array('name' => 'Fade', 'value' => '1'),
					array('name' => 'Slide-Top', 'value' => '2'),
					array('name' => 'Slide-Right', 'value' => '3'),
					array('name' => 'Slide-Bottom', 'value' => '4'),
					array('name' => 'Slide-Left', 'value' => '5'),
					array('name' => 'None', 'value' => '0')			
				)
			),
			array(
				'name' => 'Home Gallery Animation Delay',
				'desc' => 'Set the Delay for the Animation Between Each Slide',
				'id' => $prefix . 'home_gallery_animation_delay',
				'type' => 'select',
				'options' => array(
					array('name' => '1sec', 'value' => '1000'),
					array('name' => '2sec', 'value' => '2000'),
					array('name' => '3sec', 'value' => '3000'),
					array('name' => '4sec', 'value' => '4000'),
					array('name' => '5sec', 'value' => '5000'),
					array('name' => '6sec', 'value' => '6000'),
					array('name' => '7sec', 'value' => '7000'),
					array('name' => '8sec', 'value' => '8000')			
				)
			),
			array(
				'name' => __('Home Gallery Image 1', 'montreal'),
				'desc' => __('Upload an image or enter an URL.', 'montreal'),
				'id' => $prefix . 'home_gallery1',
				'type' => 'file',
				'save_id' => false, // save ID using true
				'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
			),
			array(
				'name' => __('Home Gallery Image 2', 'montreal'),
				'desc' => __('Upload an image or enter an URL.', 'montreal'),
				'id' => $prefix . 'home_gallery2',
				'type' => 'file',
				'save_id' => false, // save ID using true
				'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
			),
			array(
				'name' => __('Home Gallery Image 3', 'montreal'),
				'desc' => __('Upload an image or enter an URL.', 'montreal'),
				'id' => $prefix . 'home_gallery3',
				'type' => 'file',
				'save_id' => false, // save ID using true
				'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
			),
			array(
				'name' => __('Home Gallery Image 4', 'montreal'),
				'desc' => __('Upload an image or enter an URL.', 'montreal'),
				'id' => $prefix . 'home_gallery4',
				'type' => 'file',
				'save_id' => false, // save ID using true
				'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
			),
			array(
				'name' => __('Home Gallery Image 5', 'montreal'),
				'desc' => __('Upload an image or enter an URL.', 'montreal'),
				'id' => $prefix . 'home_gallery5',
				'type' => 'file',
				'save_id' => false, // save ID using true
				'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
			),
			array(
				'name' => __('Home Gallery Image 6', 'montreal'),
				'desc' => __('Upload an image or enter an URL.', 'montreal'),
				'id' => $prefix . 'home_gallery6',
				'type' => 'file',
				'save_id' => false, // save ID using true
				'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
			),
		),
	);
	
	//////////////////////////////////////////////////////////////////////////
	////// CREATE METABOXES FOR PORTFOLIO PAGES        //////////////////////
	////////////////////////////////////////////////////////////////////////
	
	$meta_boxes[] = array(
		'id' => 'portfolio_pages_metabox',
		'title' => __('Portfolio Page Options', 'montreal'),
		'pages' => array('page'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name'     => 'Display Which Portfolio Category?',
				'desc'     => 'Which Portfolio-Category should this Portfolio page display? Leave as is to display all categories.',
				'id'       => $prefix . 'the_taxonomy_category',
				'type'     => 'imag_select_taxonomy_id',
				'taxonomy' => 'portfolio-category', // Taxonomy Slug
			),
		)
	);
	
	//////////////////////////////////////////////////////////////////////////
	////// CREATE METABOXES FOR PORTFOLIO POST TYPE /////////////////////////
	////////////////////////////////////////////////////////////////////////
	
	$meta_boxes[] = array(
		'id' => 'portfolio_metabox',
		'title' => __('Additional Portfolio Item Details', 'montreal'),
		'pages' => array('portfolio'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Set the Portfolio Display Type',
				'desc' => 'What Single-Portfolio Template Should This Portfolio Display As?',
				'id' => $prefix . 'the_portfolio_size',
				'type' => 'select',
				'options' => array(
					array('name' => 'Basic', 'value' => 'basic'),
					array('name' => 'Wide', 'value' => 'wide'),
					array('name' => 'Full', 'value' => 'full')			
				)
			),
			array(
				'name' => __('Full Portfolio Type Header Image', 'montreal'),
				'desc' => __("A header image for the 'full' portfolio display type", 'montreal'),
				'id' => $prefix . 'full_header',
				'type' => 'file',
				'save_id' => false, // save ID using true
				'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
			),
			array(
				'name' => __('Stripe Portfolio Type Image', 'montreal'),
				'desc' => __("Upload an image if you're using the 'Stripe' Portfolio Page; Dimensions 225x960px", 'montreal'),
				'id' => $prefix . 'stripe_gallery',
				'type' => 'file',
				'save_id' => false, // save ID using true
				'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
			),
		)
	);
	
	
	//////////////////////////////////////////////////////////////////////////
	////// CREATE METABOXES FOR CLIENT POST TYPE ////////////////////////////
	////////////////////////////////////////////////////////////////////////
	
	$meta_boxes[] = array(
		'id' => 'client_metabox',
		'title' => __('Client Link', 'montreal'),
		'pages' => array('clients'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Add a Link to this Client Logo?', 'montreal'),
				'desc' => __("Leave blank if you don;t want a link; your links need http:// e.g http://www.madeinebor.com", 'montreal'),
				'id'   => $prefix . 'the_client_link',
				'type' => 'text',
			),
		)
	);


	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'montreal_custom_metaboxes' );

// Initialize the metabox class
add_action( 'init', 'be_initialize_cmb_meta_boxes', 9999 );
function be_initialize_cmb_meta_boxes() {
	if ( !class_exists( 'cmb_Meta_Box' ) ) {
		require_once( 'metabox/init.php' );
	}
}
?>